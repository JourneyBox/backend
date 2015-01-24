@extends('app')

@section('content')

<div class="text-center">
    <h1>Journey Box</h1>
</div>

<form class="form-signin">
    <a href="https://www.dropbox.com/1/oauth2/authorize?response_type=code&client_id=yvkbd53780t4vlj&redirect_uri=https://{{ Config::get("app.url") }}/oauth/dropbox" class="btn btn-lg btn-primary btn-block" type="submit"> <i class="fa fa-dropbox"></i> Sign in with Dropbox</a>
</form>

@endsection