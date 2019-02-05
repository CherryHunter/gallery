<?php


Route::get('/', array('as' => 'index','uses' => 'AlbumsController@getList'));
Route::get('myalbums', array('as' => 'my_albums','uses' => 'AlbumsController@getMyAlbums'));

Route::get('/createalbum', array('as' => 'create_album_form','uses' => 'AlbumsController@getForm'));
Route::post('/createalbum', array('as' => 'create_album','uses' => 'AlbumsController@postCreate'));
Route::get('/deletealbum/{id}', array('as' => 'delete_album','uses' => 'AlbumsController@getDelete'));

Route::get('/album/{id}', array('as' => 'show_album','uses' => 'AlbumsController@getAlbum'));
Route::get('rating_album/{id}', array('as' => 'rating_album','uses' => 'AlbumsController@getAlbumRate'));
Route::post('rating_album/{id}', array('as' => 'rating_album_post','uses' => 'AlbumsController@postAlbumRate'));
Route::post('/setpublicalbum', array('as' => 'set_public_album', 'uses' => 'AlbumsController@postSetPublic'));

Route::post('/addaccessalbum', array('as' => 'add_access_album', 'uses' => 'AlbumsController@postAddAccess'));
Route::post('/deleteaccessalbum', array('as' => 'delete_access_album', 'uses' => 'AlbumsController@postDeleteAccess'));
Route::post('/editalbum', array('as' => 'edit_album', 'uses' => 'AlbumsController@postEditAlbum'));
Route::post('/addcommentalbum', array('as' => 'add_comment_album','uses' => 'AlbumsController@postAddcomment'));


Route::get('/addimage/{id}', array('as' => 'add_image','uses' => 'ImageController@getForm'));
Route::post('/addimage', array('as' => 'add_image_to_album','uses' => 'ImageController@postAdd'));
Route::get('/deleteimage/{id}', array('as' => 'delete_image','uses' => 'ImageController@getDelete'));

Route::get('/image/{id}', array('as' => 'show_image','uses' => 'ImageController@getUpdate'));
Route::post('/rating_photos/{id}', array('as' => 'rating_photos_post','uses' => 'ImageController@postPhotoRate'));
Route::post('/add_comment', array('as' => 'add_comment','uses' => 'ImageController@postAddcomment'));

Route::post('/moveimage', array('as' => 'move_image', 'uses' => 'ImageController@postMove'));
Route::post('/setpublic', array('as' => 'set_public', 'uses' => 'ImageController@postSetPublic'));
Route::post('/addaccess', array('as' => 'add_access', 'uses' => 'ImageController@postAddAccess'));
Route::post('/deleteaccess', array('as' => 'delete_access', 'uses' => 'ImageController@postDeleteAccess'));
Route::post('/editimage', array('as' => 'edit_image', 'uses' => 'ImageController@postEditImage'));



Route::get('/login', array('uses' => 'HomeController@showLogin'));
Route::post('/login', array('uses' => 'HomeController@doLogin'));
Route::get('logout', array('uses' => 'HomeController@doLogout'));
Auth::routes();
Route::get('/deleteuser/{id}', array('as' => 'delete_user','uses' => 'ManageController@getDeleteUser'));

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/manage', 'ManageController@Manage')->name('manage');
