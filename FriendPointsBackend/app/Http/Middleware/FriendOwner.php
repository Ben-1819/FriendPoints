<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FriendOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        log::info("Getting the friends id from the route parameters");
        // Get the friends id from the route parameters
        $friendId = $request->route("id");

        log::info("Friends id is {friendId}, getting the matching record from the friends table", ["friendId" => $friendId]);
        // Find the matching record in the friends table
        $friend = Friend::find($friendId);

        log::info("Checking if the friend exists");
        // Use if statement to check if the friend exists
        if(!$friend){
            log::info("Friend does not exist");
            return response()->json([
                "error" => "Friend not found",
            ], 404);
        }

        log::info("The friend exists");

        log::info("Checking if the current user is the owner of the friend");
        // Use if statement to check if the current user is the owner of the friend
        if(Auth::user()->id === $friend->owner_id){
            log::info("The current user is the owner of the friend");
            // Allow the user to continue
            return $next($request);
        }else{
            log::info("The current user is not the owner of the friend");
            // Return a message telling the user they are not authorised to perform this action
            return response()->json([
                "error" => "You are not authorised to perform this action",
            ], 401);
        }
    }
}
