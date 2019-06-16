<?php

namespace Modules\User\Http\Controllers;

use Hash;
use App\Helpers\Helper;
use App\Http\Controllers\BaseController;
use Modules\Customer\Entities\Customer;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\CreateNewPasswordRequest;
use Modules\User\Http\Requests\ForgotPasswordRequest;
use Modules\User\Http\Requests\LockedUserRequest;
use Modules\User\Http\Requests\LoginUserRequest;
use Modules\User\Http\Requests\ResetPasswordRequest;
use Modules\User\Http\Requests\StoreUserRequest;
use Modules\User\Http\Requests\UnlockedUserRequest;
use Modules\User\Http\Requests\UpdateAvatarRequest;
use Modules\User\Http\Requests\UpdateProfileRequest;
use Modules\User\Http\Requests\UpdateUserRequest;
use DB;
use GuzzleHttp\Client;

class UserController extends BaseController
{
    public function store(StoreUserRequest $request){
        $user_data = $request->dataOnly();
        if (auth()->user()->user_level <= $user_data['user_level'] ){
            return $this->responseBadRequest("Bạn không có quyền thêm tài khoản với chức vụ này.");
        }
        if(!$this->verifyEmail($user_data["user_name"])){
            return $this->responseBadRequest("Địa chỉ email không tồn tại hoặc không được chấp nhận!");
        }
        if($request->hasFile('user_avatar')){
            $user_data['user_avatar'] = Helper::uploadFile($request->user_avatar, 'user');
        }
        DB::beginTransaction();
        $user = User::create($user_data);
        if($user_data["user_level"] == User::$IS_USER){
            $customer_data = [
                "user_id" => $user->user_id,
                "customer_name" => $user_data["user_full_name"],
                "customer_email" => $user_data["user_name"],
            ];
            Customer::create($customer_data);
        }
        $email_data = [
            "name" => $user_data["user_full_name"],
            "email" => $user_data["user_name"],
            "title" => 'Thông tin tài khoản - Email Marketing',
            "password" => $user_data['password']
        ];
        try {
            $this->sendEmailUserAccountInfo($email_data);
        }catch (\Exception $exception){
            DB::rollback();
            return $this->responseServerError("Hệ thống đã có lỗi xảy ra khi gửi thông tin tài khoản qua email.");
        }
        DB::commit();
        return $this->responseSuccess($user, "Thêm người dùng thành công!");
    }

    public function update(UpdateUserRequest $request, $user_id){
        $user_data = $request->dataOnly();
        $user = User::find($user_id);
        if(is_null($user)){
            return $this->responseBadRequest('Người dùng không tồn tại.');
        }
        if (auth()->user()->user_level <= $user->user_level ){
            return $this->responseBadRequest("Bạn không có quyền cập nhật thông tin cho tài khoản này.");
        }
        $user->update($user_data);
        if($user->user_level == User::$IS_USER) {
            Customer::where('user_id', $user_id)->update(["customer_email" => $user_data['user_name']]);
        }
        return $this->responseSuccess($user, "Cập nhật thông tin người dùng thành công!");
    }

    public function login(LoginUserRequest $request){
        $user_data = $request->dataOnly();
        if (! $token = auth()->attempt($user_data)) {
            return $this->responseUnauthorized("Đăng nhập thất bại: Tài khoản hoặc mật khẩu không đúng!");
        }
        if (auth()->user()->user_status != User::$ACTIVATED){
            return $this->responseAccessDenied("Truy cập bị từ chối: Tài khoản đã bị khóa!");
        }

        $token_data = [
            "access_token" => $token,
            "token_type" => "bearer",
            "expires_in" => auth()->factory()->getTTL() * 60
        ];
        return $this->responseSuccess($token_data, "Đăng nhập thành công!");
    }

    public function me(){
        $user_current = auth()->user();
        if(!is_null($user_current->user_avatar)){
            $user_current->user_avatar = url('').$user_current->user_avatar;
        }
        return $this->responseSuccess($user_current, "Thông tin người dùng.");
    }

    public function logout(){
        $user_data = auth()->user();
        auth()->logout();
        return $this->responseSuccess($user_data, "Đăng xuất thành công!");
    }

    public function lock(LockedUserRequest $request){
        $user_data = $request->dataOnly();
        $user_lock = User::find($user_data["user_id"]);
        if (auth()->user()->user_level <= $user_lock["user_level"]){
            return $this->responseBadRequest("Tài khoản không được phép khóa.");
        }
        if($user_lock->user_status == User::$DEACTIVATED){
            return $this->responseBadRequest('Khóa thất bại: Tài khoản đã bị khóa.');
        }
        $user_lock->update(['user_status' => User::$DEACTIVATED]);
        return $this->responseSuccess($user_lock, "Khóa tài khoản thành công!");
    }

