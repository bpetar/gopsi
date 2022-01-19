@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <p><a href='/home'><- Back to home</a></p>

            {{-- TODO: ADD CHECK THAT AUTHOR MUST BE AUTHOR OF THIS CLIENT!!! --}}
            
            @if (auth()->check())
            @if (auth()->user()->id == 1  || auth()->user()->isAuthor() == 'true')
            <div class="card">
                <div class="card-header">{{$client->name}}
                    @if ($archived_client)
                    <span style="color: red;"> [ARCHIVED] </span>
                    @endif
                </div>
                <div class="card-body">

                    <ul class="nav nav-tabs" id="myClientTab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="client-active-tab" data-toggle="tab" href="#active" role="tab" aria-controls="active" aria-selected="true">Active Tasks</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="client-done-tab" data-toggle="tab" href="#done" role="tab" aria-controls="done" aria-selected="false">Done</a>
                      </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                      <div style="padding: 20px; border-left: 1px solid #dee2e6; border-right: 1px solid #dee2e6; border-bottom: 1px solid #dee2e6;" class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
                        @if (count($active) > 0)
                            @foreach ($active as $task)
                            <div class="card" style="margin-bottom:10px;">
                                <div class="card-header" style="background-color: lightgreen;">{{$task->title}}</div>
                                <div class="card-body pera">
                                    <p>{!! nl2br(e($task->description)) !!}</p>
                                    <p>Client notes: </p>
                                    <p style="padding: 5px; border: solid 1px lightgreen;"><span style="color: green;">
                                        @if ($task->client_notes)
                                        {{$task->client_notes}}
                                        @else
                                        <span style="color: lightgreen;">no notes</span>
                                        @endif
                                    </span></p>
                                    @if ($task->repeat > 0)
                                    <p>Repetitions: <span style="color: lightgreen;">{{$task->counter}} / {{$task->repeat}}</span></p>
                                    @endif

                                    @if (!$archived_client)
                                        {{ Form::open(array('url' => URL::to('/tasks/' . $task->id . '/edit'), 'method' => 'GET', 'style'=>'display:inline-block')) }}
                                          <button type="submit" class="transparent">Edit</button>
                                        {{ Form::close() }}

                                        {{ Form::open(array('url' => URL::to('/tasks/' . $task->id), 'method' => 'DELETE', 'style'=>'display:inline-block')) }}
                                          <button type="submit" class="transparent">Delete</button>
                                        {{ Form::close() }}
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        @else
                            <p>Client has no active tasks at the moment.</p>
                        @endif
                      </div>
                      <div style="padding: 20px; border-left: 1px solid #dee2e6; border-right: 1px solid #dee2e6; border-bottom: 1px solid #dee2e6;" class="tab-pane fade" id="done" role="tabpanel" aria-labelledby="done-tab">
                        @if (count($done) > 0)
                            @foreach ($done as $task)
                            <div class="card" style="margin-bottom:10px;">
                                <div class="card-header" style="background-color: lightgreen;">{{$task->title}}</div>
                                <div class="card-body pera">
                                    <p>{!! nl2br(e($task->description)) !!}</p>
                                    <p>Client notes: </p>
                                    <p style="padding: 5px; border: solid 1px lightgreen;"><span style="color: green;">
                                        @if ($task->client_notes)
                                        {{$task->client_notes}}
                                        @else
                                        <span style="color: lightgreen;">no notes</span>
                                        @endif
                                    </span></p>
                                    <p>Status: <span style="color: lightgreen;">{{$task->status}}</span></p>

                                    @if (!$archived_client)
                                        {{ Form::open(array('url' => URL::to('/tasks/' . $task->id . '/edit'), 'method' => 'GET', 'style'=>'display:inline-block')) }}
                                          <button type="submit" class="transparent">Edit</button>
                                        {{ Form::close() }}

                                        {{ Form::open(array('url' => URL::to('/tasks/' . $task->id), 'method' => 'DELETE', 'style'=>'display:inline-block')) }}
                                          <button type="submit" class="transparent">Delete</button>
                                        {{ Form::close() }}
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        @else
                            <p>Client has no done tasks at the moment.</p>
                        @endif
                      </div>
                    </div>
                    <br/>
                    
                    <hr>
                    @if (!$archived_client)
                        <a href="/tasks/create?client_id={{$client->id}}"> [Add new task] </a>
                    @endif

                    <a href="/client/remove?client_id={{$client->id}}"> <span style='float:right; color: red;'> [Remove client] </span></a>

                    @if ($archived_client)
                        <a href="/client/unarchive?client_id={{$client->id}}"> <span style='margin-right: 20px; float:right; color: red;'> [Unarchive client] </span></a>
                    @else
                        <a href="/client/archive?client_id={{$client->id}}"> <span style='margin-right: 20px; float:right; color: red;'> [Archive client] </span></a>
                    @endif
                </div>
            </div>
            @endif
            @endif
        </div>
    </div>
</div>
@endsection
