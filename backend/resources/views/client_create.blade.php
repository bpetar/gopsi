@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
          <p><a href='/home'><- Back to home</a></p>
            @if (auth()->check())
            @if (auth()->user()->id == 1  || auth()->user()->isAuthor() == 'true')
            <div class="card">
                <div class="card-header">Add new client</div>
                <div class="card-body">

                  {!! Form::open(array('url' => URL::to('/client/add'), 'method' => 'post', 'class'=>'form-horizontal', 'files' => true)) !!}

                  {{--Client email submit form--}}
                  <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                    <label for="email" class="col-md-12 control-label">Enter email of user who has already registered to our system:</label>

                    <div class="col-md-6">
                        {!! Form::text('email', null, array('class' => 'form-control', 'placeholder'=> 'john.smith@example.com')) !!}

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                  </div>

                  <div class="form-group">
                      <div class="col-md-6 col-md-offset-4">
                          <button type="submit" class="btn btn-primary">
                              <i class="fa fa-btn fa-shield"></i> Add
                          </button>
                      </div>
                  </div>


                  {!! Form::close() !!}

{{--
                  Enter client email:
                  <input type="email" id="id-client-email" name="client_email">
                  <input type="submit" value="Add">

--}}
                </div>
            </div>
            @endif
            @endif
        </div>
    </div>
</div>
@endsection