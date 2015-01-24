@extends('app')

@section('content')

{{ dd(Auth::getUser() )}}

<h1>Welcome, {{{ Auth::getUser()->display_name }}}</h1>

@endsection