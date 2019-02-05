<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Validator;
use App\Album;
use App\Ratingalbum;
use App\User;
use App\CommentsAlbum;
use App\AccessAlbum;

class AlbumsController extends Controller
{

  public function __construct()
  {
      $this->middleware('auth', ['except' => ['getList','getAlbum']]);
  }

    public function getList()
  {
      $albums = Album::with('Photos')->get();
      return view('index')->with('albums',$albums);
  }

  public function getMyAlbums()
{

    $user_id = auth()->user()->id;
    $albums = Album::where('user_id', $user_id)->get();

    return view('index')->with('albums',$albums);
}


  public function getAlbum($id)
  {
    $album = Album::with('Photos')->find($id);
	  $album->increment("views");
    $albums = Album::with('Photos')->get();

      //dd($album);
      return view('album', ['album'=>$album, 'albums'=>$albums]);
      //->with('album',$album);
  }

  public function getForm()
  {
      return view('createalbum');
  }

  public function postCreate(Request $request)
  {
      /*$rules = array(

        'name' => 'required',
        'cover_image'=>'required|image'

    );*/

      $rules = ['name' => 'required', 'cover_image'=>'required|image'];

      $input = ['name' => null];

      //Validator::make($input, $rules)->passes(); // true

      $validator = Validator::make($request->all(), $rules);
      if($validator->fails()){
        // return Redirect::route('create_album_form') ;
        return redirect()->route('create_album_form')->withErrors($validator)->withInput();
      }

      // $file = Input::file('cover_image');
      $file = $request->file('cover_image');
      $random_name = str_random(8);
      $destinationPath = 'albums/';
      $extension = $file->getClientOriginalExtension();
      $filename=$random_name.'_cover.'.$extension;
      $uploadSuccess = $request->file('cover_image')->move($destinationPath, $filename);
      $album = Album::create(array(
        'name' => $request->get('name'),
        'description' => $request->get('description'),
        'cover_image' => $filename,
        'user_id'=> auth()->user()->id,
      ));

      return redirect()->route('show_album',['id'=>$album->id])->with('message', 'Album created');
  }

  public function getDelete($id)
  {
      $album = Album::find($id);

      $album->delete();

      return Redirect::route('index');
  }

  public function getAlbumRate($id)
  {
    if (count(Ratingalbum::where('user_id', auth()->user()->id)->where('album_id', $id)->get()) == 0){
    $album = Album::with('Photos')->find($id);
	  $album->increment("rating");

    Ratingalbum::create(array(
    'user_id'=> auth()->user()->id,
    'album_id'=> $id,
  ));
}
      return redirect('/');
  }

  public function postAlbumRate(Request $request, $id)
  {
    if (count(Ratingalbum::where('user_id', auth()->user()->id)->where('album_id', $request->get('album_id'))->get()) == 0){
    $image = Album::find($request->get('album_id'));
	  $image->increment("rating");
    $image->stars += $request->get('stars');
    $image->save();

    Ratingalbum::create(array(
    'user_id'=> auth()->user()->id,
    'album_id'=> $request->get('album_id'),
  ));
  }
  return redirect('/');
}

  public function postSetPublic(Request $request)
  {
    $album = Album::find($request->get('album_id'));
    $album->public = $request->get('public');
    $album->save();
    $albums = Album::with('Photos')->get();

    return view('index', ['album'=>$album, 'albums'=>$albums]);
  }

  public function postEditAlbum(Request $request)
  {
   $album = Album::find($request->get('album_id'));
   $album->name = $request->get('name');
   $album->description = $request->get('description');
   $album->save();

   return redirect('/')->with('message', 'Album details edited');
  }

  public function postAddAccess(Request $request)
  {

      if (count(User::where('name', 'like', $request->get('addname') )->get()) == 0)
        {
          return redirect('/')->with('message', 'User with this name does not exist');
        }
        else
        {
          $user = (User::where('name', 'like', $request->get('addname') )->first());
          if  (  (count(AccessAlbum::where([['user_id', $user->id ],['album_id',$request->get('album_id')]])->get()) == 0) )  //sprawdzenie czy istnieje taki user w bazie
          {
              //sprawdzenie czy taki user juz ma access
            AccessAlbum::create(array(
            'user_id'=>  $user->id,
            'album_id'=> $request->get('album_id'),
            ));


            return redirect('/')->with('message', 'Access granted');
          }
     else {
            return redirect('/')->with('message', 'This user already has access');
          }

    }
  }

  public function postDeleteAccess(Request $request)
  {
    $access = AccessAlbum::where('user_id', $request->get('user_id'))->first();
    $access->delete();

    return redirect('/')->with('message', 'Access deleted');
  }

  public function postAddcomment(Request $request)
  {

      CommentsAlbum::create(array(
      'description' => $request->get('description'),
      'user_id'=> auth()->user()->id,
      'album_id'=> $request->get('album_id'),
    ));

    return redirect()->route('show_album',['id'=>$request->get('album_id')])->with('message', 'Comment added');
  }

}
