@extends('layouts.app')


@section('content')
<div class="w3-content" style="max-width:1400px">
  <div class="w3-card-4 w3-margin w3-white ">
    
        <h3 class="article_heading"><b>{{$task->title}}</b></h3>
        <h5 style="font-style: italic;">{{$task->description}}</h5>
  </div>

</div>

<hr>
    
@stop