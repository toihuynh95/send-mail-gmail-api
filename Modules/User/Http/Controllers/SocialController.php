<?php

namespace Modules\User\Http\Controllers;

use Socialite;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class SocialController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)
            ->scopes([
                \Google_Service_Gmail::GMAIL_READONLY,
                \Google_Service_Gmail::GMAIL_SEND
            ])
            ->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $user =   Socialite::driver($provider)->user();
        dd($user);
        $google_client_token = [
            'access_token' => 'ya29.GlsRB28OWwKatOy7IzBxazD6IVOkqg37luLyzl3une94oiEu22sxqJ3sw2EWLF8x-IldDpSLg_IrmJXZpbZ7MMNC4m8m8ZgkvymfzEDCzOWz-6vm2x8VBnO2yHH0',//$user->token,
            'refresh_token' => null, //$user->refreshToken,
            'expires_in' => 3599 //$user->expiresIn
        ];
        $client = new \Google_Client();
        $client->setAccessToken(json_encode($google_client_token));
        $client->setApplicationName('Send Email APIs');
        if($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        }



        $service = new \Google_Service_Gmail($client);
        $message = new \Swift_Message;
        $message->setTo('toi.huynh@alta.com.vn');
        $message->setBody('Xin chào!', 'text/html');
        $message->setSubject('Test');
        $gm_message = new \Google_Service_Gmail_Message();
        $gm_message->setRaw($this->base64UrlEncode($message->toString()));
        // Send Mail
        $service->users_messages->send('me', $gm_message);
    }

    public function base64UrlEncode($input) {
        $str = strtr(base64_encode($input), '+/', '-_');
        $str = str_replace('=', '', $str);
        return $str;
    }
}
