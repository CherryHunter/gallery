<!doctype html>
@extends('layouts.app')

<html>
<head>
<title>Image</title>
</head>
<body>
@section('content')
    <div class="col-lg-3">
      <div class="thumbnail" style="min-height: 900px; min-width: 900px;">
        <div class="caption">

   			<img style="max-height: 500px; max-width: 700px;" src="http://localhost/gallery1/public/albums/{{$image->image}}" ></a>
                 <div class="caption">
   				<!--{{$image->description}}</p>
                   <p>{{ date("d F Y",strtotime($image->created_at)) }} at {{ date("g:ha",strtotime($image->created_at)) }}</p>   -->

          <div class="well">
            <p> <h6>Added by: {{$image->user->name}}</h6></p>
            <p><h4>Description: {{$image->description}}</h4></p></div>
          <p> Views: {{$image->views}}</p>
          <p> Terms of use: {{$image->rights}}</p>

          <p>  @if ($image->rating ==0)
            {{$image->rating}}
            @else
             {{number_format($image->stars/$image->rating,2)}}
             @endif <img src="http://localhost/gallery1/public/albums/hearts2.png" width="30" height="30" ></p>
          @if (Auth::check())

          <form name="ratingphotos" method="POST"action="{{URL::route('rating_photos_post', ['id'=>$image->id])}}">
          <input type="hidden" name="image_id"value="{{$image->id}}" />
          <select  name="stars">
            @for ($i=1;$i<=5;$i++)
                <option value="{{$i}}">{{$i}}</option>
            @endfor
          </select>
          <button type="submit" class="btn btn-warning btn-small">Rate</button>
          {{ csrf_field() }}
          </form>



           <p>Add comment:</p>

           <form name="addcomment" method="POST"action="{{URL::route('add_comment')}}"enctype="multipart/form-data">
               {{ csrf_field() }}
             <input type="hidden" name="image_id"value="{{$image->id}}" />
             <fieldset>
               <div class="form-group">
                 <textarea name="description" cols="30" rows="5" type="text"class="form-control" placeholder="..."></textarea>
               </div>
               <button type="submit" class="btnbtn-default">Send!</button>
             </fieldset>
           </form>
           @endif

           <p></p>
           <p>Comments:</p>
           <p></p>
           @foreach($image->Icomments as $comment)
           <div class="well" style="min-height: 50px; min-width: 200px;">
            <p><h6>Author: {{$comment->user->name}} Data dodania: {{$comment->created_at}}</h6></p>
            <p>{{$comment->description}}</p>
          </div>
       @endforeach

        </div>
      </div>
    </div>
@endsection


</body>
</html>
