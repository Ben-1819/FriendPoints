<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use App\Models\User;

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
        log::info("Test in the RegisterLastNameErrorsGroupComplete");
    });

    /**
     * Test that the correct error message is returned
     * when the last_name field is empty
     */
    it("tests that the correct error message is returned when the last_name field is left empty", function(){
        //Make a post request to the register route
        $response = $this->postJson("/api/register",[
            "first_name" => "Test",
            "last_name" => "",
            "email" => "example@gmail.com",
            "password" => "password",
        ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "last_name" => "Last name is a required field",
            ]);
    });

    /**
     * Test that the correct error message is returned
     * when the last_name field is not a string
     */
    it("tests that the correct error message is returned when the last_name field is not a string", function(){
        // Make a post request to the register route
        $response = $this->postJson("/api/register",[
            "first_name" => "Test",
            "last_name" => 1,
            "email" => "example@gmail.com",
            "password" => "password",
        ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "last_name" => "Last name must be of data type string",
            ]);
    });

    /**
     * Test that the correct error message is returned
     * when the last_name field is greater than 55 characters
     */
    it("tests that the correct error message is returned when the last_name field is greater than 55 characters", function(){
        // Use faker
        $faker = Faker\Factory::create();

        // Make a post request to the register route
        $response = $this->postJson("/api/register",[
            "first_name" => "Test",
            "last_name" => $faker->realTextBetween(56, 60),
            "email" => "example@gmail.com",
            "password" => "password",
        ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "last_name" => "Last name can not be longer than 55 characters",
            ]);
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
        log::info("Test in RegisterEmailErrorsTests group complete");
    });

    /**
     * Test that the correct error message is returned
     * when the email field is left empty
     */
    it("tests that the correct error message is returned when the email field is left empty", function(){
        // Make a post request to the register route
        $response = $this->postJson("/api/register",[
            "first_name" => "Test",
            "last_name" => "Test",
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
     * when the email field is not an email
     */
    it("tests that the correct error message is returned when the email field is not an email", function(){
        // Make a post request to the register route
        $response = $this->postJson("/api/register",[
            "first_name" => "Test",
            "last_name" => "Test",
            // Enter a non valid email into the email field
            "email" => "Not An Email",
            "password" => "password",
        ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "email" => "Email must be in a valid email format",
            ]);
    });

    /**
     * Tests that the correct error message is returned
     * when the entered email is already in use by another
     * user
     */
    it("tests that the correct error message is returned when the email entered by the user is already in use by another user", function(){
        // Use the user factory to create a user
        $user = User::factory()->createOne([
            // manually set the email
            "email" => "beingused@gmail.com",
        ]);

        // Make a post request to the user factory
        $response = $this->postJson("/api/register",[
            "first_name" => "Test",
            "last_name" => "Test",
            // Set the email to be the same as the one you gave the created user
            "email" => "beingused@gmail.com",
            "password" => "password",
        ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "email" => "This email is already being used for an account, please log into your account or choose a new email",
            ]);
    });

    /**
     * Tests that the correct error message is returned
     * when the email is longer than 55 characters
     */
    it("tests that the correct error message is returned when the email is longer than 55 characters", function(){
        // Use Faker
        $faker = Faker\factory::create();

        // Create a variable longer than 55 characters
        // Use fake->userName() to create a username, then repeat x 45 times and add @example.com to the end of it
        $email = fake()->userName() . str_repeat('x', 45) . '@example.com'; // ~60+ chars,

        // Make a post request to the register route
        $response = $this->postJson("/api/register",[
            "first_name" => "Test",
            "last_name" => "Test",
            // User faker to generate an email longer than 55 characters
            "email" => $email,
            "password" => "password",
        ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "email" => "Email can not be longer than 55 characters",
            ]);
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
        log::info("Test in the RegisterPasswordErrorTests group complete");
    });

    /**
     * Test that the correct error message is returned
     * when the password field is left empty
     */
    it("tests that the correct error message is returned when the password field is left empty", function(){
        // Make a post request to the register route
        $response = $this->postJson("/api/register",[
            "first_name" => "Test",
            "last_name" => "Test",
            "email" => "test@example.com",
            // Leave the password field empty
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
     * when the password field is not a string
     */
    it("tests that the correct error message is returned when the password field is not a string", function(){
        // Make a post request to the register route
        $response = $this->postJson("/api/register",[
            "first_name" => "Test",
            "last_name" => "Test",
            "email" => "test@example.com",
            // Enter a number in the password field
            "password" => 1234567,
        ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "password" => "Password must be of the data type string"
            ]);
    });

    /**
     * Test that the correct error message is retuned
     * when the password field is less than 6 characters
     */
    it("tests that the correct error message is returned when the password field is less than 6 characters", function(){
        // Make a post request to the register route
        $response = $this->postJson("/api/register",[
            "first_name" => "Test",
            "last_name" => "Test",
            "email" => "test@example.com",
            // Enter a password less than 6 characters
            "password" => "short",
        ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "password" => "Password must be at least 6 characters long",
            ]);
    });
})->group("RegisterPasswordErrorTests");
