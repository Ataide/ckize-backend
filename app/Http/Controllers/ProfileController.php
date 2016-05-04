<?php

namespace App\Http\Controllers;

use \App\User;
use App\Profile;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use JWTAuth;
use Input;

use App\Http\Requests;

class ProfileController extends Controller
{
    public function __construct() {
      $this->middleware('jwt.auth');
      $token = JWTAuth::getToken();
      $this->currentUser = JWTAuth::toUser($token);
    }

    public function getUserProfile(){
      $user = $this->currentUser;
      $profile = $user->profile()->firstOrFail();
      // $friends = $user->friends()->get();
      // $posts = $user->posts()->get();
      return Response::json(compact('profile'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $user = $this->currentUser;
      $profile = $user->profile()->firstOrFail();
      $friends = $user->friends()->get();
      $posts = $user->posts()->get();
      return Response::json(compact('profile','friends','posts'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $profile = $user->profile()->firstOrFail();
        $friends = $user->friends()->get();
        $posts   = $user->posts()->get();
        return Response::json(compact('profile','friends','posts'));
    }

    public function updateUserProfile(Request $request) {
      $user = User::find($this->currentUser->id);
      $profile = $user->profile()->firstOrFail();
      $user->name = Input::get('first_name').' '.Input::get('last_name');
      $profile->display_name = Input::get('first_name').' '.Input::get('last_name');
      $profile->address = $request->input('city').' - '.$request->input('state');
      $profile->first_name = Input::get('first_name');
      $profile->last_name = Input::get('last_name');
      $profile->skills = Input::get('skills');
      $profile->home_page = Input::get('home_page');
      $profile->aboutme = Input::get('aboutme');

      $user->save();
      $profile->save();

      $posts = $user->posts()->get();
  		foreach ($posts as $post) {
  			$post->poster_firstname = $user->name;
  			$post->save();
  		}

      return Response::json($profile);
    }

    public function updateUserPicture(Request $request) {

      $file = Input::file('file');

      if($file->isValid()){
          $destinationPath = 'uploads';
          $extension = $request->file('file')->getClientOriginalExtension();
          $fileName = $this->currentUser->id.'.'.$extension;
          $request->file('file')->move($destinationPath, $fileName);

          $profile = $this->currentUser->profile()->firstOrFail();

          $profile->profile_picture_url = env('APP_UPLOAD_FOLDER', '').$fileName;
          $this->currentUser->picture_url = env('APP_UPLOAD_FOLDER', '').$fileName;
          $this->currentUser->save();
          $profile->save();

          $posts = $this->currentUser->posts()->get();
      		foreach ($posts as $post) {
      			$post->poster_profile_image = env('APP_UPLOAD_FOLDER', '').$fileName;
      			$post->save();
      		}

        return Response::json(['msg' => 'File uploaded.']);
      }else{
        return Response::json(['msg' => 'File not uploaded.']);
      }

    }
}
