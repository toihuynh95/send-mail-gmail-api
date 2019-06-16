<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Campaign\Entities\Campaign;
use Modules\Campaign\Entities\CampaignLog;
use Modules\GmailAPI\Http\Controllers\ServiceSendEmailController;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email automatically';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $campaigns = Campaign::where('campaign_status', Campaign::$WAIT_SEND)->where('campaign_schedule', '<=', date('Y-m-d H:i:s'))->get();
        foreach ($campaigns as $key_campaign => $campaign){
            $campaign_logs = CampaignLog::where('campaign_id', $campaign->campaign_id)->where('campaign_log_status', CampaignLog::$UNSENT)->get();
            foreach ($campaign_logs as $key_campaign_log => $campaign_log){
                if(!$this->verifyEmail($campaign_log->contact_email)){
                    $campaign_log->update(['campaign_log_status' => CampaignLog::$FAILURE]);
                }else{
                    $data_send_mail = [
                        'contact_name' => $campaign_log->contact_name,
                        'contact_email' => $campaign_log->contact_email,
                        'contact_gender' => $campaign_log->contact_gender,
                        'campaign_title' => $campaign->campaign_title,
                        'campaign_content' => $campaign->campaign_content,
                        'campaign_attach_file' => $campaign->campaign_attach_file
                    ];
                    $service_send_email = new ServiceSendEmailController();
                    $service_send_email->sendEmail($campaign->campaign_email_id, $data_send_mail);
                    $campaign_log->update(['campaign_log_status' => CampaignLog::$SENT]);
                }
            }
            $campaign->update(['campaign_status' => Campaign::$FINISH]);
        }
    }

    public function verifyEmail($email){
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', getenv('MAIL_CHECK_URL').'/v4/single/check?key='.getenv('MAIL_CHECK_KEY').'&email='.$email);
        $body = json_decode($res->getBody(), true);
        if($body['result'] == 'valid'){
            return true;
        }
        else{
            return false;
        }
    }
}
