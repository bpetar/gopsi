@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <p><a href="/client/{{ $task->client_id }}"><- Back to client</a></p>
            @if (auth()->check())
            @if (auth()->user()->id == 1  || auth()->user()->isAuthor() == 'true')
            <div class="card">
                <div class="card-header">Edit Task</div>
                <div class="card-body">

                {!! Form::model($task, array('url' => URL::to('/tasks/' . $task->id), 'class'=>'form-horizontal', 'method' => 'PUT', 'files' => true)) !!}

                @include('tasks.partials.form')

                {!! Form::close() !!}

                </div>
            </div>
            @endif
            @endif
        </div>
    </div>
</div>
@stop