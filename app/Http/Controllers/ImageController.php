<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Validator;
use App\Album;
use App\Image;
use App\Comments;
use App\Rating;
use App\AccessImage;
use App\User;

class ImageController extends Controller
{

  public function __construct()
  {
        $this->middleware('auth', ['except' => ['getUpdate']]);

  }
    public function getForm($id)
  {
    $album = Album::find($id);
    return view('addimage')
    ->with('album',$album);
  }

  public function postAdd(Request $request)
  {
    $rules = [
      'album_id' => 'required|numeric|exists:albums,id',
      'image'=>'required|image'

    ];

    $input = ['album_id' => null];

    $validator = Validator::make($request->all(), $rules);
    if($validator->fails()){
        return redirect()->route('add_image', ['id' => $request->get('album_id')])->withErrors($validator)->withInput();
    }

    $file = $request->file('image');
    $random_name = str_random(8);
    $destinationPath = 'albums/';
    $extension = $file->getClientOriginalExtension();
    $filename=$random_name.'_album_image.'.$extension;
    $uploadSuccess = $request->file('image')->move($destinationPath, $filename);
    Image::create(array(
      'description' => $request->get('description'),
      'image' => $filename,
      'album_id'=> $request->get('album_id'),
      'user_id'=> auth()->user()->id,
      'rights' => $request->get('rights'),
    ));

    return redirect()->route('show_album',['id'=>$request->get('album_id')])->with('message', 'Image added');
  }

  public function postAddcomment(Request $request)
  {

    //$input = ['image_id' => null];
      Comments::create(array(
      'description' => $request->get('description'),
      'user_id'=> auth()->user()->id,
      'image_id'=> $request->get('image_id'),
    ));

    return redirect()->route('show_image',['id'=>$request->get('image_id')])->with('message', 'Comment added');
  }

  public function getDelete($id)
  {
    $image = Image::find($id);
    $image->delete();
    return redirect()->route('show_album',['id'=>$image->album_id]);
  }

  public function postMove(Request $request)
{
  $rules = array(

    'new_album' => 'required|numeric|exists:albums,id',
    'photo'=>'required|numeric|exists:images,id'

  );

  $validator = Validator::make($request->all(), $rules);

  if($validator->fails()){

    return redirect()->route('index');
  }

  $image = Image::find($request->get('photo'));
  $image->album_id = $request->get('new_album');
  //$image->increment("views");
  $image->save();
  return redirect()->route('show_album', ['id'=>$request->get('new_album')]);
}

public function getUpdate($id)
  {
	  $image = Image::with('Icomments')->find($id);
	  $image->increment("views");
	  $image->save();


      return view('image', ['image'=>$image]);
  }

  public function postPhotoRate(Request $request, $id)
  {
    if (count(Rating::where('user_id', auth()->user()->id)->where('image_id', $request->get('image_id'))->get()) == 0){
    //$image = Image::where('id', $request->get('image_id'))->get();
    $image = Image::find($request->get('image_id'));
	  $image->increment("rating");
    $image->stars += $request->get('stars');
    $image->save();

    Rating::create(array(
    'user_id'=> auth()->user()->id,
    'image_id'=> $request->get('image_id'),
  ));
  }

    return redirect('image/'.$id);
  }

  public function postSetPublic(Request $request)
  {
    $image = Image::find($request->get('image_id'));
    $image->public = $request->get('public');
    $image->save();

    return redirect()->route('show_album', ['id'=>$request->get('album_id')]);
  }


  public function postAddAccess(Request $request)
  {


      if (count(User::where('name', 'like', $request->get('addname') )->get()) == 0)
        {
          return redirect()->route('show_album', ['id'=>$request->get('album_id')])->with('message', 'User with this name does not exist');
        }
        else
        {
          $user = (User::where('name', 'like',$request->get('addname') )->first());
          if  (count(AccessImage::where([['user_id', $user->id ],['image_id',$request->get('image_id')]])->get()) == 0)  //sprawdzenie czy istnieje taki user w bazie
          {
              //sprawdzenie czy taki user juz ma access
            AccessImage::create(array(
            'user_id'=>  $user->id,
            'image_id'=> $request->get('image_id'),
            ));


            return redirect()->route('show_album', ['id'=>$request->get('album_id')])->with('message', 'Access granted');
          }
     else {
            return redirect()->route('show_album', ['id'=>$request->get('album_id')])->with('message', 'This user already has access');
          }

    }
  }

  public function postDeleteAccess(Request $request)
  {
    $access = AccessImage::where('user_id', $request->get('user_id'))->first();
    $access->delete();

    return redirect()->route('show_album', ['id'=>$request->get('album_id')])->with('message', 'Access deleted');
  }

  public function postEditImage(Request $request)
  {
   $image = Image::find($request->get('image_id'));
   $image->description = $request->get('description');
   $image->save();

   return redirect()->route('show_album', ['id'=>$request->get('album_id')])->with('message', 'Image details edited');
  }
}
