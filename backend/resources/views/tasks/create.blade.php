@extends('layouts.app')


@section('content')
    
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <p><a href="/client/{{ Request::get('client_id') }}"><- Back to client</a></p>
            @if (auth()->check())
            @if (auth()->user()->id == 1  || auth()->user()->isAuthor() == 'true')
            <div class="card">
                <div class="card-header">Create New Task</div>
                <div class="card-body">

                {!! Form::open(array('url' => URL::to('/tasks'), 'method' => 'post', 'class'=>'form-horizontal', 'files' => true)) !!}

                @include('tasks.partials.form')

                {{--Task Client Id - invisible field--}}
                {{ Form::hidden('client_id', Request::get('client_id')) }}
                </div>

                {!! Form::close() !!}

                </div>
            </div>
            @endif
            @endif
        </div>
    </div>
</div>

@stop