<?php

class HomeController extends BaseController {

    public function index()
    {
        return Response::view('login');
	}

}
