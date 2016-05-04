<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Repositories\User\UserRepository;
use JWTAuth;
use App\Http\Requests;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    protected $user = null;

    public function __construct(User $user)
    {
      $this->middleware('jwt.auth');
      $token = JWTAuth::getToken();
      $this->currentUser = JWTAuth::toUser($token);
    }

    public function index(UserRepository $userRepository){
      return $userRepository->findAllUsers();
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
