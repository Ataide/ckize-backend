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
    }

    public function getUserProfile(){
      $token = JWTAuth::getToken();
      $user = JWTAuth::toUser($token);
      $profile = $user->profile()->first();
      return Response::json($profile);
    }

    public function updateUserProfile(Request $request) {
      $profile = Profile::find($request['id']);
      $profile->display_name = $request->input('display_name');
      $profile->address = $request->input('address');
      $profile->save();
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
