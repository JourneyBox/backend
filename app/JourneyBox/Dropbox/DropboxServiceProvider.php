<?php namespace JourneyBox\Dropbox;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class DropboxServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app['dropbox'] = $this->app['JourneyBox\Dropbox\Dropbox'] = $this->app->share(function($app)
        {
            $config = $app['config']->get('services.dropbox');

            $guzzle = new Client(
                [
                    'defaults' => [
                        'headers' => [
                            'Accept' => 'application/json',
                            'Content-Type' => 'application/json',
                        ]
                    ]
                ]
            );

            return new Dropbox($config, $guzzle);
        });
    }
}