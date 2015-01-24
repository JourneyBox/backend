<?php namespace JourneyBox\Dropbox;

use GuzzleHttp\Client;

class Dropbox
{
    /** Dropbox API Urls */
    const API_URL = 'https://api.dropbox.com';
    const API_CONTENT_URL = 'https://api-content.dropbox.com';
    const API_NOTIFY_URL = 'https://api-notify.dropbox.com';

    /** Dropbox API Version */
    const VERSION = 1;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private $config;

    public function __construct(array $config, Client $client)
    {
        $this->client = $client;
        $this->config = $config;
    }

    /**
     * Stores the $content on the Dropbox with the given file $name
     *
     * @param $name
     * @param $content
     */
    public function storeContent($name, $content)
    {
        $this->client->put(self::API_CONTENT_URL . '/' . self::VERSION . '/files_put/auto/', [
            'query' => $this->getQuery()
        ]);
    }

    private function getQuery($params = [])
    {

    }

}