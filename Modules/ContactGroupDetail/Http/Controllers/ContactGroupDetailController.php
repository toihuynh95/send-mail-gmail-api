<?php

namespace Modules\ContactGroupDetail\Http\Controllers;

use App\Http\Controllers\BaseController;
use Modules\Contact\Entities\Contact;
use Modules\ContactGroupDetail\Entities\ContactGroupDetail;
use Modules\ContactGroupDetail\Http\Requests\StoreContactGroupDetailRequest;
use Modules\Customer\Entities\Customer;

class ContactGroupDetailController extends BaseController
{
    public function store(StoreContactGroupDetailRequest $request){
        $contact_group_detail_data = $request->dataOnly();
        $contact_group_detail = ContactGroupDetail::create($contact_group_detail_data);
        return $this->responseSuccess($contact_group_detail, "Thêm liên hệ vào nhóm thành công!");
    }

    public function showByContactGroup($contact_group_id){
        $contact_group_detail = ContactGroupDetail::where('contact_group_id', $contact_group_id)->get();
        foreach ($contact_group_detail as $key => $value){
            $contact = Contact::find($value->contact_id);
            foreach ($contact->toArray() as $k => $v){
                $contact_group_detail[$key][$k] = $v;
            }
        }
        return datatables()->of($contact_group_detail)->toJson();
    }

    public function destroy($contact_group_detail_id){
        $customer = $this->getCustomerCurrent();
        $contact_group_detail = ContactGroupDetail::join('contact_groups', 'contact_group_details.contact_group_id', 'contact_groups.contact_group_id')
            ->where('contact_group_details.contact_group_detail_id', $contact_group_detail_id)
            ->where('contact_groups.customer_id', $customer->customer_id)->first();
        if(is_null($contact_group_detail)){
            return $this->responseBadRequest("Người dùng trong nhóm không tồn tại.");
        }
        $contact_group_detail->delete();
        return $this->responseSuccess($contact_group_detail, "Xóa người dùng ra khỏi nhóm thành công!");
    }
}
