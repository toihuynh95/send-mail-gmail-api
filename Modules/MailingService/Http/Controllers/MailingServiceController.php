<?php

namespace Modules\MailingService\Http\Controllers;

use App\Http\Controllers\BaseController;
use Modules\MailingService\Entities\MailingService;
use Modules\MailingService\Http\Requests\StoreMailingServiceRequest;
use Modules\MailingService\Http\Requests\UpdateMailingServiceRequest;
use Modules\Project\Entities\Project;

class MailingServiceController extends BaseController
{
    public function store(StoreMailingServiceRequest $request){
        $mailing_service_data = $request->dataOnly();
        $mailing_service = MailingService::create($mailing_service_data);
        return $this->responseSuccess($mailing_service, "Thêm thông tin gói dịch vụ thành công!");
    }

    public function update(UpdateMailingServiceRequest $request, $mailing_service_id){
        $mailing_service = MailingService::find($mailing_service_id);
        if(is_null($mailing_service)){
            return $this->responseBadRequest('Gói dịch vụ không tồn tại.');
        }
        $mailing_service_data = $request->dataOnly();
        $mailing_service->update($mailing_service_data);
        return $this->responseSuccess($mailing_service, "Cập nhật thông tin gói dịch vụ thành công!");
    }

    public function destroy($mailing_service_id){
        $mailing_service = MailingService::find($mailing_service_id);
        if(is_null($mailing_service)){
            return $this->responseBadRequest('Gói dịch vụ không tồn tại.');
        }
        $mailing_service_count = Project::where('mailing_service_id', $mailing_service_id)->count();
        if($mailing_service_count > 0){
            return $this->responseBadRequest('Không được xóa. Vẫn còn dự án sử dụng gói dịch vụ này!');
        }
        $mailing_service->delete();
        return $this->responseSuccess($mailing_service, "Cập nhật thông tin gói dịch vụ thành công!");
    }

    public function show(){
        $mailing_service = MailingService::orderBy('mailing_service_id', 'desc')->get();
        return datatables()->of($mailing_service)->toJson();
    }

    public function showID($mailing_service_id){
        $mailing_service = MailingService::find($mailing_service_id);
        if(is_null($mailing_service)){
            return $this->responseBadRequest('Gói dịch vụ không tồn tại.');
        }
        return $this->responseSuccess($mailing_service, "Thông tin chi tiết của gói dịch vụ.");
    }

    public function showAll(){
        $mailing_service = MailingService::orderBy('mailing_service_id', 'desc')->get();
        return $this->responseSuccess($mailing_service, 'Danh sách các gói dịch vụ.');
    }
}
