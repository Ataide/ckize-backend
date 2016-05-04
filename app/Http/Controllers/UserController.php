<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Repositories\User\UserRepository;
use JWTAuth;
use App\Http\Requests;
use Illuminate\Support\Facades\Response;
use DB;

class UserController extends Controller
{
    protected $user = null;

    public function __construct(User $user)
    {
      $this->middleware('jwt.auth');
      $token = JWTAuth::getToken();
      $this->currentUser = JWTAuth::toUser($token);
    }

    public function index(){
      $friendsIds = DB::table('friends')->where('requested_id',$this->currentUser->id)->lists('requester_id');
      $users = User::with(['profile'])->where('id','!=',$this->currentUser->id)->get();

      foreach ($users as $user)
      {
        if(in_array($user->id,$friendsIds)) {
           $user->isFriend = true;
         }else{
           $user->isFriend = false;
         }
       }

      return $users;
    }


    public function allUsers()
    {
        return $this->user->allUsers();
    }

    public function getUser($id)
    {
        $user = $this->user->getUser($id);
        if(!$user)
        {
            return Response::json(['response' => 'Usuário não encontrado"'], 400);
        }
        return Response::json($user, 200);

    }




}
