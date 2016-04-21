<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use JWTAuth;
use \App\Post as Post;



class PostController extends Controller
{

  public function __construct(){
    $this->middleware('jwt.auth');
    $token = JWTAuth::getToken();
    $this->currentUser = JWTAuth::toUser($token);
  }

  public function index(){
    $user = $this->currentUser;
    // $userFriendsIds[] = $user->id;
    // $posts = Post::whereIn('user_id', $userFriendsIds)->latest()->take(10)->get();

    return $user->posts()->get();
  }

  public function store(Request $request){
    $user = $this->currentUser;

    $post = new Post();
    $post->body = $request->input('body');
    $post->poster_firstname = $request->input('poster_firstname');
    $post->poster_profile_image = 'url/teste.jpg';

    $user->posts()->save($post);

    return 'true';

  }


}
