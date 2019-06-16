<?php

namespace Modules\ContactGroup\Http\Controllers;

use App\Http\Controllers\BaseController;
use Modules\ContactGroup\Entities\ContactGroup;
use Modules\ContactGroup\Http\Requests\StoreContactGroupRequest;
use Modules\ContactGroup\Http\Requests\UpdateContactGroupRequest;
use Modules\ContactGroupDetail\Entities\ContactGroupDetail;

class ContactGroupController extends BaseController
{
    public function store(StoreContactGroupRequest $request){
        $contact_group_data = $request->dataOnly(true);
        $contact_group = ContactGroup::create($contact_group_data);
        return $this->responseSuccess($contact_group, "Thêm nhóm liên hệ thành công!");
    }

    public function update(UpdateContactGroupRequest $request, $contact_group_id){
        $customer = $this->getCustomerCurrent();
        $contact_group = ContactGroup::where('contact_group_id', $contact_group_id)->where('customer_id', $customer->customer_id)->first();
        if(is_null($contact_group)){
            return $this->responseBadRequest("Nhóm liên hệ không tồn tại!");
        }
        $contact_group_data = $request->dataOnly();
        $contact_group->update($contact_group_data);
        return $this->responseSuccess($contact_group, "Cập nhật thông tin nhóm liên hệ thành công!");
    }

    public function show(){
        $customer = $this->getCustomerCurrent();
        $contact_group = ContactGroup::where("customer_id", $customer->customer_id)->orderBy('contact_group_id', 'desc')->get();
        return datatables()->of($contact_group)->toJson();
    }

    public function showID($contact_group_id){
        $customer = $this->getCustomerCurrent();
        $contact_group = ContactGroup::where('contact_group_id', $contact_group_id)->where('customer_id', $customer->customer_id)->first();
        if(is_null($contact_group)){
            return $this->responseBadRequest("Nhóm liên hệ không tồn tại!");
        }
        return $this->responseSuccess($contact_group, "Thông tin chi tiết nhóm liên hệ.");
    }

    public function showIsActive(){
        $customer = $this->getCustomerCurrent();
        $contact_group = ContactGroup::where("customer_id", $customer->customer_id)->where('contact_group_status', ContactGroup::$IS_ACTIVE)->orderBy('contact_group_id', 'desc')->get();
        foreach ($contact_group as $key => $value){
            $count_contact_in_group = ContactGroupDetail::where("contact_group_id", $value->contact_group_id)->count();
            $contact_group[$key]['contact_group_amount'] = $count_contact_in_group;
        }
        return $this->responseSuccess($contact_group, "Danh sách nhóm liên hệ đang hoạt động.");
    }

    public function showAll(){
        $customer = $this->getCustomerCurrent();
        $contact_group = ContactGroup::where("customer_id", $customer->customer_id)->orderBy('contact_group_id', 'desc')->get();
        foreach ($contact_group as $key => $value){
            $count_contact_in_group = ContactGroupDetail::where("contact_group_id", $value->contact_group_id)->count();
            $contact_group[$key]['contact_group_amount'] = $count_contact_in_group;
            $contact_group[$key]['contact_group_name'] = $contact_group[$key]['contact_group_name'] . ' ( ' . $count_contact_in_group. ' )';
        }
        return $this->responseSuccess($contact_group, "Danh sách nhóm liên hệ đang hoạt động.");
    }

    public function destroy($contact_group_id){
        $customer = $this->getCustomerCurrent();
        $contact_group = ContactGroup::where('contact_group_id', $contact_group_id)->where('customer_id', $customer->customer_id)->first();
        if(is_null($contact_group)){
            return $this->responseBadRequest("Nhóm liên hệ không tồn tại!");
        }
        $contact_group_count = ContactGroupDetail::where('contact_group_id', $contact_group_id)->count();
        if($contact_group_count > 0){
            return $this->responseBadRequest("Xóa nhóm không thành công. Số liên hệ còn lại trong nhóm: " . $contact_group_count);
        }
        $contact_group->delete();
        return $this->responseSuccess($contact_group, "Xóa nhóm liên hệ thành công!");
    }
}
