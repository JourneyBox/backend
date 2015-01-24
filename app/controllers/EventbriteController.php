<?php

use GuzzleHttp\Client;
use Carbon\Carbon;

class EventbriteController extends BaseController {

    public function requestToken(){
        $code = Input::get('code');

        if(empty($code)) {
            return Response::json(['error' => 'true', 'message' => 'The access code has not been sent'], 401);
        }

        $client = new Client();
        $response = $client->post('https://www.eventbrite.com/oauth/token', [
            'body' => [
                'code' => $code,
                'client_secret' => Config::get('eventbrite.client_secret'),
                'client_id' => Config::get('eventbrite.api_key'),
                'grant_type' => 'authorization_code'
            ]
        ]);
        $json = $response->json();

        if ($json['error'] == 'invalid_grant') {
            return Response::json(['error' => true, 'message' => 'The authorization code is invalid'], 400);
        }

        $access_token = $json['access_token'];

        return Response::json(['access_token' => $access_token], 200);
    }

    public function assignToken() {
        $id = Input::get('id');
        $user = User::findOrFail($id);
        $user->eventbrite_access_token = Input::get('access_token');
        $user->update();

        return Response::json('success', 200);
    }

    public function getUpcomingEvents() {
        $id = Input::get('id');
        $user = User::findOrFail($id);
        $access_token = $user->eventbrite_access_token;
        if (empty($access_token)) {
            return Response::json(['error' => true, 'message' => 'The user specified does not have an access token.'], 400);
        }
        $client = new Client();
        $response = $client->get('https://www.eventbriteapi.com/v3/users/me/orders', [
            'headers' => ['Authorization' => 'Bearer ' . $access_token]
        ]);
        $json = $response->json();
        if ($json['status_code'] == '401') {
            $user->eventbrite_access_token = NULL;
            $user->update();
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

    public function getLondonEvents(){
        $id = Input::get('id');
        $user = User::findOrFail($id);
        $access_token = $user->eventbrite_access_token;
        if (empty($access_token)) {
            return Response::json(['error' => true, 'message' => 'The user specified does not have an access token.'], 400);
        }
        $client = new Client();
        $response = $client->get('https://www.eventbriteapi.com/v3/events/search/?venue.city=London', [
            'headers' => ['Authorization' => 'Bearer ' . $access_token]
        ]);
        $json = $response->json();
        if ($json['status_code'] == '401') {
            $user->eventbrite_access_token = NULL;
            $user->update();
            return Response::json(['error' => true, 'message' => 'The access token is invalid.'], 401);
        }

        return Response::json($json, 200);
    }

}