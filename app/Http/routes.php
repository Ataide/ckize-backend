<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use \App\User;

Route::get('/', function () {
  return 'Estamos pra Uso!!!:)';
});

Route::get('/users', function(){
  $users = \App\User::find(2);
  return $users;

});


Route::group(['prefix' => 'api' , 'middleware' => 'cors'], function(){

  Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);

  Route::post('authenticate' , 'AuthenticateController@authenticate');

  Route::get('token', 'AuthenticateController@token');

  Route::post('register' , 'AuthenticateController@register');

    //Prefix /user
    Route::group(['prefix' => 'user'], function(){

      Route::get('profile','ProfileController@getUserProfile');

      Route::put('profile', 'ProfileController@updateUserProfile');

      Route::post('profile/update_picture', 'ProfileController@updateUserPicture');
    });

    //Prefix /posts
    Route::group(['prefix' => 'posts'], function(){

      Route::get('' , 'PostController@getAllPosts');

      Route::post('', 'PostController@newPosts');

    });


    Route::get('/restricted', [
     'before' => 'jwt-auth',
     function () {
         $token = JWTAuth::getToken();
         $user = JWTAuth::toUser($token);

         return Response::json([
             'data' => [
                 'email' => $user->email,
                 'registered_at' => $user->created_at->toDateTimeString()
             ]
         ]);
     }
  ]);

});



//
// Route::group(['prefix'=>'user'], function(){
//
//     Route::get('', ['uses' => 'UserController@allUsers']);
//
//     Route::get('{id}', ['uses' => 'UserController@getUser']);
//
// //    Route::post('', function(){});
// //    Route::put('{id}', function($id){});
// //    Route::delete('{id}', function($id){});
//
// });







/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
