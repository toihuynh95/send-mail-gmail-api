<?php

namespace Modules\GmailAPI\Http\Controllers;

use Illuminate\Routing\Controller;

class ServiceSendEmailController extends Controller
{
    public function __construct()
    {
        $this->client = new \Google_Client();
        $this->credentials = getenv('GOOGLE_CREDENTIALS'); // Link file thông tin xác thực
    }

    public function getClient($credentials, $auth_user_id)
    {
        $this->client->setAuthConfig($credentials);
        $this->client->setAccessType('offline');
        $tokenPathFull = './storage/app/public/google/token/'.$auth_user_id.'.json';
        $accessToken = json_decode(file_get_contents($tokenPathFull), true); // Lấy token hiện tại (Cũ nếu như hết hạn)
        $this->client->setAccessToken($accessToken);
        if($this->client->isAccessTokenExpired()) { // Nếu token hết hạn sẽ tiến hành refresh lại token để sử dụng
            $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
            $newAccessToken = $this->client->getAccessToken();
            $accessToken = array_merge($accessToken, $newAccessToken); // Hợp nhất cái mới và cái cũ vừa lấy ra ở trên
            file_put_contents($tokenPathFull, json_encode($accessToken)); // Cập nhật token mới vào file cũ
        }
        return $this->client;
    }

    public function sendEmail( $auth_user_id, $data_send_mail){
        $this->client = $this->getClient($this->credentials, $auth_user_id);
        $this->service = new \Google_Service_Gmail($this->client);

        $message = new \Swift_Message;
        $message->setTo($data_send_mail['contact_email']);
        $message->setBody($this->replaceVariable($data_send_mail['campaign_content'], $data_send_mail), 'text/html');

        if(!empty($data_send_mail['campaign_attach_file'])){
            foreach (json_decode($data_send_mail['campaign_attach_file']) as $item) {
                if(!file_exists('.'.$item)) {
                    $message->attach(\Swift_Attachment::fromPath($item));
                }
                $message->attach(\Swift_Attachment::fromPath(url('').$item));
            }
        }

        $message->setSubject($data_send_mail['campaign_title']);
        $gm_message = new \Google_Service_Gmail_Message();
        $gm_message->setRaw($this->base64UrlEncode($message->toString()));
        // Send Mail
        return $this->service->users_messages->send('me', $gm_message);
    }

    public function base64UrlEncode($input) {
        $str = strtr(base64_encode($input), '+/', '-_');
        $str = str_replace('=', '', $str);
        return $str;
    }

    public function replaceVariable($content,$data_send_mail){
        $data_replaced = str_replace('[name]',$data_send_mail['contact_name'],$content);
        if($data_send_mail['contact_gender'] == 1){
            $data_send_mail['contact_gender'] = 'Anh';
        }else if ($data_send_mail['contact_gender'] == 0){
            $data_send_mail['contact_gender'] = 'Chị';
        }else{
            $data_send_mail['contact_gender'] = 'Anh / Chị';
        }
        $data_replaced = str_replace('[gender]',$data_send_mail['contact_gender'],$data_replaced);
        return $data_replaced;
    }
}
