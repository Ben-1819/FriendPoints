<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\User;
use App\Http\Requests\StoreFriendRequest;
use App\Http\Requests\UpdateFriendRequest;
use App\Http\Requests\UpdatePointsRequest;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    /**
     * Index method - returns all records from the friends table where
     * the owner_id column matches the current users id
     */
    public function index(){
        log::info("Index method running");

        /**
         * Get all records from the friends table where the owner_id
         * column matches the currently logged in users id
         */
        $all_friends = Friend::where("owner_id", Auth::user()->id)
            ->orderBy("points", "desc")
            ->get();
        log::info("All friends successfully retrieved");

        // Return the json response containing the friends
        return response()->json([
            "friends" => $all_friends,
        ],200);
    }

    /**
     * group1Friends method - returns all records from the friends table where
     * the owner_id column matches the current users id and the value in
     * the group column is either "Both" or "Group 1"
     */
    public function group1Friends(){
        log::info("group1Friends method running");

        /**
         * Get all records from the friends table where the owner_id
         * column matches the logged in users id and the group column
         * is either "Both" or "Group 1"
         */
        $group1_friends = Friend::where("owner_id", Auth::user()->id)
            ->whereIn("group", ["Both", "Group1"])
            ->orderBy("points", "desc")
            ->get();
        log::info("All group 1 friends successfully retrieved");

        // Return the retrieved data in a json response
        return response()->json([
            "friends" => $group1_friends,
        ], 200);
    }

    /**
     * group2Friends method - returns all records from the friends table where
     * the owner_id column matches the current users id and the value in the
     * group column is either "Both" or "Group 2"
     */
    public function group2Friends(){
        log::info("group2Friends method running");

        /**
         * Get all records from the friends table where the owner_id
         * matches the current logged in users id and the group column
         * is either "Both" or "Group 2"
         */
        $group2_friends = Friend::where("owner_id", Auth::user()->id)
            ->whereIn("group", ["Both", "Group2"])
            ->orderBy("points", "desc")
            ->get();
        log::info("All group 2 friends successfully retrived");

        // Return the retrieved records in a json response
        return response()->json([
            "friends" => $group2_friends,
        ], 200);
    }

    /**
     * otherIndex method - Retrieves all records from the friends table
     * where the owner_id coulmn matches the id passed in the route parameters
     */
    public function otherIndex($id){
        log::info("otherIndex method running");

        /**
         * Retrieve all records from the friends table where
         * the owner_id column matches the id of the owner passed in
         */
        $all_friends = Friend::where("owner_id", $id)
            ->orderBy("points", "desc");
        log::info("All friends for user with an id of {id} retrieved", ["id" => $id]);

        // Return the retrieved records in a json response
        return response()->json([
            "friends" => $all_friends,
        ], 200);
    }

    /**
     * otherGroup1Friends method - Returns all records from the friends table
     * where owner_id matches the id passed in the route parameters and the group
     * column is either "Both" or "Group 1"
     */
    public function otherGroup1Friends($id){
        log::info("otherGroup1Friends method running");

        /**
         * Retrieve all records from the friends table where the owner_id matches
         * the id passed in the route parameters and the value of the group column
         * is either "Both" or "Group 1"
         */
        $group1_friends = Friend::where("owner_id", $id)
            ->whereIn("group", ["Both", "Group 1"])
            ->orderBy("points", "desc")
            ->get();
        log::info("All group 1 friends belonging to user {id} retrieved", ["id" => $id]);

        // Return the retrieved records in a json response
        return response()->json([
            "friends" => $group1_friends,
        ], 200);
    }

    /**
     * otherGroup2Friends method - Returns all records from the friends table
     * where the owner_id matches the id passed in the route parameters and the
     * group column has a value of "Both" or "Group 2"
     */
    public function otherGroup2Friends($id){
        log::info("otherGroup2Friends method running");

        /**
         * Retrieve all records from the friends table where the owner_id matches
         * the id passed in the route parameters and the value of the group column
         * is either "Both" or "Group 2"
         */
        $group2_friends = Friend::where("owner_id", $id)
            ->whereIn("group", ["Both", "Group 2"])
            ->orderBy("points", "desc")
            ->get();
        log::info("All group 2 friends for user {id} successfully retrieved", ["id" => $id]);

        // Return the retrieved records in a json response
        return response()->json([
            "friends" => $group2_friends,
        ], 200);
    }

    /**
     * ShowOptions method - shows a list of all users that the user has
     * not already got as a friend
     */
    public function showOptions(){
        log::info("showOptions method running");

        /**
         * Query the friends table to get the id of all users that
         * the user has already added as a friend
        */
        $friendIds = Friend::where("owner_id", Auth::user()->id)->pluck("user_id");
        log::info("Retrieved the ids belonging to the users who are currently friends");

        /**
         * Query the users table to retrieve all records with ids that
         * do not match the ids retrieved in the last query and also
         * don't match the current users id
         */
        $options = User::whereNotIn("id", $friendIds)
            ->where("id", "!=", Auth::user()->id)
            ->get();
        log::info("Retrieved the ids belonging to the users who are not currently friends");

        // Return the retrieved records
        return response()->json([
            "options" => $options,
        ], 200);
    }

    /**
     * Store method - Stores a new record in the friends table
     */
    public function store(StoreFriendRequest $request, $id){
        log::info("Store method running");

        // Validate the users input
        $request->validated();
        log::info("Users input validated successfully");

        // Store the new record in the friends table
        $friend = new Friend([
            "user_id" => $id,
            "owner_id" => Auth::user()->id,
            "group" => $request["group"],
            "points" => $request["points"],
        ]);
        $friend->save();

        log::info("New friend saved successfully");
        log::info("New friends user id: {user_id}", ["user_id" => $friend->user_id]);
        log::info("New friends owner id: {owner_id}", ["owner_id" => $friend->owner_id]);
        log::info("New friends group: {group}", ["group" => $friend->group]);
        log::info("New friends points: {points}", ["points" => $friend->points]);

        // Return a success message
        return response()->json([
            "success" => "New friend successfully added",
        ], 201);
    }

    /**
     * update method - allows you to update the group that a specified friend is in
     */
    public function update(UpdateFriendRequest $request, $id){
        log::info("Update function running");

        // Validate the users input
        $request->validated();
        log::info("Users input successfully validated");

        // Get the record belonging to the specified record in the friend table
        $friend = Friend::find($id);
        log::info("Record belonging to the specified friend retreived");

        // Update the record in the friend table
        $update_friend = Friend::where("id", $id)->update([
            "user_id" => $friend->user_id,
            "owner_id" => $friend->owner_id,
            "group" => $request["group"],
            "points" => $friend->points,
        ]);
        // Set the updated friend to the updated_friend variable
        $updated_friend = Friend::find($id);
        log::info("Friend successfully updated");
        log::info("Friends group: {group}", ["group" => $updated_friend->group]);

        // Return a success message as a json response
        return response()->json([
            "success" => "Friend successfully updated",
        ], 204);
    }

    /**
     * addPoints method - Allows the amount of points a friend has to be increased
     */
    public function addPoints(UpdatePointsRequest $request, $id){
        log::info("addPoints method running");

        // Validate the users input
        $request->validated();
        log::info("Input validated successfully");

        // Get the record belonging to the friend that you are updating the points for
        $friend = Friend::find($id);
        log::info("Found the record belonging to the friend being updated");

        // Update the record in the friends table
        $update_friend = Friend::where("id", $id)->update([
            "user_id" => $friend->user_id,
            "owner_id" => $friend->owner_id,
            "group" => $friend->group,
            "points" => $friend->points + $request["points"],
        ]);
        log::info("Friend successfully updated");
        // Get the new record belonging to the friend
        $updated_friend = Friend::find($id);
        log::info("Friends new points: {points}", ["points" => $updated_friend->points]);

        /**
         * Return a json response containing a success message, the friends id,
         * the points before the update, the points after the update and the
         * change in points
         */
        return response()->json([
            "success" => "Points successfully added",
            "id" => $id,
            "before" => $friend->points,
            "after" => $updated_friend->points,
            "change" => $updated_friend->points - $friend->points,
        ], 204);
    }

    /**
     * removePoints method - Allows the amount of points a friend has to be decreased
     */
    public function removePoints(UpdatePointsRequest $request, $id){
        log::info("removePoints method running");

        // Validate the users input
        $request->validated();
        log::info("Users input successfully validated");

        // Get the record belonging to the friend from the friends table
        $friend = Friend::find($id);
        log::info("Record belonging to target friend successfully retrieved");

        // Update the record in the friends table
        $update_friend = Friend::where("id", $id)->update([
            "user_id" => $friend->user_id,
            "owner_id" => $friend->owner_id,
            "group" => $friend->group,
            "points" => $friend->points - $request["points"],
        ]);
        log::info("Friend updated successfully");
        // Get the updated record from the friends table
        $updated_friend = Friend::find($id);
        log::info("Friends new points: {points}", ["points" => $updated_friend->points]);

        /**
         * Return a json response containing a success message,
         * the friends id, the points before the change, the new
         * amount of points and the change in points
         */
        return response()->json([
            "success" => "Points successfully removed",
            "id" => $id,
            "before" => $friend->points,
            "after" => $updated_friend->points,
            "change" => $friend->points - $updated_friend->points,
        ], 204);
    }

    /**
     * destroy method - Allows a record to be deleted from the friends list.
     */
    public function destroy($id){
        log::info("Destroy function running");

        // Delete the specified record from the friends table
        Friend::where("id", $id)->delete();
        log::info("Friend successfully deleted");

        // Return a json response with a success message
        return response()->json([
            "success" => "Friend successfully deleted",
        ], 200);
    }
}
