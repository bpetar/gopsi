
@extends('layouts.app')

@section('content')

<div class="w3-content" style="max-width:1400px;display:block;background-attachment: fixed;background-size:cover; width:100%;background-position:fixed;">
 <div class="w3-row">
  @if (auth()->check())
  @if (auth()->user()->id == 1  || auth()->user()->author)
  <p style="text-align: center;"><b><a href="/task/create" > [Add New Task] </a><b></p>
    @endif
    @endif

    <br>

    @if(count($tasks) === 0)

    <div class="w3-card-4 w3-margin w3-white">
      <div class="w3-container w3-padding-8">
        <h3>No tasks</h3>
      </div>
    </div>
    

    @else  

    @foreach ($tasks as $article)
    <a style="color:black;" href="/tasks/{{$article->id}}">
      <div class="w3-col l4 m6 s12 ">

        <div class="w3-card-4 w3-margin w3-white ">

          <div class="article_image" style="background:url('{{$article->image}}') no-repeat;display:block;margin-left:auto;margin-right:auto;background-size:cover; width:100%; background-position: 0px -50px; height:170px;">                
          </div>

          <div class="w3-container w3-padding-8">

           <h3 class="article_heading"><b><a href="/tasks/{{$article->id}}">{{$article->title}}</a></b></h3>
           

           <h5 style="font-style: italic;">{{$article->description}}</h5>

          </div>
        </div>
      </div>
    </a>
    @endforeach
    @endif 
</div>
</div>
@stop