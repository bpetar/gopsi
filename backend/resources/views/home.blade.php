@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (auth()->user()->id == 1  || auth()->user()->isAuthor() == 'true')
            <div class="card">
                <div class="card-header">My clients</div>
                <div class="card-body pera">
                        @if (count($clients) > 0)
                        @foreach ($clients as $client)
                            <p><a href='/client/{{$client->id}}'>{{$client->name}}</a></p>
                        @endforeach
                        @else
                            <p>You have no clients at the moment.</p>
                        @endif
                        <hr>
                        <a href="/client/create"> [Add new client] </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
