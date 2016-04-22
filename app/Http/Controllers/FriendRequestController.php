<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\FriendRequest as FriendRequest;
use App\Repositories\User\UserRepository;
use App\Repositories\FriendRequest\FriendRequestRepository;
use App\User as User;
use JWTAuth;

class FriendRequestController extends Controller
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
    public function index(UserRepository $userRepository, friendRequestRepository $friendRequestRepository)
    {
      $user = $this->currentUser;
      $requesterIds = $friendRequestRepository->getIdsThatSentRequestToCurrentUser($user->id);
      $userObjects = $userRepository->findManyById($requesterIds);

      return $userObjects;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), ['userId' => 'required']);

      if($validator->fails())
      {
        return response()->json(['response' => 'failed', 'message' => 'Something went wrong please try again.']);
      }
      else
      {
        $requestedUser = User::find($request->userId);
    		$requesterUser = $this->currentUser;
        $friendRequest = new FriendRequest();
        $friendRequest->requester_id = $this->currentUser->id;
        $requestedUser->friendRequests()->save($friendRequest);

        return response()->json(['response' => 'success', 'message' => 'Friend request submitted']);

      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId)
    {
        FriendRequest::where('user_id', $this->currentUser->id)->where('requester_id', $userId)->delete();

        $friendRequestCount = $this->currentUser->friendRequests()->count();

        return response()->json(['response' => 'success', 'count' => $friendRequestCount, 'message' => 'friend request removed']);

    }
}
