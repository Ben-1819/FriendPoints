<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

uses(RefreshDatabase::class);

/**
 * Tests to check the error messages for the
 * first_name field are correct when validation
 * rules are broken
 */
describe("Tests to check that the error messages are correct whenever the validation rules for the first_name field are broken", function(){
    // Before each test
    beforeEach(function(){

    });

    // After each test
    afterEach(function(){
        log::info("Test in RegisterFirstNameErrorTests group completed");
    });

    /**
     * Test that the correct error message is returned
     * when the first_name field is left empty
     */
    it("tests that the correct error message is returned when the first_name field is left empty", function(){
        // Make a post request to the register route
        $response = $this->postJson("/api/register",[
            "first_name" => "",
            "last_name" => "User",
            "email" => "example@gmail.com",
            "password" => "password",
        ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "first_name" => "First name is a required field",
            ]);
    });

    /**
     * Test that the correct error message is returned
     * when the first_name field is not a string
     */
    it("tests that the correct error message is returned when the first_name field is not a string", function(){
        // Make a post request to the register route
        $response = $this->postJson("/api/register",[
            // Set an integer as first_name
            "first_name" => 1,
            "last_name" => "User",
            "email" => "example@gmail.com",
            "password" => "password",
        ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "first_name" => "First name must be of data type string",
            ]);
    });

    /**
     * Test that the correct error message is returned
     * when the first_name field is longer than 55 characters
     */
    it("tests that the correct error message is returned when the first_name field is longer than 55 characters", function(){
        // Use faker
        $faker = Faker\Factory::create();

        // Make a post request to the register route
        $response = $this->postJson("/api/register",[
            "first_name" => $faker->realTextBetween(56, 60),
            "last_name" => "User",
            "email" => "example@gmail.com",
            "password" => "password",
        ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "first_name" => "First name can not be longer than 55 characters",
            ]);
    });
})->group("RegisterFirstNameErrorTests");

/**
 * Tests to check the error messages for the
 * last_name field are correct when validation
 * rules are broken
 */
describe("Tests to check that the error messages are correct whenever the validation rules for the last_name are broken", function(){
    // Before each test
    beforeEach(function(){

    });

    // After each test
    afterEach(function(){

    });

    /**
     * Test that the correct error message is returned
     * when the last_name field is empty
     */
    it("tests that the correct error message is returned when the last_name field is left empty", function(){

    });

    /**
     * Test that the correct error message is returned
     * when the last_name field is not a string
     */
    it("tests that the correct error message is returned when the last_name field is not a string", function(){

    });

    /**
     * Test that the correct error message is returned
     * when the last_name field is greater than 55 characters
     */
    it("tests that the correct error message is returned when the last_name field is greater than 55 characters", function(){

    });
})->group("RegisterLastNameErrorTests");

/**
 * Tests to check the error messages for the
 * email field are correct when validation
 * rules are broken
 */
describe("Tests to check that the error messages are correct when the validation rules for the email field are broken", function(){
    // Before each test
    beforeEach(function(){

    });

    // After each test
    afterEach(function(){

    });

    /**
     * Test that the correct error message is returned
     * when the email field is left empty
     */
    it("tests that the correct error message is returned when the email field is left empty", function(){

    });

    /**
     * Test that the correct error message is returned
     * when the email field is not an email
     */
    it("tests that the correct error message is returned when the email field is not an email", function(){

    });

    /**
     * Tests that the correct error message is returned
     * when the entered email is already in use by another
     * user
     */
    it("tests that the correct error message is returned when the email entered by the user is already in use by another user", function(){

    });

    /**
     * Tests that the correct error message is returned
     * when the email is longer than 55 characters
     */
    it("tests that the correct error message is returned when the email is longer than 55 characters", function(){

    });
})->group("RegisterEmailErrorTests");

/**
 * Tests to check the error messages for the
 * password field are correct when validation
 * rules are broken
 */
describe("Tests to check that the error messages are correct when the validation rules for the password field are broken", function(){
    // Before each test
    beforeEach(function(){

    });

    // After each test
    afterEach(function(){

    });

    /**
     * Test that the correct error message is returned
     * when the password field is left empty
     */
    it("tests that the correct error message is returned when the password field is left empty", function(){

    });

    /**
     * Test that the correct error message is returned
     * when the password field is not a string
     */
    it("tests that the correct error message is returned when the password field is not a string", function(){

    });

    /**
     * Test that the correct error message is retuned
     * when the password field is less than 6 characters
     */
    it("tests that the correct error message is returned when the password field is less than 6 characters", function(){

    });
})->group("RegisterPasswordErrorTests");
