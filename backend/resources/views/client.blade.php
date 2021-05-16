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
                <div class="card-header">{{$client->name}}</div>
                <div class="card-body">
                    <h2>Tasks</h2>
                    @if (count($tasks) > 0)
                    @foreach ($tasks as $task)
                    <div class="card" style="margin-bottom:10px;">
                        <div class="card-header" style="background-color: lightgreen;">{{$task->title}}</div>
                        <div class="card-body pera">
                            <p>{{$task->description}}</p>
                            <p>Status: <span style="color: lightgreen;">{{$task->status}}</span></p>

                            {{ Form::open(array('url' => URL::to('/tasks/' . $task->id . '/edit'), 'method' => 'GET', 'style'=>'display:inline-block')) }}
                              <button type="submit" class="transparent">Edit</button>
                            {{ Form::close() }}

                            {{ Form::open(array('url' => URL::to('/tasks/' . $task->id), 'method' => 'DELETE', 'style'=>'display:inline-block')) }}
                              <button type="submit" class="transparent">Delete</button>
                            {{ Form::close() }}

                        </div>
                    </div>
                    @endforeach
                    @else
                        <p>Client has no tasks at the moment.</p>
                    @endif
                    
                    <hr>
                    <a href="/tasks/create?client_id={{$client->id}}"> [Add new task] </a>
                    <a href="/client/remove?client_id={{$client->id}}"> <span style='float:right; color: red;'> [Remove client] </span></a>
                </div>
            </div>
            @endif
            @endif
        </div>
    </div>
</div>
@endsection
