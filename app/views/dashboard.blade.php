@extends('app')

@section('content')

<h1>{{ dd(Auth::getUser() )}}</h1>

<h1>Welcome, {{{ Auth::getUser()->display_name }}}</h1>

@endsection