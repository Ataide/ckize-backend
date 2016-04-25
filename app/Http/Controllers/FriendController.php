<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use App\Repositories\User\UserRepository;
use Validator;
use App\Http\Requests;
use App\FriendRequest;

class FriendController extends Controller
{

    public function __construct(){
      $this->middleware('jwt.auth');
      $token = JWTAuth::getToken();
      $this->currentUser = JWTAuth::toUser($token);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserRepository $repository)
    {
        $user = $this->currentUser;
        $friends = $repository->findByIdWithFriends($user->id);
        return $friends;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, UserRepository $repository)
    {
      $validator = Validator::make($request->all(), ['userId' => 'required']);

      if($validator->fails())
      {
        return response()->json(['response' => 'failed', 'message' => 'Something went wrong please try again.']);
      }
      else
      {
        $this->currentUser->createFriendshipWith($request->userId);

        $repository->findById($request->userId)->createFriendshipWith($this->currentUser->id);

        FriendRequest::where('user_id', $this->currentUser->id)->where('requester_id', $request->userId)->delete();

        $friendRequestCount = $this->currentUser->friendRequests()->count();

        return response()->json(['response' => 'success', 'count' => $friendRequestCount, 'message' => 'Friend request accepted.']);
      }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId, UserRepository $userRepository)
    {
          $otherUser = $userRepository->findById($userId);

          $this->currentUser->finishFriendshipWith($userId);
          $otherUser->finishFriendshipWith($this->currentUser->id);

          return response()->json(['response' => 'success' , 'message' => 'Done.']);


    }
}
