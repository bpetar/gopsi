
{{-- This form is used for Creating and Editing item --}}



{{--Item Title--}}
<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">

	<label for="title" class="col-md-4 control-label">Title</label>

	<div class="col-md-6">
	    {!! Form::text('title', null, array('class' => 'form-control', 'placeholder'=> 'Enter title here..')) !!}

	    @if ($errors->has('title'))
	        <span class="help-block">
	            <strong>{{ $errors->first('title') }}</strong>
	        </span>
	    @endif
	</div>
</div>


{{--List of Courses--}}
<div class="form-group">

	<label for="course_id" class="col-md-4 control-label">Chose course</label>

	<div class="col-md-6">
		{!! Form::select('course_id', $courses, null, array('class' => 'form-control')); !!}
	</div>
</div>

{{--Item Description--}}
<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">

	<label for="description" class="col-md-4 control-label">Description</label>

	<div class="col-md-6">
	    {!! Form::text('description', null, array('class' => 'form-control', 'placeholder'=> 'Enter description here..')) !!}

	    @if ($errors->has('description'))
	        <span class="help-block">
	            <strong>{{ $errors->first('description') }}</strong>
	        </span>
	    @endif
	</div>
</div>

{{--Article Category--}}
<div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">

	<label for="category" class="col-md-4 control-label">Category</label>

	<div class="col-md-6">
	    {!! Form::text('category', null, array('class' => 'form-control', 'placeholder'=> 'Enter category here..')) !!}

	    @if ($errors->has('category'))
	        <span class="help-block">
	            <strong>{{ $errors->first('category') }}</strong>
	        </span>
	    @endif
	</div>
</div>

{{--Article Tags--}}
<div class="form-group">

	<label for="tag_list" class="col-md-4 control-label">Tags</label>

	<div class="col-md-6">
	    {!! Form::select('tag_list[]', $tags, null, array('class' => 'form-control', 'multiple')) !!}
	</div>
	<label for="tag_list" class="col-md-4 control-label">New tags</label>
	<div class="col-md-6 ">
	    {!! Form::text('new_tag', null, array('class' => 'form-control', 'placeholder'=> 'Enter new tags here..')) !!}
	</div>
</div>

{{--Item Price--}}
<div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">

	<label for="price" class="col-md-4 control-label">Price</label>

	<div class="col-md-6">
	    {!! Form::text('price', null, array('class' => 'form-control', 'placeholder'=> 'Enter price here..')) !!}

	    @if ($errors->has('price'))
	        <span class="help-block">
	            <strong>{{ $errors->first('price') }}</strong>
	        </span>
	    @endif
	</div>
</div>

{{--Article video url--}}
<div class="form-group{{ $errors->has('video') ? ' has-error' : '' }}">

	<label for="video" class="col-md-4 control-label">Video URL</label>

	<div class="col-md-6">
	    {!! Form::text('video', null, array('class' => 'form-control', 'placeholder'=> 'Enter video url here..')) !!}

	    @if ($errors->has('video'))
	        <span class="help-block">
	            <strong>{{ $errors->first('video') }}</strong>
	        </span>
	    @endif
	</div>
</div>


{{--Item Image--}}
<div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">

	<label for="image" class="col-md-4 control-label">Image</label>

	<div class="col-md-6">

		{{--<div style="border: solid #cccccc 1px; width: 100%; height: 200px; background:url('/@if(! empty($item)) {{$item->image}} @endif'); background-size:cover;"></div>--}}
		
		{!! Form::file('image') !!}

		

	    
<!--
	    @if ($errors->has('image'))
	        <span class="help-block">
	            <strong>{{ $errors->first('image') }}</strong>
	        </span>
	    @endif  -->
	</div>
</div>

<br><br>

{{--Article Body--}}
<div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">

    <label for="body" class="col-md-12">Body</label>

	<div class="col-md-12">
	    {!! Form::textarea('body', null, array('class' => 'form-control', 'placeholder'=> 'Enter body here..', 'id' => 'technig')) !!}

	    @if ($errors->has('body'))
	        <span class="help-block">
	            <strong>{{ $errors->first('body') }}</strong>
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
