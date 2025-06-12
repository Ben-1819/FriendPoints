<?php

namespace App\Http\Controllers;

use App\Models\History;

use App\Http\Requests\StoreHistoryRequest;
use App\Http\Requests\UpdateHistoryRequest;

use Illuminate\Support\Facades\Log;
class HistoryController extends Controller
{
    /**
     * Index function - Returns a list of all records
     * in the History table
     */
    public function index(){
        log::info("Index method in HistoryController running");

        // Query the database to retrieve all records by most recent
        $records = History::all()->latest();

        log::info("All records retrieved");

        // Return a json response containing the records
        return response()->json([
            "records" => $records,
        ], 200);
    }

    /**
     * FriendIndex method - Returns a list of all records
     * in the History table where the friend_id column
     * matches the id passed in the parameters
     */
    public function friendIndex($id){
        log::info("friendIndex method in the HistoryController running");

        /**
         * Query the database to retrieve all records where
         * the friend_id column matches the id passed in the
         * parameters
         */
        $records = History::where("friend_id", $id)->latest();

        log::info("Records successfully retrieved");
        // Return the records in a json response
        return response()->json([
            "records" => $records
        ], 200);
    }
}
