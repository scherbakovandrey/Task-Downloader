@extends('layout')

@section('content')
    <h1 class="title">Home</h1>

    <div class="text">
    This is a web-application which will download particular resource by specified
    url. The same resources can be downloaded multiple times.
    Url can be passed via web API method or with CLI command.
    There should be a simple html page showing status of all jobs (for complete jobs there also
    should be an url to download target file). The same should be available via CLI command
    and web API.
    It should save downloaded urls in storage configured in Laravel (local driver can be used).
    </div>
@endsection

