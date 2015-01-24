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
        $from  = str_replace(' ', '+', $to);
        $to  = str_replace(' ', '+', $to);

        // If no date specified, use now.
        if ($journeyDate === null) {
            $journeyDate = new \DateTime();
        }

        $date = $journeyDate->format('Y-m-d');
        $time = $journeyDate->format('H:i');

        $request = $this->client->createRequest('GET',"uk/public/journey/from/{$from}/to/{$to}/at/{$date}/{$time}.js", [
            'query' => $this->getQuery()
        ]);

        var_dump($request->getUrl(), $request->getBody(), $request->getQuery());

        return $this->client->send($request)->json();
    }

    private function getQuery($params = [])
    {
        return [
            'api_key' => $this->config['api_key'],
            'app_id' => $this->config['app_id'],
        ] + $params;
    }
}