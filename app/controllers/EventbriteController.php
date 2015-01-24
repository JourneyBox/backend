<?php

use GuzzleHttp\Client;
use Carbon\Carbon;

class EventbriteController extends BaseController {

    public function storeAccessToken($id, $access_token){
        $user = User::findOrFail($id);
        $user->$access_token = $access_token;
        $user->update();
    }

    public function getUpcomingEvents($id) {
        $user = User::findOrFail($id);
        $access_token = $user->$dropbox_access_token;
        if (empty($access_token)) {
            return Response::json(['error' => true, 'message' => 'The user specified does not have an access token.'], 400);
        }
        $client = new Client();
        $response = $client->get('https://www.eventbriteapi.com/v3/users/me/orders', [
            'headers' => ['Authorization' => 'Bearer ' . $access_token]
        ]);
        $json = $response->json();
        if ($json['status_code'] == '401') {
            $user->dropbox_access_token = NULL;
            return Response::json(['error' => true, 'message' => 'The access token is invalid.'], 401);
        }

        $upcomingEvents = array();
        foreach ($json['orders'] as $order) {
            if (Carbon::createFromFormat(Carbon::ISO8601, $order['event']['end']['utc']) > Carbon::now('UTC')) {
                $upcomingEvents[] = $order;
            }
        }
        return Response::json($upcomingEvents, 200);
    }

    public function getLocalEvents(){
        
    }

}