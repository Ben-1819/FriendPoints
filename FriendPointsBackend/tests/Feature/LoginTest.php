<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use App\Models\User;

uses(RefreshDatabase::class);

/**
 * Tests to check the login method works as intented
 */
describe("Tests to check that the login method works as intented", function(){
    // Before each test
    beforeEach(function(){
        // Create a user using the user factory
        $this->user = User::factory()->createOne([
            // Set the password to password
            "password" => Hash::make("password"),
        ]);
    });

    // After each test
    afterEach(function(){
        log::info("Test in the LoginTests group complete");
    });

    /**
     * Test to check the login method works when
     * valid data is entered and the account exists
     */
    it("tests that the login method works when valid data is entered and the account exists", function(){
        // Make a post request to the login route
        $response = $this->postJson("/api/login",[
            // Set the email to the created users email
            "email" => $this->user->email,
            // Set the password to password
            "password" => "password",
        ]);

        // Define what the response should be
        $response->assertJsonStructure([
            "token",
            "expires_in",
        ]);
    });

    /**
     * Test to check the login method does not work when
     * the user enters invalid data and the account exists
     */
    it("tests that the login method doesn't work when the user enters invalid data and the account does not exist", function(){
        // Make a post request to the login route
        $response = $this->postJson("/api/login",[
            "email" => $this->user->email,
            "password" => ""
        ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "password" => "Password is a required field",
            ]);
    });

    /**
     * Test to check the login method does not work when
     * the user enters invalid credentials and the account exists
     */
    it("tests that the login method works when the user enters invalid credentials and the account exists", function(){
        // Make a post request to the login route
        $response = $this->postJson("/api/login",[
            "email" => $this->user->email,
            "password" => "PASSWORD",
        ]);

        // Declare what the response should be
        $response->assertStatus(401)
            ->assertJsonStructure([
                "error",
            ]);
    });

    /**
     * Test to check the login method does not work when
     * the user enters valid data and the account does not exist
     */
    it("tests that the login method does not work when the user enters valid data and the account doesn't exist", function(){
        // Make a post request to the login route
        $response = $this->postJson("/api/login", [
            "email" => "example@email.com",
            "password" => "Password",
        ]);

        // Declare what the response should be
        $response->assertStatus(401)
            ->assertJsonStructure([
                "error",
            ]);
    });

    /**
     * Test to check the login method does not work when
     * the user enters invalid data and the account does not exist
     */
    it("tests that the login method does not work when the user enters invalid data and the account doesn't exist", function(){
        // Make a post request to the login route
        $response = $this->postJson("/api/login",[
            "email" => "",
            "password" => "PASSWORD",
        ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "email" => "Email is a required field",
            ]);
    });
})->group("LoginTests");

/**
 * Tests to ensure the logout method works as intened
 */
describe("Tests to check that the logout method works as intented", function(){
    // Before each test
    beforeEach(function(){

    });

    // After each test
    afterEach(function(){

    });

    /**
     * Test to check the logout method returns the correct status
     * when the logout method is successful
     */
    it("tests that the correct error message is returned when the logout method is successful", function(){

    });

    /**
     * Test to check the logout method returns the correct status
     * and error message when the logout method is invalid
     */
    it("tests that the logout method returns the correct status and error message when the logout method is invalid", function(){

    });
})->group("LogoutTests");

/**
 * Tests to ensure the getUser method works as intented
 */
describe("Tests to check that the getUser method works as intented", function(){
    // Before each test
    beforeEach(function(){

    });

    // After each test
    afterEach(function(){

    });

    /**
     * Test to check the getUser method works when
     * there is a user logged in
     */
    it("tests that the getUser method works when there is a user logged in", function(){

    });

    /**
     * Test to check the getUser method does not work
     * when there is no user logged in
     */
    it("tests that the getUser method doesn't work when there is no user logged in", function(){

    });

    /**
     * Test to check the getUser method does not work
     * when the JWT is invalid
     */
    it("tests that the getUser method doesn't work when the users JWT is invalid", function(){

    });
})->group("GetUserTests");
