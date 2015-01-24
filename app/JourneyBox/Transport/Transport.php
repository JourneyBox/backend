<?php namespace JourneyBox\Transport;

use GuzzleHttp\Client;

class Transport
{

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

    public function getRoutesFor($from, $to, \DateTime $journeyDate = null)
    {
        $from  = str_replace(' ', '+', $from);
        $to  = str_replace(' ', '+', $to);

        if ($cache = \Cache::get($from.$to)) {
            return $cache;
        }

        // If no date specified, use now.
        if ($journeyDate === null) {
            $journeyDate = new \DateTime();
        }

        $date = $journeyDate->format('Y-m-d');
        $time = $journeyDate->format('H:i');

        $request = $this->client->createRequest('GET',"uk/public/journey/from/{$from}/to/{$to}/at/{$date}/{$time}.json", [
            'query' => $this->getQuery()
        ]);

        $response = $this->client->send($request)->json();

        \Cache::forever($from.$to, $response);

        return $response;
    }

    private function getQuery($params = [])
    {
        return [
            'api_key' => $this->config['api_key'],
            'app_id' => $this->config['app_id'],
        ] + $params;
    }
}