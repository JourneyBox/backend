<?php

use GuzzleHttp\Client;

class OAuthController extends BaseController {

    public function dropbox()
    {
        $code = Input::get('code');

        if(empty($code)) {
            return Response::json(['error' => 'true', 'message' => 'The access code has not been sent'], 401);
        }

        $client = new Client();
        $response = $client->post('https://api.dropbox.com/1/oauth2/token', [
            'body' => [
                'code' => $code,
                'client_secret' => Config::get('services.dropbox.token'),
                'client_id' => Config::get('services.dropbox.app'),
                'grant_type' => 'authorization_code'
            ]
        ]);
        $json = $response->json();

        if ($json['error'] == 'invalid_grant') {
            return Response::json(['error' => true, 'message' => 'The authorization code is invalid'], 400);
        }

        $access_token = $json['access_token'];

        $revisiting_user = DB::table('users')->where('dropbox_access_token', '=', $access_token)->first();

        if(is_null($revisiting_user)) {
            $user = new User();
            $user->dropbox_access_token = $access_token;
            $user->save();
        } else {
            $user = $revisiting_user;
        }

        Auth::login($user);

        return Redirect::to('/dashboard');
    }

}