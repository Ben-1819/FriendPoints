<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

uses(RefreshDatabase::class);

/**
 * Tests to check the error messages for the
 * email field are correct when validation
 * rules are broken
 */
describe("Tests to check that the error messages for the email field are correct when validation rules are broken", function(){
    // Before each test
    beforeEach(function(){

    });

    // After each test
    afterEach(function(){
        log::info("Test in the LoginEmailErrors group complete");
    });

    /**
     * Test that the correct error message is returned
     * when the email field is left blank
     */
    it("tests that the correct error message is returned when the email field is left blank", function(){
        // Make a post request to the login route
        $response = $this->postJson("/api/login",[
            // Leave the email field empty
            "email" => "",
            "password" => "password",
        ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "email" => "Email is a required field",
            ]);
    });

    /**
     * Test that the correct error message is returned
     * when the email field is not a string value
     */
    it("tests that the correct error message is returned when the email field is not a string value", function(){
        // Make a post request to the login route
        $response = $this->postJson("/api/login",[
            // Put an integer in the email field
            "email" => 1,
            "password" => "password",
        ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "email" => "Email must be of data type string",
            ]);
    });

    /**
     * Test that the correct error message is returned
     * when the email field is not an email value
     */
    it("tests that the correct error message is returned when the email field is not an email value", function(){
        // Make a post request to the login route
        $response = $this->postJson("/api/login",[
            // Use a string that is not an email as the email
            "email" => "notanemail",
            "password" => "password",
        ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "email" => "Email must be a valid email",
            ]);
    });

    /**
     * Test that the correct error message is returned
     * when the email field is longer than 55 characters
     */
    it("tests that the correct error message is returned when the email field is longer than 55 characters", function(){
        // Use faker
        $faker = Faker\Factory::create();

        // Make a post request to the login route
        $response = $this->postJson("/api/login",[
            // Use faker to enter a string greater than 55 characters into the email field
            "email" => $faker->realTextBetween(50, 55) . "@gmail.com",
            "password" => "password",
        ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "email" => "Email must be 55 characters or less",
            ]);
    });
})->group("LoginEmailErrors");

/**
 * Tests to check the error messages for the
 * password field are correct when validation
 * rules are broken
 */
describe("Tests to check that the error messages for the password field are correct when validation rules are broken", function(){
    // Before each test
    beforeEach(function(){

    });

    // After each test
    afterEach(function(){
        log::info("Tests in the LoginPasswordErrors group complete");
    });

    /**
     * Test that the correct error message is returned
     * when the password field is left empty
     */
    it("checks that the correct error message is returned when the password field is left empty", function(){
        // Make a post request to the login route
        $response = $this->postJson("/api/login",[
            "email" => "example@gmail.com",
            // Leave the password field blank
            "password" => "",
        ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "password" => "Password is a required field",
            ]);
    });

    /**
     * Test that the correct error message is returned
     * when the password field is not a string value
     */
    it("tests that the correct error message is returned when the password field is not a string value", function(){
        // Make a post request to the login route
        $response = $this->postJson("/api/login",[
            "email" => "example@gmail.com",
            // Enter an integer value as the password
            "password" => 1234567,
        ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "password" => "Password must be a string",
            ]);
    });

    /**
     * Test that the correct error message is returned
     * when the password field is less than 6 characters long
     */
    it("tests that the correct error message is returned when the password field is less than 6 characters long", function(){
        // Make a post request to the login route
        $response = $this->postJson("/api/login",[
            "email" => "example@gmail.com",
            // Make the password less than 6 characters
            "password" => "pass",
        ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "password" => "The password field must be at least 6 characters",
            ]);
    });
})->group("LoginPasswordErrors");
