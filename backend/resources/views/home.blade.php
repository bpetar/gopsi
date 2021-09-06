@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (auth()->user()->id == 1  || auth()->user()->isAuthor() == 'true')

           

            <div class="card">
                <div class="card-header">My clients</div>
                <div class="card-body pera">

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Active</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Archived</a>
                      </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                      <div style="padding: 20px; border-left: 1px solid #dee2e6; border-right: 1px solid #dee2e6; border-bottom: 1px solid #dee2e6;" class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        @if (count($active) > 0)
                            @foreach ($active as $client)
                                <p><a href='/client/{{$client->id}}'>{{$client->name}}</a></p>
                            @endforeach
                        @else
                            <p>You have no active clients at the moment.</p>
                        @endif
                      </div>
                      <div style="padding: 20px; border-left: 1px solid #dee2e6; border-right: 1px solid #dee2e6; border-bottom: 1px solid #dee2e6;" class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        @if (count($archived) > 0)
                            @foreach ($archived as $client)
                                <p><a href='/client/{{$client->id}}'>{{$client->name}}</a></p>
                            @endforeach
                        @else
                            <p>You have no archived clients at the moment.</p>
                        @endif
                      </div>
                    </div>
                    <br/>
                    <a href="/client/create"> [Add new client] </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
