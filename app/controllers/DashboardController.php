<?php

class DashboardController extends BaseController {

    public function index()
    {
        return Response::view('dashboard');
    }

}