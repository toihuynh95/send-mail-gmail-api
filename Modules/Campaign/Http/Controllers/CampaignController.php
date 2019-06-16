<?php

namespace Modules\Campaign\Http\Controllers;

use App\Http\Controllers\BaseController;
use Modules\Campaign\Entities\Campaign;
use Modules\Campaign\Entities\CampaignLog;
use Modules\Campaign\Http\Requests\StoreCampaignRequest;
use Modules\Campaign\Http\Requests\UpdateCampaignRequest;
use Modules\Contact\Entities\Contact;
use Modules\ContactGroup\Entities\ContactGroup;
use Modules\ContactGroupDetail\Entities\ContactGroupDetail;
use Modules\Project\Entities\Project;
use Modules\Statistic\Entities\Action;

class CampaignController extends BaseController
{
    public function store(StoreCampaignRequest $request){
        $campaign_data = $request->dataOnly(true);
        $project = Project::where('project_id', $campaign_data['project_id'])->where('customer_id', $campaign_data['customer_id'])->where('project_status', Project::$ACTIVATED)->first();
        if(is_null($project)){
            return $this->responseBadRequest('Dự án không tồn tại hoặc đang tạm khóa.');
        }
        $contact_group = ContactGroup::where('contact_group_id', $campaign_data['contact_group_id'])->where('customer_id', $campaign_data['customer_id'])->first();
        if(is_null($contact_group)){
            return $this->responseBadRequest('Nhóm liên hệ không tồn tại.');
        }
        $contact_group_detail_count = ContactGroupDetail::where('contact_group_id', $campaign_data['contact_group_id'])->count();
        if($project->project_number_email_remaining < $contact_group_detail_count){
            return $this->responseBadRequest('Số email còn lại của dự án không đủ để gửi với nhóm liên hệ hiện tại.');
        }
        \DB::beginTransaction();
        $project->update(['project_number_email_remaining' => $project->project_number_email_remaining - $contact_group_detail_count]);
        Action::create(['project_id' => $project->project_id, 'action_value' => $contact_group_detail_count]);
        try{
            $campaign = Campaign::create($campaign_data);
            $contact_group_details = ContactGroupDetail::where('contact_group_id', $campaign_data['contact_group_id'])->get();
            foreach ($contact_group_details as $key => $value){
                $contact = Contact::find($value->contact_id);
                unset($contact['customer_id']);
                $campaign_log_data = $contact->toArray();
                $campaign_log_data['campaign_id'] = $campaign->campaign_id;
                CampaignLog::create($campaign_log_data);
            }
            \DB::commit();
        }catch (\Illuminate\Database\QueryException $exception){
            \DB::rollback();
            return $this->responseServerError($exception->getMessage());
        }

        return $this->responseSuccess($campaign, 'Tạo chiến dịch thành công!');
    }

    public function update(UpdateCampaignRequest $request, $campaign_id){
        $customer = $this->getCustomerCurrent();
        $campaign_data = $request->dataOnly();
        $campaign = Campaign::join('projects', 'campaigns.project_id', 'projects.project_id')
            ->where('projects.customer_id', $customer->customer_id)
            ->where('campaigns.campaign_id', $campaign_id)
            ->first();
        if(is_null($campaign)){
            return $this->responseBadRequest('Chiến dịch không tồn tại!');
        }
        $campaign->update($campaign_data);
        return $this->responseSuccess($campaign, 'Cập nhật thông tin chiến dịch thành công!');
    }

    public function show(){
        $customer = $this->getCustomerCurrent();
        $campaign = Campaign::orderBy('campaign_id', 'desc')->get();
        foreach ($campaign as $key => $value){
            $project = Project::find($value->project_id);
            $campaign[$key]['project_name'] = $project->project_name;
            if($project->customer_id != $customer->customer_id){
                unset($campaign[$key]);
            }
        }
        return datatables()->of($campaign)->toJson();
    }

    public function showID($campaign_id){
        $campaign = Campaign::find($campaign_id);
        return $this->responseSuccess($campaign, 'Thông tin chi tiết của chiến dịch');
    }

    public function showLog($campaign_id){
        $campaign_log = CampaignLog::where('campaign_id', $campaign_id)->orderBy('campaign_log_id', 'desc')->get();
        return datatables()->of($campaign_log)->toJson();
    }

    public function countSend($campaign_id){
        $unsent = CampaignLog::where('campaign_id', $campaign_id)->where('campaign_log_status', CampaignLog::$UNSENT)->count();
        $sent = CampaignLog::where('campaign_id', $campaign_id)->where('campaign_log_status', CampaignLog::$SENT)->count();
        $failure = CampaignLog::where('campaign_id', $campaign_id)->where('campaign_log_status', CampaignLog::$FAILURE)->count();
        $percent_unsent = round($unsent / ($unsent + $sent + $failure) * 100);
        $percent_failure = round($failure / ($unsent + $sent + $failure) * 100);
        $percent_sent = 100 - ($percent_failure + $percent_unsent);
        $count_data = [
            'unsent' => [
                "value" => $unsent,
                "percent" => $percent_unsent,
            ],
            'sent' => [
                "value" => $sent,
                "percent" => $percent_sent,
            ],
            'failure' => [
                "value" => $failure,
                "percent" => $percent_failure,
            ],
            'total' => $unsent + $sent + $failure
        ];
        return $this->responseSuccess($count_data, 'Kết quả gửi mail của chiến dịch.');
    }
}
