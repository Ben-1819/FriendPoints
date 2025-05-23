<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    /**
     * Register function - Allows the user to create an account
     */
    public function register(RegisterRequest $request){
        log::info("Register function triggered");

        // Validate the users input
        $request->validated();
        log::info($request);
        log::info("Users input is valid");

        // Create a new user
        $user = new User([
            "first_name" => $request["first_name"],
            "last_name" => $request["last_name"],
            "email" => $request["email"],
            "password" => Hash::make($request["password"]),
        ]);
        // Save the new user
        $user->save();
        log::info("New user created");
        log::info("Users first name: {first_name}", ["first_name" => $user->first_name]);
        log::info("Users last name: {last_name}", ["last_name" => $user->last_name]);
        log::info("Users email: {email}", ["email" => $user->email]);

        // Try to create a JWT for the user
        try{
            // Create a JWT for the user
            $token = JWTAuth::fromUser($user);
        }catch(JWTException $e){
            log::info("Error, could not resolve token.");
            return response()->json(["error" => "Could not create token"], 500);
        }

        // Return a json response containing the token and the user
        return response()->json([
            "token" => $token,
            "user" => $user,
        ], 201);
    }

    /**
     * Login function - allows user to log in to their accounts
     */
    public function login(LoginRequest $request){
        log::info("Login function triggered");
        // Set the credentials variable
        $credentials = $request->only("email", "password");

        // Try to log the user in
        try{
            // If the credentials are invalid
            if(!$token = JWTAuth::attempt($credentials)){
                // Return a JSON response saying the credentials are invalid
                return response()->json(["error" => "Username or password is incorrect"], 401);
            }
        }catch(JWTException $e){
            log::info("There was an error logging in");
            return response()->json(["error" => "Could not create token"], 500);
        }

        // Return the token and when it expires
        return response()->json([
            "token" => $token,
            "expires_in" => auth("api")->factory()->getTTL() * 60.
        ]);
    }

    /**
     * Logout function - This function logs the current user out
     */
    public function logout(){
        log::info("Logout function triggered");
        // Try to invalidate the JWT currently held by the user
        try{
            JWTAuth::invalidate(JWTAuth::getToken());
        }catch(JWTException $e){
            return response()->json(["error" => "Failed to logout, please try again"], 500);
        }

        // Return a json response saying the user is successfully logged out
        return response()->json(["message" => "Successfully logged out"]);
    }

    /**
     * getUser function - This function checks to see if there is a user currently logged in
     */
    public function getUser(){
        log::info("getUser function triggered");
        // try-catch block to check if there is a user logged in
        try{
            $user = Auth::user();
            // If there is no user logged in
            if(!$user){
                log::info("There is no user logged in");
                return response()->json(["error" => "User not found"], 404);
            }
            log::info("There is a user logged in");
            // Return JSON response with logged in user
            return response()->json($user);
        }catch(JWTException $e){
            log::info("An error occured");
            return response()->json(["error" => "Failed to fetch user profile"], 500);
        }
    }
}
