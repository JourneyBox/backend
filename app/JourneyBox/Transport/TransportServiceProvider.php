<?php namespace JourneyBox\Transport;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class TransportServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app['transport'] = $this->app['JourneyBox\Transport\Transport'] = $this->app->share(function($app)
        {
            $config = $app['config']->get('services.transport');

            $guzzle = new Client(
                [
                    'base_url' => [
                        'http://transportapi.com/{version}/',
                        ['version' => 'v3']
                    ]
                ]
            );

            return new Transport($config, $guzzle);
        });
    }
}