<!doctype html>
@extends('layouts.app')

<html>
<head>
<title>Manage</title>
</head>
<body>
@section('content')
  @foreach($users as $user)
    <div class="col-lg-3">
      <div class="thumbnail" style="min-height: 114px;">
        <div class="caption">
          <h3>{{$user->name}}</h3>
          <p>{{$user->email}}</p>
          <a href="{{URL::route('delete_user',array('id'=>$user->id))}}" onclick="returnconfirm('Are you sure?')"><button type="button"class="btn btn-danger btn-small">Usuń użytkownika</button></a>
        </div>
      </div>
    </div>
  @endforeach
@endsection


</body>
</html>
