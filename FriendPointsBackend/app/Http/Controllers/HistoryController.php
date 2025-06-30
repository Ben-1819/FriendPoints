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
        $records = History::all();

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

    /**
     * Store method - Used to store a new record in the Friend
     * table
     */
    public function store(StoreHistoryRequest $request){
        log::info("The store method in the history controller is running.");

        // Validate the users input
        $request->validated();
        log::info("Users input successfully validated");

        // Create a new record in the History table
        $history = new History([
            "friend_id" => $request["id"],
            "title" => $request["title"],
            "reason" => $request["reason"],
            "before" => $request["before"],
            "after" => $request["after"],
            "change" => $request["change"],
        ]);
        $history->save();

        log::info("Historical record added");
        log::info("Friend: {friend_id}", ["friend_id" => $request["id"]]);
        log::info("Title of change: {title}", ["title" => $request["title"]]);
        log::info("Reason for change: {reason}", ["reason" => $request["reason"]]);
        log::info("Points before: {before}", ["before" => $request["before"]]);
        log::info("Points after: {after}", ["after" => $request["after"]]);

        // Return a json response saying the history was successfully created
        return response()->json([
            "success" => "Historical record successfully created",
        ], 201);
    }

    /**
     * Show method - Shows a selected historical record
     */
    public function show($id){
        log::info("The show method in the HistoryController is running");

        // Find the record the user is requesting
        log::info("Finding the historical record that the user is requesting");
        $history = History::find($id);

        log::info("Historical record has been found");
        // Return the found historical record in a json response
        return response()->json([
            "history" => $history,
        ], 200);
    }

    /**
     * Update method - Updates a selected record
     */
    public function update(UpdateHistoryRequest $request, $id){
        log::info("Update method in the HistoryController is running");

        // Validate the users input,
        $request->validated();
        log::info("Users input validated");

        // Get the current history record matching the id
        $oldData = History::find($id);
        log::info("Current record retrieved");

        // Update the record in the History table
        $updateHistory = History::where("id", $id)->update([
            "friend_id" => $oldData->friend_id,
            "title" => $request["title"],
            "reason" => $request["reason"],
            "before" => $oldData->before,
            "after" => $oldData->after,
            "change" => $oldData->change,
        ]);
        log::info("Record updated successfully");

        // Set the updated history to the updatedHistory variable
        $updatedHistory = History::find($id);
        log::info("Updated record set to the updatedHistory variable");
        log::info("Old title: {title}", ["title" => $oldData->title]);
        log::info("New title: {title}", ["title" => $updatedHistory->title]);
        log::info("Old reason: {reason}", ["reason" => $oldData->reason]);
        log::info("New reason: {reason}", ["reason" => $updatedHistory->reason]);

        // Return a success message with a json response
        return response()->json([
            "success" => "History updated successfully",
        ], 200);
    }

    /**
     * Destroy method - Deletes a record from the History table
     */
    public function destroy($id){
        log::info("Destroy method in HistoryController running");

        // Find the record that the user wants to destroy and delete it
        History::where("id", $id)->delete();
        log::info("Record successfully deleted");

        // Return a json response containing a success message
        return response()->json([
            "success" => "Record successfully deleted"
        ], 200);
    }
}
