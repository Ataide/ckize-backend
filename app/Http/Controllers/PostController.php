<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use JWTAuth;
use \App\Post;

use App\Http\Requests;

class PostController extends Controller
{

  public function __construct(){
    $this->middleware('jwt.auth');
  }

  public function getAllPosts(){
    return 'Retornar Todos Os Posts';
  }

  public function newPosts(Request $request){
    return 'Adicionar novo Posts';
  }


}
