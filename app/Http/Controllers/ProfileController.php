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
      $profile = Profile::find($request['id']);
      $user = User::find($request['id']);
      $user->name = Input::get('first_name').' '.Input::get('last_name');
      $profile->display_name = Input::get('first_name').' '.Input::get('last_name');
      $profile->address = $request->input('address');
      $profile->first_name = Input::get('first_name');
      $profile->last_name = Input::get('last_name');
      $profile->skills = Input::get('skills');
      $profile->home_page = Input::get('home_page');
      $profile->aboutme = Input::get('aboutme');

      $profile->save();
      $user->save();

      $posts = $user->posts()->get();
  		foreach ($posts as $post) {
  			$post->poster_firstname = $user->name;
  			$post->save();
  		}

      return Response::json($profile);
    }

    public function updateUserPicture(Request $request) {

      // if($file->isValid()){
      //   $destinationPath = 'uploads';
      //   $extension = $request->file('image')->getClientOriginalExtension();
      //   $fileName = rand(11111,99999).'.'.$extension;
      //   $request->file('image')->move($destinationPath, $fileName);
      //   return Response::json(['msg' => 'File uploaded.']);
      // }else{
      //   return Response::json(['msg' => 'File not uploaded.']);
      // }
      return Response::json(Input::file('file'));

    }
}
