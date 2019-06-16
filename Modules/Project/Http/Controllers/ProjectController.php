<?php

namespace Modules\Project\Http\Controllers;

use App\Http\Controllers\BaseController;
use Modules\Campaign\Entities\Campaign;
use Modules\ContactGroupDetail\Entities\ContactGroupDetail;
use Modules\Customer\Entities\Customer;
use Modules\MailingService\Entities\MailingService;
use Modules\Project\Entities\Project;
use Modules\Project\Http\Requests\StatisticRequest;
use Modules\Project\Http\Requests\StoreProjectRequest;
use Modules\Project\Http\Requests\UpdateProjectRequest;
use Modules\ProjectType\Entities\ProjectType;
use Modules\Statistic\Entities\Action;
use Modules\Statistic\Entities\Statistic;

class ProjectController extends BaseController
{
    public function store(StoreProjectRequest $request){
        $project_data = $request->dataOnly();
        $mailing_service = MailingService::find($project_data['mailing_service_id']);
        $project_data['project_number_email_remaining'] = $mailing_service->mailing_service_amount;
        $project = Project::create($project_data);
        return $this->responseSuccess($project, "Thêm dự án mới thành công!");
    }

    public function update(UpdateProjectRequest $request, $project_id){
        $project = Project::find($project_id);
        if(is_null($project)){
            return $this->responseBadRequest("Thông tin dự án không tồn tại!");
        }
        $project_data = $request->dataOnly();
        if(isset($project_data['mailing_service_id']) && $project_data['mailing_service_id'] != $project->mailing_service_id){
            $mailing_service = MailingService::find($project_data['mailing_service_id']);
            $project_data['project_number_email_remaining'] = $mailing_service->mailing_service_amount;
        }
        $project->update($project_data);
        return $this->responseSuccess($project, "Cập nhật thông tin dự án thành công!");
    }

    public  function destroy($project_id){
        $project = Project::find($project_id);
        if(is_null($project)){
            return $this->responseBadRequest("Thông tin dự án không tồn tại!");
        }
        $project_count = Campaign::where('project_id', $project_id)->count();
        if ($project_count > 0){
            return $this->responseBadRequest('Không thể xóa. Trong dự án vẫn còn chiến dịch đang hoạt động.');
        }
        Action::where('project_id', $project->project_id)->delete();
        Statistic::where('project_id', $project->project_id)->delete();
        $project->delete();
        return $this->responseSuccess($project, 'Xóa dự án thành công!');
    }

    public function show(){
        $project = Project::orderBy('project_id', 'desc')->get();
        foreach ($project as $key => $value){
            $project[$key]['project_created_at'] = date('d-m-Y', strtotime($project[$key]['project_created_at']));
            $customer = Customer::find($value->customer_id);
            $project[$key]['customer_email'] = $customer->customer_email;

            $project_type = ProjectType::find($value->project_type_id);
            $project[$key]['project_type_name'] = $project_type->project_type_name;

            $mailing_service = MailingService::find($value->mailing_service_id);
            $remaining = $mailing_service->mailing_service_amount - $value->project_number_email_remaining;
            $project[$key]['mailing_service_name'] = $mailing_service->mailing_service_name . ' ( '. $remaining . ' / ' . $mailing_service->mailing_service_amount . ' )';
        }
        return datatables()->of($project)->toJson();
    }

    public function showID($project_id){
        $project = Project::find($project_id);
        if (is_null($project)){
            return $this->responseBadRequest('Thông tin dự án không tồn tại.');
        }
        return $this->responseSuccess($project, "Thông tin dự án.");
    }

    public function showByCustomerCurrent(){
        $customer = $this->getCustomerCurrent();
        $project = Project::where('customer_id', $customer->customer_id)->orderBy('project_id', 'desc')->get();
        foreach ($project as $key => $value){
            $project[$key]['project_created_at'] = date('d-m-Y', strtotime($project[$key]['project_created_at']));
            $project_type = ProjectType::find($value->project_type_id);
            $project[$key]['project_type_name'] = $project_type->project_type_name;

            $mailing_service = MailingService::find($value->mailing_service_id);
            $remaining = $mailing_service->mailing_service_amount - $value->project_number_email_remaining;
            $project[$key]['mailing_service_name'] = $mailing_service->mailing_service_name . ' ( '. $remaining . ' / ' . $mailing_service->mailing_service_amount . ' )';
        }
        return datatables()->of($project)->toJson();
    }

    public function showList(){
        $customer = $this->getCustomerCurrent();
        $project = Project::where('customer_id', $customer->customer_id)->select('project_id','project_name', 'project_status')->orderBy('project_id', 'desc')->get();
        return $this->responseSuccess($project, 'Danh sách các dự án theo khách hàng hiện tại.');
    }

    public function checkProjectContactGroup($project_id, $contact_group_id){
        $project = Project::find($project_id);
        $contact_group_detail_count = ContactGroupDetail::where('contact_group_id', $contact_group_id)->count();
        if($project->project_number_email_remaining < $contact_group_detail_count){
            return $this->responseBadRequest('Số email còn lại của dự án không đủ để gửi với nhóm liên hệ hiện tại.');
        }
        return $this->responseSuccess($project->project_number_email_remaining, $contact_group_detail_count);
    }

    public static function updateRemainingByMonth(){
        $projects = Project::all();
        foreach ($projects as $project){
            $mailing_service = MailingService::find($project->mailing_service_id);
            $project->update(['project_number_email_remaining' => $mailing_service->mailing_service_amount]);
        }
    }
}
