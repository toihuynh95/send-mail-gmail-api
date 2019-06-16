<?php

namespace Modules\GmailAPI\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class GoogleGetTokenController extends BaseController
{
    protected $client;

    public function __construct()
    {
        $this->client = new \Google_Client(); // Khởi tạo Google Client
        $this->credentials = getenv('GOOGLE_CREDENTIALS'); // Link file thông tin xác thực
    }

    private function getClient($credentials)
    {
        $this->client->setApplicationName('Send Email APIs'); // Đặt tên cho ứng dụng (không quan trọng lắm)
        $this->client->setScopes([ // Cài đặt xin quyền truy cập của token, ở đây tôi đang xin truy cập đến dữ liệu GMAIL_READONLY và GMAIL_SEND, ...
            \Google_Service_Gmail::GMAIL_READONLY,
            \Google_Service_Gmail::GMAIL_SEND,
            'https://www.googleapis.com/auth/userinfo.profile'
        ]);
        $this->client->setAuthConfig($credentials); // Đường dẫn đến file credentials.json
        $this->client->setAccessType('offline'); // Không rõ lắm nên cứ để vậy đi :">
//        $this->client->setApprovalPrompt('force'); // Làm mới phiên, xuất hiện lại hộp thoại cho phép quyền
        return $this->client;
    }

    public function getAuthCode()
    {
        $this->client = $this->getClient($this->credentials); // Lấy dữ liệu client
        return redirect($this->client->createAuthUrl()); // Đưa về trang đăng nhập google
    }

    public function getToken(Request $request)
    {
        $this->client = $this->getClient($this->credentials); // Lấy dữ liệu client
        $authCode = $request->code; // Lấy code sau khi callback API trên URL
        $authCode = trim($authCode); // Cắt bỏ khoảng trắng
        $accessToken = $this->client->fetchAccessTokenWithAuthCode($authCode); // Đẩy code lên để nhận access token

        $oauth2 = new \Google_Service_Oauth2($this->client); // Dịch vụ dùng để lấy thông tin cá nhân
        $auth_id = $oauth2->userinfo->get()->id;
        $tokenPathFull = storage_path('app/public/google/token/'.$auth_id.'.json'); // Đường dẫn đầy đủ để ghi nội dung vào file
        $service = new \Google_Service_Gmail($this->client);
        $email_address = $service->users->getProfile('me')->emailAddress;
        // Kiểm tra lỗi
        if (array_key_exists('error', $accessToken)) {
            throw new \Exception(join(', ', $accessToken));
        }
        if (!file_exists(dirname($tokenPathFull))) { // Kiểm tra folder đã tồn tại hay chưa
            mkdir(dirname($tokenPathFull), 0777, true); // Tạo folder. Nhớ để quyền truy cập file trong thư mục là 777
        }
        if(file_exists($tokenPathFull)){
            $accessTokenOld = json_decode(file_get_contents($tokenPathFull), true); // Lấy token cũ ra
            $accessToken = array_merge($accessTokenOld, $accessToken); // Hợp nhất giữa cái cũ và cái mới .... Lấy hết cả chung và riêng
        }
        file_put_contents($tokenPathFull, json_encode($accessToken)); // // Lưu token vào file
        return redirect('/campaign?id='.$auth_id.'&email='.$email_address); // Xác thực xong, quay về giao diện
    }
}
