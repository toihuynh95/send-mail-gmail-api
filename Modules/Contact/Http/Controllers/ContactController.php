<?php

namespace Modules\Contact\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\BaseController;
use Modules\Contact\Entities\Contact;
use Modules\Contact\Http\Requests\ImportContactRequest;
use Modules\Contact\Http\Requests\StoreContactRequest;
use Modules\Contact\Http\Requests\UpdateContactRequest;
use Modules\ContactGroupDetail\Entities\ContactGroupDetail;

class ContactController extends BaseController
{
    public function store(StoreContactRequest $request){
        $contact_data = $request->dataOnly(true);
        $contact_check_exists = Contact::where('customer_id', $contact_data['customer_id'])->where('contact_email', $contact_data['contact_email'])->first();
        if(!is_null($contact_check_exists)){
            return $this->responseBadRequest("Liên hệ đã tồn tại. Vui lòng kiểm tra lại!");
        }
        $contact = Contact::create($contact_data);
        if(isset($contact_data['contact_group_id'])){
            $contact_group_detail_data = [
                'contact_group_id' => $contact_data['contact_group_id'],
                'contact_id' => $contact->contact_id
            ];
            ContactGroupDetail::create($contact_group_detail_data);
        }
        return $this->responseSuccess($contact, "Thêm thông tin liên hệ thành công!");
    }

    public function update(UpdateContactRequest $request, $contact_id){
        $customer = $this->getCustomerCurrent();
        $contact = Contact::where('contact_id', $contact_id)->where('customer_id', $customer->customer_id)->first();
        if(is_null($contact)){
            return $this->responseBadRequest("Thông tin liên hệ không tồn tại!");
        }
        $contact_data = $request->dataOnly();
        $contact->update($contact_data);
        return $this->responseSuccess($contact, "Cập nhật thông tin liên hệ thành công!");
    }

    public function show(){
        $customer = $this->getCustomerCurrent();
        $contact = Contact::where("customer_id", $customer->customer_id)->orderBy('contact_id', 'desc')->get();
        return datatables()->of($contact)->toJson();
    }

    public function showExceptInGroup($contact_group_id){
        $list_contact_exists_in_group = [];
        $contact_group_detail = ContactGroupDetail::where('contact_group_id', $contact_group_id)->get();
        foreach ($contact_group_detail as $key => $value){
            $list_contact_exists_in_group[] = $value->contact_id;
        }
        $customer = $this->getCustomerCurrent();
        $contact = Contact::where("customer_id", $customer->customer_id)->whereNotIn('contact_id', $list_contact_exists_in_group)->orderBy('contact_id', 'desc')->get();
        return datatables()->of($contact)->toJson();
    }

    public function showID($contact_id){
        $customer = $this->getCustomerCurrent();
        $contact = Contact::where('contact_id', $contact_id)->where('customer_id', $customer->customer_id)->first();
        if(is_null($contact)){
            return $this->responseBadRequest("Thông tin liên hệ không tồn tại!");
        }
        return $this->responseSuccess($contact, "Thông tin chi tiết của liên hệ.");
    }

    public function import(ImportContactRequest $request){
        $contact_data = $request->dataOnly(true);
        $contact_file = Helper::uploadFile($request->contact_file, 'import');
        $excel = \Excel::load($contact_file, function($resader) {})->get();
        if(!empty($excel) && $excel->count()) {
            $arr_contact_id = []; // Lấy ID Contact sau khi thêm toàn bộ file để thêm vào nhóm nếu có
            foreach ($excel->toArray() as $item => $row) {
                if (!empty($row) && $item != 0) {
                    unset($row['no']);
                    $row['customer_id'] = $contact_data['customer_id'];
                    $contact_check_exists = Contact::where('customer_id', $row['customer_id'])->where('contact_email', $row['contact_email'])->first();
                    if(is_null($contact_check_exists)){
                        $contact = Contact::create($row);
                        $arr_contact_id[] = $contact->contact_id;
                    }else{
                        $arr_contact_id[] = $contact_check_exists->contact_id;
                    }
                }
            }
            if(isset($contact_data['contact_group_id'])){
                foreach ($arr_contact_id as $key => $value){
                    $contact_group_detail_check_exists = ContactGroupDetail::where('contact_id', $value)->where('contact_group_id', $contact_data['contact_group_id'])->first();
                    if(is_null($contact_group_detail_check_exists)){
                        $contact_group_detail_data = [
                            'contact_group_id' => $contact_data['contact_group_id'],
                            'contact_id' => $value
                        ];
                        ContactGroupDetail::create($contact_group_detail_data);
                    }
                }
            }
            return $this->responseSuccess($arr_contact_id, "Nhập dữ liệu liên hệ thành công!");
        }
        return $this->responseBadRequest("Tệp rỗng hoặc không đúng định dạng.");
    }

    public function export(){
        $data = Contact::orderBy('contact_id', 'desc')->get();
        $file_name = "EMK_Export_".date('Y-m-d_H-i-s')."_".Helper::randCode(5);
        $objWriter = \Excel::create($file_name,function ( $excel ) use ( $data ){
            $excel->sheet( "EMK",function ( $sheet ) use ( $data ){
                $sheet->loadView( 'emk_export',[ 'data' => $data ] );
            } );
        } );
        $objWriter->save('xlsx', storage_path( "app/public/exports" ) );
        $path = url('').'/storage/app/public/exports/'.$file_name.'.xlsx';
        return $this->responseSuccess($path,'Successful export file!');
    }

    public function destroy($contact_id){
        $customer = $this->getCustomerCurrent();
        $contact= Contact::where('contact_id', $contact_id)->where('customer_id', $customer->customer_id)->first();
        if(is_null($contact)){
            return $this->responseBadRequest("Thông tin liên hệ không tồn tại!");
        }
        $contact_count = ContactGroupDetail::where('contact_id', $contact_id)->count();
        if($contact_count > 0){
            return $this->responseBadRequest("Xóa liên hệ không thành công. Số liên hệ còn lại trong các nhóm là: " . $contact_count);
        }
        $contact->delete();
        return $this->responseSuccess($contact, "Xóa liên hệ thành công!");
    }
}
