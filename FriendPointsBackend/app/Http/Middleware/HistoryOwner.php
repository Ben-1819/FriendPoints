<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\History;
use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HistoryOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        log::info("Getting the historical records id from the route parameters");
        // Get the historical records id from the route parameters
        $historyId = $request->route("id");

        log::info("Records id is {historyId}, getting the matching record from the histories table", ["historyId" => $historyId]);
        // Find the matching record in the histories table
        $history = History::with('friend')->find($historyId);

        log::info("Checking if the history exists");
        // Use if statement to check if the history exists
        if(!$history){
            log::info("History does not exist");
            return response()->json([
                "error" => "History not found",
            ], 404);
        }

        log::info("The History exists");

        log::info("Checking if the current user is the owner of the friend the history is about");
        // Use if statement to check if the current user is the owner of the friend
        if(Auth::user()->id === $history->friend->owner_id){
            log::info("The current user is the owner of the history");
            // Allow the user to continue
            return $next($request);
        }else{
            log::info("The current user is not the owner of the friend");
            // Return a message telling the user they are not authorised to perform this action
            return response()->json([
                "error" => "You are not authorised to perform this action",
            ], 403);
        }
    }
}