    public function unlock(UnlockedUserRequest $request){
        $user_data = $request->dataOnly();
        $user_unlock = User::find($user_data["user_id"]);
        if($user_unlock->user_status == User::$ACTIVATED){
            return $this->responseBadRequest('Mở khóa thất bại: Tài khoản chưa bị khóa.');
        }
        $user_unlock->update(['user_status' => User::$ACTIVATED]);
        return $this->responseSuccess($user_unlock, "Mở khóa tài khoản thành công!");
    }

    public function show(){
        $user_data = User::orderBy('user_id', 'desc')->get();
        return datatables()->of($user_data)->toJson();
    }

    public function showListIsUser(){
        $user_data = User::where('user_level', User::$IS_USER)->orderBy('user_id', 'desc')->get();
        return $this->responseSuccess($user_data, "Danh tài khoản người dùng.");
    }

    public function destroy($user_id){
        $user_data = User::find($user_id);
        if(is_null($user_data)){
            return $this->responseBadRequest('Người dùng không tồn tại.');
        }
        if($user_data->user_level != User::$IS_ADMIN){
            return $this->responseAccessDenied("Truy cập trái phép! Bạn không được phép xóa tài khoản khách hàng.");
        }
        if (auth()->user()->user_level != User::$IS_SUPER ){
            return $this->responseAccessDenied("Truy cập trái phép! Bạn không có quyền xóa tài khoản này.");
        }
        $user_data->delete();
        return $this->responseSuccess($user_data, "Xóa người dùng thành công!");
    }

    public function showByID($user_id){
        $user = User::find($user_id);
        if(is_null($user)){
            return $this->responseBadRequest('Người dùng không tồn tại.');
        }
        return $this->responseSuccess($user, "Thông tin chi tiết của người dùng.");
    }

    public function updateProfile(UpdateProfileRequest $request){
        $user_data = $request->dataOnly();
        $user = auth()->user();
        $user->update($user_data);
        return $this->responseSuccess($user, "Cập nhật thông tin người dùng thành công!");
    }

    public function updateAvatar(UpdateAvatarRequest $request){
        if($request->hasFile('user_avatar')){
            $user_data['user_avatar'] = Helper::uploadFile($request->user_avatar, 'user');
            $user = auth()->user();
            $user->update($user_data);
            return $this->responseSuccess($user, "Cập nhật ảnh đại diện thành công!");
        }
    }

    public function resetPassword(ResetPasswordRequest $request){
        $user_data = $request->dataOnly();
        $user = auth()->user();
        if(!Hash::check($user_data["current_password"],$user->password)){
           return $this->responseBadRequest("Mật khẩu hiện tại không đúng!");
        }
        else{
            $user->update(['password' => $user_data["password"]]);
            auth()->logout();
            return $this->responseSuccess("Đổi mật khẩu thành công. Vui lòng đăng nhập lại!");
        }
    }

    public function generatePassword(){
        $data = [
            "password" => Helper::randCode(10)
        ];
        return $this->responseSuccess($data,"Lấy mật khẩu ngẫu nhiên từ hệ thống.");
    }

    public function sendEmailUserAccountInfo($email_data){
        \Mail::send('user::account', $email_data, function ($message) use ($email_data) {
            $message->from('datn.email.marketing@gmail.com','Email Marketing')
                ->to($email_data['email'])
                ->subject($email_data['title']);
        });
    }

    public function verifyEmail($email){
            $client = new Client();
            $res = $client->request('GET', getenv('MAIL_CHECK_URL').'/v4/single/check?key='.getenv('MAIL_CHECK_KEY').'&email='.$email);
            $body = json_decode($res->getBody(), true);
            if($body['result'] == 'valid'){
                return true;
            }
            else{
                return false;
            }
    }

    public function forgotPassword(ForgotPasswordRequest $request){
        $user_data = $request->dataOnly();
        $user = User::where('user_name', $user_data['user_name'])->first();
        if (is_null($user)){
            return $this->responseBadRequest('Tài khoản không tồn tại.');
        }
        $user_token = Helper::randCode(20);
        $user->update(['user_token' => $user_token]);
        $user_data['link_reset'] = url('').'/user/login?token='.$user_token;
        \Mail::send('user::forgot', $user_data, function ($message) use ($user_data) {
            $message->from('datn.email.marketing@gmail.com','Email Marketing')
                ->to($user_data['user_name'])
                ->subject('Đặt lại mật khẩu');
        });
        return $this->responseSuccess('', 'Gửi yêu cầu thành công!');
    }

    public function checkTokenResetPassword($token){
        $user = User::where('user_token', $token)->first();
        if(is_null($user)){
            return $this->responseBadRequest('Liên kết không khả dụng.');
        }
        return $this->responseSuccess($user, 'Token đã được kiểm tra hợp lệ.');
    }

    public function createNewPassword(CreateNewPasswordRequest $request, $token){
        $user_data = $request->dataOnly();
        $user = User::where('user_token', $token)->first();
        if(is_null($user)){
            return $this->responseBadRequest('Liên kết không khả dụng.');
        }
        $user->update(['password' => $user_data['password'], 'user_token' => NULL]);
        return $this->responseSuccess($user, 'Tạo mật khẩu mới thành công!');
    }

    public function test(){

    }
}
