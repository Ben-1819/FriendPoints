<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

uses(RefreshDatabase::class);

// Tests to check that the register method works as intented
describe("Tests to check that the register method works as intented", function(){
    // Before each test
    beforeEach(function(){

    });

    // After each test
    afterEach(function(){
        log::info("test in RegisterTests group completed");
    });

    /**
     * Test that users can register for an account using
     * valid input data
     */
    it("tests that users can register for an account when using valid input data", function(){
        // Send a post request to the register route
        $response = $this->postJson("/api/register",[
            "first_name" => "test",
            "last_name" => "user",
            "email" => "test@gmail.com",
            "password" => "password",
        ]);

        // Declare what the response should be
        $response->assertStatus(201)
            ->assertJsonStructure([
                "token",
                "user",
            ]);
    });
    /**
     * Test that users cannot register for an account when
     * invalid data is entered in the first_name field
     */
    it("tests that users cannot register for an account when invalid data is entered in the first_name field", function(){
        // Send a post request to the register route
        $response = $this->postJson("/api/register",[
            "first_name" => "",
            "last_name" => "User",
            "email" => "email@gmail.com",
            "password" => "password",
        ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "first_name" => "First name is a required field",
            ]);
    });

    /**
     * Test that users cannot register for an account when
     * invalid data is entered in the last_name field
     */
    it("tests that users cannot register for an account when invalid data is entered in the last_name field", function(){
        // Send a post request to the register route
        $response = $this->postJson("/api/register",[
            "first_name" => "Test",
            "last_name" => "",
            "email" => "email@gmail.com",
            "password" => "password",
        ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "last_name" => "Last name is a required field",
            ]);
    });

    /**
     * Test that users cannot register for an account when
     * invalid data is entered in the email field
     */
    it("tests that users can not register when invalid data is entered in the email field", function(){
        // Make a request to the register route
        $response = $this->postJson("/api/register", [
            "first_name" => "Test",
            "last_name" => "User",
            "email" => "",
            "password" => "password",
        ]);

        // Declare what the repsonse should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "email" => "Email is a required field",
            ]);
    });

    /**
     * Test that users cannot register for an account when
     * invalid data is entered in the password field
     */
    it("tests that users can not register for an account when invalid data is entered in the password field", function(){
        // Make a request to the register route
        $response = $this->postJson("/api/register",[
            "first_name" => "Test",
            "last_name" => "User",
            "email" => "example@gmail.com",
            "password" => "",
        ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "password" => "Password is a required field",
            ]);
    });
})->group("RegisterTests");
