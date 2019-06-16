<?php

namespace Modules\Statistic\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\BaseController;
use Modules\Campaign\Entities\CampaignLog;
use Modules\Project\Entities\Project;
use Modules\Statistic\Entities\Statistic;
use Modules\Statistic\Http\Requests\ViewByMonthStatisticRequest;
use DB;
use Carbon\Carbon;

class StatisticController extends BaseController
{
    public function viewByMonthTotal(ViewByMonthStatisticRequest $request){
        $data_statistic = $request->dataOnly();
        $list_day=[];
        $year = $data_statistic['statistic_year'];
        $month = $data_statistic['statistic_month'];
        for($day = 1; $day <= 31; $day++)
        {
            $timestamp  = mktime(12, 0, 0, $month, $day, $year);
            if (date('m', $timestamp) == $month)
                $list_day[]=date('d', $timestamp);
        }
        $result_chart = [];
        foreach ($list_day as $day){
            $statistics = Statistic::select('statistic_day', 'statistic_value')->where('statistic_month', $data_statistic['statistic_month'])->where('statistic_year', $data_statistic['statistic_year'])->where('project_id', $data_statistic['project_id'])->orderby('statistic_day', 'asc')->get();
            $statistic_value =  null;
            foreach ($statistics as $statistic){
                if($statistic->statistic_day == $day){
                    $statistic_value = $statistic->statistic_value;
                }
            }
            $result_chart[] = [
                'statistic_day' => $day,
                'statistic_value' => $statistic_value
            ];
        }
        return $this->responseSuccess($result_chart, 'Lấy dữ liệu thành công!');
    }

    public function viewByMonthDetail(ViewByMonthStatisticRequest $request){
        $data_statistic = $request->dataOnly();
        $list_day=[];
        $year = $data_statistic['statistic_year'];
        $month = $data_statistic['statistic_month'];
        for($day = 1; $day <= 31; $day++)
        {
            $timestamp  = mktime(12, 0, 0, $month, $day, $year);
            if (date('m', $timestamp) == $month)
                $list_day[]=date('d', $timestamp);
        }
        $result_chart = [];
        foreach ($list_day as $day){
            $statistics = Statistic::select('statistic_day', 'statistic_unsent','statistic_sent','statistic_failure')->where('statistic_month', $data_statistic['statistic_month'])->where('statistic_year', $data_statistic['statistic_year'])->where('project_id', $data_statistic['project_id'])->orderby('statistic_day', 'asc')->get();
            $statistic_unsent =  null;
            $statistic_sent =  null;
            $statistic_failure =  null;
            foreach ($statistics as $statistic){
                if($statistic->statistic_day == $day){
                    $statistic_unsent = $statistic->statistic_unsent;
                    $statistic_sent = $statistic->statistic_sent;
                    $statistic_failure = $statistic->statistic_failure;
                }
            }
            $result_chart[] = [
                'statistic_day' => $day,
                'statistic_unsent' => $statistic_unsent,
                'statistic_sent' => $statistic_sent,
                'statistic_failure' => $statistic_failure
            ];
        }
        return $this->responseSuccess($result_chart, 'Lấy dữ liệu thành công!');
    }

    public static function updateDailyStatisticTotal(){
        $projects = Project::select('project_id')->get();
        $current_date = date('Y-m-d');
        foreach ($projects as $project){
            DB::select('CALL UPDATE_DAILY_STATISTIC_TOTAL(?,?)',[$project->project_id, $current_date]);
            DB::select('CALL UPDATE_DAILY_STATISTIC_DETAIL(?,?,?)',[$project->project_id, $current_date, CampaignLog::$UNSENT]);
            DB::select('CALL UPDATE_DAILY_STATISTIC_DETAIL(?,?,?)',[$project->project_id, $current_date, CampaignLog::$SENT]);
            DB::select('CALL UPDATE_DAILY_STATISTIC_DETAIL(?,?,?)',[$project->project_id, $current_date, CampaignLog::$FAILURE]);
        }
    }

    public function report(ViewByMonthStatisticRequest $request){
        $data_statistic = $request->dataOnly();
        $year = $data_statistic['statistic_year'];
        $month = $data_statistic['statistic_month'];
        $data_report = (array)collect(DB::select('CALL PROJECT_STATISTIC_REPORT(?,?,?)',[$data_statistic['project_id'], $year, $month]))->first();
        if(empty($data_report)){
            return $this->responseBadRequest('Không có dữ liệu trong tháng này.');
        }
        $data_info = Project::select('project_name','mailing_service_name','mailing_service_amount', 'project_created_at')->where('project_id', $data_statistic['project_id'])->join('mailing_services','projects.mailing_service_id','mailing_services.mailing_service_id')->first()->toArray();
        $data_full = array_merge($data_report, $data_info);
        $data_full['project_created_at'] = date('d-m-Y H:i:s', strtotime($data_full['project_created_at']));
        $time_start = date('01-m-Y', strtotime($year.'-'.$month));
        $time_end = date('t-m-Y', strtotime($year.'-'.$month));
        if(date('m') == $month){
            $time_end = date('d-m-Y');
        }
        if(date('m') < $month){
            return $this->responseBadRequest('Thời gian không đúng. Vui lòng kiểm tra lại.');
        }
        $data_full['time_start'] = $time_start;
        $data_full['time_end'] = $time_end;
        $file_name = "EMK_Report_".date('Y-m-d_H-i-s')."_".Helper::randCode(5);
        $path = '/storage/app/public/report/'.$file_name.'.pdf';
        $pdf = \PDF::loadView('emk_report', ['data' => $data_full])->setPaper('a5', 'landscape');
        $pdf->save('.'.$path);
        return $this->responseSuccess(url('').$path, 'Xuất báo cáo thành công!');
    }
}
