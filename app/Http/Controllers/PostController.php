<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Repositories\Feed\FeedRepository;
use Illuminate\Support\Facades\Artisan;
use JWTAuth;
use \App\Post as Post;



class PostController extends Controller
{

  public function __construct(){
    $this->middleware('jwt.auth');
    $this->token = JWTAuth::getToken();
    $this->currentUser = JWTAuth::toUser($this->token);
  }

  public function index(FeedRepository $feedRepository){
    $user = $this->currentUser;
    $feeds = $feedRepository->getPublishedByUserAndFriends($user);
    $friendsUserIds[] = $user->id;
		$feedsCount = Post::getTotalCountFeedsForUser($friendsUserIds);
    //modifcar para o ajax paginator
    return $feeds;
  }

  public function store(Request $request){
    $user = $this->currentUser;
    $post = new Post();
    $post->body = $request->input('body');
    $post->poster_firstname = $request->input('poster_firstname');
    $post->poster_profile_image = $user->profile()->first()->profile_picture_url;
    $user->posts()->save($post);
    Artisan::call('notify:post', ['token' => $this->token]);
    return 'true';

  }

  public function destroy($id) {
    $user = $this->currentUser;
    $post = Post::find($id);
    if($post->user_id == $user->id) {
      $post->delete();
      return response()->json(['response' => 'success', 'message' => 'Post deleted']);
    } else {
      return response()->json(['response' => 'failed', 'message' => 'Something went wrong please try again.']);;
    }
  }


}
