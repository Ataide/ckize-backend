<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use App\Profile;
use Validator;
use App\Realtime\Events as SocketClient;



class AuthenticateController extends Controller
{
  public $socketClient;

  public function __construct()
   {
       // Apply the jwt.auth middleware to all methods in this controller
       // except for the authenticate method. We don't want to prevent
       // the user from retrieving their token if they don't already have it
      //  $this->middleware('jwt.auth', ['only' => ['index', 'teste']]);
       $this->middleware('jwt.auth', ['only' => ['index', 'teste']]);
       $this->socketClient = new SocketClient;
   }

  public function index()
  {
    $users = User::all();
    return $users;
  }

  public function token(){

    $token = JWTAuth::parseToken()->refresh();


    return Response::json($token);


  }


 public function authenticate(Request $request)
 {
     $credentials = $request->only('email', 'password');
     //  sleep(5);

     try {
         // verify the credentials and create a token for the user
         if (! $token = JWTAuth::attempt($credentials)) {
             return response()->json(['error' => 'invalid_credentials'], 401);
         }
     } catch (JWTException $e) {
         // something went wrong
         return response()->json(['error' => 'could_not_create_token'], 500);
     }

     Artisan::call('notify:login', ['token' => $token]);

     // if no errors are encountered we can return a JWT
     return response()->json(compact('token'));
 }

 public function register (Request $request)
 {

   $validator = Validator::make($request->all(),[
     'displayName' => 'required',
     'last_name' => 'required',
     'email' => 'required|unique:users',
     'password' => 'required',
   ]);

   if($validator->fails())
   {
     return Response::json(['errors' => $validator->errors()->all()], 403);
   }

   $user = new User();
   $user->name = $request->input('displayName').' '.$request->input('last_name');
   $user->email = $request->input('email');
   $user->password = Hash::make($request->input('password'));
   $user->save();

   $profile = new Profile();
   $profile->display_name = $request->input('displayName');
   $profile->first_name = $request->input('displayName');
   $profile->last_name = $request->input('last_name');
   $profile->email = $request->input('email');

   $user->profile()->save($profile);

   return Response::json($user);

 }

 public function teste(Request $request)
 {
   $profile = \App\Profile::find($request['id']);
   $profile->display_name = $request->input('display_name');
   $profile->address = $request->input('address');
   $profile->save();


   return Response::json($profile);


 }

}
