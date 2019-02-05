<!doctype html>

@extends('layouts.app')

<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Gallery</title>
    <!-- Latest compiled and minified CSS -->
   <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled and minified JavaScript -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/js/bootstrap.min.js"></script>
    <style>
      body {
        padding-top: 50px;
      }
      .starter-template {
        padding: 40px 15px;
      text-align: center;
      }
    </style>
  </head>
  <body>
@section('content')

      <div class="container">

       <div class="starter-template">


        <div class="row">
          @foreach($albums as $album)

          <?php $hasaccess = 0; ?>
          @foreach($album->accessalbum as $access)
            @if (!Auth::guest() && $access->user_id == Auth::user()->id)
            <?php $hasaccess=1; ?>
            @endif

          @endforeach


          @if ( (Auth::guest() && $album->public==1) || (!Auth::guest() && Auth::user()->id == $album->user->id) || (!Auth::guest() && Auth::user()->id == $album->user->id) || (!Auth::guest() && Auth::user()->admin == 1) || (!Auth::guest() && $hasaccess==1) || (!Auth::guest() && $album->public!=2) )

                  <div class="col-lg-3" >
                    <div class="thumbnail" style="min-width: 250px; min-height: 400px;">
                      @if (Count($album->Photos) == 0)
                      <img style="max-height: 200px;min-height: 200px; max-width: 250px;" alt="{{$album->name}}" src="http://localhost/gallery1/public/albums/{{$album->cover_image}}" >
                      @else
                      <img style="max-height: 200px;min-height: 200px; max-width: 250px;" alt="{{$album->name}}" src="http://localhost/gallery1/public/albums/{{$album->Photos[0]->image}}" >
                      @endif
                      <div class="caption" style="min-height: 514px;" >
                        <h3>{{$album->name}}</h3>
                        <p>{{$album->description}}</p>
                        <p>{{count($album->Photos)}} image(s).</p>
                        <p>Addition date:  {{ date("d F Y",strtotime($album->created_at)) }} at {{date("g:ha",strtotime($album->created_at)) }}</p>
                <p> <h6>Added by: {{$album->user->name}}</h6></p>
                <p>Views: {{$album->views}}</p>

                @if(Auth::check())
                <form name="ratingalbums" method="POST"action="{{URL::route('rating_album_post', ['id'=>$album->id])}}">
                <input type="hidden" name="album_id"value="{{$album->id}}" />
                <select  name="stars">
                  @for ($i=1;$i<=5;$i++)
                      <option value="{{$i}}">{{$i}}</option>
                  @endfor
                </select>
                <button type="submit" class="btn btn-warning btn-small">Rate</button>
                {{ csrf_field() }}
                </form>
                @endif

                <p>Rating:
                  @if ($album->rating ==0)
                  {{$album->rating}}
                  @else
                   {{number_format($album->stars/$album->rating,2)}}
                   @endif
                   <img src="http://localhost/gallery1/public/albums/hearts2.png" width="30" height="30" ></p>
                        <p><a href="{{route('show_album', ['id'=>$album->id])}}" class="btn btn-big btn-default">Open album</a></p>

          @endif

                  @if (Auth::check())
                  @if (($album->user_id == Auth::user()->id) || (Auth::user()->admin == 1 ) )

                  <button class="btn btn-big btn-default" data-toggle="collapse" data-target="#{{$album->id}}"  >Edit</button>
                  <div id="{{$album->id}}" class="collapse">

                    {{ Form::open(['route' => 'edit_album'])}}
                    {{Form::hidden('album_id', $album->id)}}
                    Edit name:
                    <p>{{Form::text('name',$album->name,array('required' => 'required'))}}</p>
                    Edit description:
                    {{Form::text('description',$album->description,array('required' => 'required'))}}
                    &nbsp
                    {{Form::submit('Change!',['class' => 'btn btn-warning btn-small'])}}
                    {{Form::close()}}

                  </br>
                    {{ Form::open(['route' => 'set_public_album'])}}
                    {{Form::hidden('album_id', $album->id)}}
                    Change acces:
                    {{Form::select('public', ['1' => 'Everyone', '0' => 'Signed in', '2' => 'Chosen users'], $album->public)}}
                    &nbsp
                    {{Form::submit('Change!',['class' => 'btn btn-warning btn-small'])}}
                    {{Form::close()}}
                  </br>

                  @if ($album->public == 2)
                    <form name="addaccessalbum" method="POST"action="{{URL::route('add_access_album')}}">
                    <input type="hidden" name="album_id" value="{{$album->id}}" />
                    Add access:
                    <input type="text" name="addname" required />
                    <button type="submit" class="btn btn-warning btn-small">Add</button>
                    {{ csrf_field() }}
                    </form>

                    <form name="deleteaccessalbum" method="POST"action="{{URL::route('delete_access_album')}}">
                    <input type="hidden" name="album_id" value="{{$album->id}}" />
                    Delete access:
                    <select  name="user_id">
                        @foreach($album->accessalbum as $access)
                          <option value="{{$access->user->id}}">{{$access->user->name}}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-danger btn-small" onclick="return confirm('Are you sure?')">Delete</button>
                    {{ csrf_field() }}
                    </form>
                    @endif

                </div>
                <a href="{{route('delete_album',array('id'=>$album->id))}}" onclick="return confirm('Are yousure?')"><button type="button"class="btn btn-big btn-danger">Delete</button></a>
                  @endif
                  @endif
                </div>
              </div>
            </div>
          @endforeach
        </div>

      </div><!-- /.container -->
    </div>
	@endsection

  </body>
</html>
