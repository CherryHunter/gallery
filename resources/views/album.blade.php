<!doctype html>

@extends('layouts.app')
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>{{$album->name}}</title>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="http://localhost/gallery1/css/lightbox.css">
    <script src="http://localhost/gallery1/js/lightbox-plus-jquery.js"></script>
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
        <div class="media">
         <a href="http://localhost/gallery1/public/albums/{{$album->cover_image}}" data-lightbox="{{$album->name}}1" style="cursor:zoom-in;">
			<img id="img" class="media-object pull-left"alt="{{$album->name}}" src="http://localhost/gallery1/public/albums/{{$album->cover_image}}" width="350px"></button></a>
          <div class="media-body">
            <h2 class="media-heading" style="font-size: 26px;">Album Name: </h2>{{$album->name}}
			 <h2 class="media-heading" style="font-size: 26px;">Description:</h2> {{$album->description}}
          <div class="media-heading" >
		  <p></p>
        @if (Auth::check())
        @if (($album->user_id == Auth::user()->id) || (Auth::user()->admin == 1 ) )
          <a href="{{route('add_image',array('id'=>$album->id))}}"><button type="button"class="btn btn-default btn-large" >Add New Image to Album</button></a>
          <a href="{{route('delete_album',array('id'=>$album->id))}}" onclick="return confirm('Are yousure?')"><button type="button"class="btn btn-danger btn-large">Delete Album</button></a>
          @endif
        @endif


        </div>
      </div>

    </div>

    </div>

    <div class="row">


        @foreach($album->Photos as $photo)


        <?php $hasaccess = 0; ?>
        @foreach($photo->accessimage as $access)
          @if (!Auth::guest() && $access->user_id == Auth::user()->id)
          <?php $hasaccess=1; ?>
          @endif
        @endforeach

        @if ( (Auth::guest() && $photo->public==1) || (!Auth::guest() && Auth::user()->id == $photo->user->id) || (!Auth::guest() && Auth::user()->id == $photo->user->id) || (!Auth::guest() && Auth::user()->admin == 1) || (!Auth::guest() && $hasaccess==1) || (!Auth::guest() && $photo->public!=2) )
                  <div class="col-lg-3">
                    <div class="thumbnail" style="min-width: 400px; min-height: 400px;" >
        			 <a href="http://localhost/gallery1/public/albums/{{$photo->image}}" data-lightbox="{{$album->name}}" style="cursor:zoom-in;">
        			<img style="max-height: 200px;min-height: 200px; max-width: 400px;" alt="{{$album->name}}" src="http://localhost/gallery1/public/albums/{{$photo->image}}" ></a>
                      <div class="caption">

                <p> <h6>Added by: {{$photo->user->name}}</h6></p>
                  <p><h5> {{$photo->description}}</h5></p>
                <p> Views: {{$photo->views}}</p>
                <p> Terms of use: {{$photo->rights}}</p>
              	<a href="{{route('show_image', ['id'=>$photo->id])}}" class="btn btn-big btn-default">Show</a>

      @endif

      @if (Auth::check())
      @if (($photo->user_id == Auth::user()->id) || (Auth::user()->admin == 1 ) )

      <button class="btn btn-big btn-default" data-toggle="collapse" data-target="#{{$photo->id}}"  >Edit</button>
      <div id="{{$photo->id}}" class="collapse">

      {{ Form::open(['route' => 'edit_image'])}}
      {{Form::hidden('image_id',$photo->id)}}
      {{Form::hidden('album_id', $album->id)}}
      Edit description:
      {{Form::text('description',$photo->description,array('required' => 'required'))}}
      &nbsp
      {{Form::submit('Change!',['class' => 'btn btn-warning btn-small'])}}
      {{Form::close()}}

      {{ Form::open(['route' => 'set_public'])}}
      {{Form::hidden('image_id',$photo->id)}}
      {{Form::hidden('album_id', $album->id)}}
      Change acces:
      {{Form::select('public', ['1' => 'Everyone', '0' => 'Signed in', '2' => 'Chosen users'], $photo->public)}}
      &nbsp
      {{Form::submit('Change!',['class' => 'btn btn-warning btn-small'])}}
      {{Form::close()}}

      @if ($photo->public == 2)
      <form name="addaccess" method="POST"action="{{URL::route('add_access')}}">
      <input type="hidden" name="image_id" value="{{$photo->id}}" />
      <input type="hidden" name="album_id" value="{{$album->id}}" />
      Add access:
      <input type="text" name="addname" required />
      <button type="submit" class="btn btn-warning btn-small">Add</button>
      {{ csrf_field() }}
      </form>

      <form name="deleteaccess" method="POST"action="{{URL::route('delete_access')}}">
      <input type="hidden" name="image_id" value="{{$photo->id}}" />
      <input type="hidden" name="album_id" value="{{$album->id}}" />
      Delete access:
      <select  name="user_id">
          @foreach($photo->accessimage as $access)
            <option value="{{$access->user->id}}">{{$access->user->name}}</option>
          @endforeach
      </select>
      <button type="submit" class="btn btn-danger btn-small" onclick="return confirm('Are you sure?')">Delete</button>
      {{ csrf_field() }}
      </form>
      @endif

                <form name="movephoto" method="POST"action="{{URL::route('move_image')}}">
                  Move image:
                  <select  name="new_album">
                    @foreach($albums as $others)
                    @if ($others->user_id == Auth::user()->id)
                      <option value="{{$others->id}}">{{$others->name}}</option>
                    @endif
                    @endforeach
                  </select>
				<button type="submit" class="btn btn-warning btn-small" onclick="return confirm('Are you sure?')">Move</button>

                {{ csrf_field() }}

                  <input type="hidden" name="photo"value="{{$photo->id}}" />
                </form>

                </div>

                <a href="{{URL::route('delete_image',array('id'=>$photo->id))}}" onclick="return confirm('Are you sure?')"><button type="button"class="btn btn-big btn-danger">Delete</button></a>

                @endif
                @endif
              </div>

            </div>

          </div>

      @endforeach

  </div>
            @if (Auth::check())
            <p>Add comment:</p>

            <form name="addcommentalbum" method="POST"action="{{URL::route('add_comment_album')}}"enctype="multipart/form-data">
                {{ csrf_field() }}
              <input type="hidden" name="album_id"value="{{$album->id}}" />
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
            @foreach($album->comments as $comment)
            <div class="well" style="min-height: 50px; min-width: 200px;">
             <p><h6>Author: {{$comment->user->name}} Date: {{$comment->created_at}}</h6></p>
             <p>{{$comment->description}}</p>
           </div>
        @endforeach






      </div>
      </div>
  </div>
    </div>

    <!-- Latest compiled and minified JavaScript -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script-->

</script>
@endsection
  </body>
</html>
