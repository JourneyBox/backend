<?php

use GuzzleHttp\Client;

class OAuthController extends BaseController {

    public function dropbox()
    {
        $code = Input::get('code');

        if(empty($code)) {
            return Response::json(['error' => 'true', 'message' => 'The access code has not been sent'], 401);
        }
        try {
            $client = new Client();
            $response = $client->post('https://api.dropbox.com/1/oauth2/token', [
                'body' => [
                    'code' => $code,
                    'client_secret' => Config::get('services.dropbox.token'),
                    'client_id' => Config::get('services.dropbox.app'),
                    'grant_type' => 'authorization_code',
                    'redirect_uri' => 'https://' . Config::get("app.url") . '/oauth/dropbox'
                ]
            ]);
            $json = $response->json();

            if (isset($json['error']) && $json['error'] == 'invalid_grant') {
                return Response::json(['error' => true, 'message' => 'The authorization code is invalid'], 400);
            }

            $accessToken = $json['access_token'];

            $dropboxUser = $client->get('https://api.dropbox.com/1/account/info', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken
                ]
            ])->json();

            $user = User::where('dropbox_user_id', '=', $dropboxUser['uid'])->first();

            if (is_null($user)) {
                $user = new User();
                $user->display_name = $dropboxUser['display_name'];
                $user->dropbox_user_id = $dropboxUser['uid'];
                $user->dropbox_access_token = $accessToken;
                $user->save();
            }

            Auth::login($user, true);

            return Redirect::to('/dashboard');
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            dd((string) $e->getResponse()->getBody());
        }
    }

}