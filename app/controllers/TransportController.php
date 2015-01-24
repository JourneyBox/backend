<?php

class TransportController extends BaseController {

    /**
     * @var \JourneyBox\Transport\Transport
     */
    private $transport;

    public function __construct(\JourneyBox\Transport\Transport $transport)
    {
        $this->transport = $transport;
    }

    public function getRoutes()
    {
        $from = \Input::get('form');
        $to = \Input::get('to');
        $when = \Input::has('when') ? \Carbon\Carbon::createFromFormat(\Carbon\Carbon::ISO8601, \Input::get('when')) : null;

        $routes = $this->transport->getRoutesFor($from, $to, $when);

        return \Response::json($routes, 200);
    }

}
