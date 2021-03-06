
{{-- This form is used for Creating and Editing tasks --}}



{{--Task Title--}}
<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">

	<label for="title" class="col-md-4 control-label">Title</label>

	<div class="col-md-6">
	    {!! Form::text('title', null, array('class' => 'form-control', 'placeholder'=> 'Enter title here..', 'required' => 'required')) !!}

	    @if ($errors->has('title'))
	        <span class="help-block">
	            <strong>{{ $errors->first('title') }}</strong>
	        </span>
	    @endif
	</div>
</div>

{{--Task Description--}}
<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">

	<label for="description" class="col-md-4 control-label">Description</label>

	<div class="col-md-6">
	    {!! Form::textarea('description', null, array('class' => 'form-control', 'placeholder'=> 'Enter description here..', 'rows' => 3, 'cols' => 40)) !!}

	    @if ($errors->has('description'))
	        <span class="help-block">
	            <strong>{{ $errors->first('description') }}</strong>
	        </span>
	    @endif
	</div>
</div>

{{--Task Repeat--}}
<div class="form-group{{ $errors->has('repeat') ? ' has-error' : '' }}">

	<label for="repeat" class="col-md-4 control-label">Repetition</label>

	<div class="col-md-6">
	    {!! Form::text('repeat', null, array('class' => 'form-control', 'placeholder'=> 'Enter repeat count here..')) !!}

	    @if ($errors->has('repeat'))
	        <span class="help-block">
	            <strong>{{ $errors->first('repeat') }}</strong>
	        </span>
	    @endif
	</div>
</div>

<br>

<div class="form-group">
    <div class="col-md-6 col-md-offset-4">
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-btn fa-shield"></i> Submit
        </button>
    </div>
</div>
