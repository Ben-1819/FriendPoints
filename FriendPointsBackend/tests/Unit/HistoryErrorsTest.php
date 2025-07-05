<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Friend;
use App\Models\History;
use Tymon\JWTAuth\Facades\JWTAuth;

uses(RefreshDatabase::class);

/**
 * Tests the correct error messages are returned
 * when the validation rules for the title field
 * are broken when storing a record
 */
describe("Tests the correct error messages are returned when the validation rules for the title field are broken when storing a record", function(){
    // Before each test
    beforeEach(function(){
        // Create a user using the user factory
        $this->user = User::factory()->createOne();

        // Create a friend belonging to the user
        $this->friend = createFriend($this->user);
    });

    // After each test
    afterEach(function(){
        log::info("Test in the HistoryTitleStoreErrorsTests group complete");
    });

    /**
     * Test the correct error message is returned
     * when the title field is empty when storing
     * a record
     */
    it("tests the correct error message is returned when the title field is empty when storing a record", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable and set it to the friend's id
        $friendID = $this->friend->id;

        // Make a post request to the store history route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->postJson("/api/history/$friendID/store",[
                "id" => $friendID,
                // Leave the title field empty
                "title" => "",
                "reason" => "Test",
                "before" => 20,
                "after" => 30,
                "change" => 10,
            ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "title" => "Title is a required field",
            ]);
    });

    /**
     * Test the correct error message is returned
     * when the title field is not a string when
     * storing a record
     */
    it("tests the correct error message is returned when the title field is not a string when storing a record", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable and set it to the friend's id
        $friendID = $this->friend->id;

        // Make a post request to the store history route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->postJson("/api/history/$friendID/store",[
                "id" => $friendID,
                // Enter an integer in the title field
                "title" => 1,
                "reason" => "Test",
                "before" => 20,
                "after" => 30,
                "change" => 10,
            ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "title" => "Title must be a string value"
            ]);
    });

    /**
     * Tests the corrrect error message is returned
     * when the title field is longer than 55 characters
     * when storing a record
     */
    it("tests the correct error message is returned when the title field is longer than 55 characters when storing a record", function(){
        // Use faker
        //$faker = Faker\Factory::create();

        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable and set it to the friend's id
        $friendID = $this->friend->id;

        // Make a post request to the store history route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->postJson("/api/history/$friendID/store",[
                "id" => $friendID,
                // Enter a string longer than 55 in the title field
                "title" => fake()->realTextBetween(56, 60),
                "reason" => "Test",
                "before" => 20,
                "after" => 30,
                "change" => 10,
            ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "title" => "Title can't be longer than 55 characters",
            ]);
    });
})->group("HistoryTitleStoreErrorsTests");

/**
 * Tests the correct error messages are returned
 * when the validation rules for the reason field
 * are broken when storing a record
 */
describe("Tests the correct error messages are returned when the validation rules for the reason field are broken when storing a record", function(){
    // Before each test
    beforeEach(function(){

    });

    // After each test
    afterEach(function(){

    });

    /**
     * Test the correct error message is returned
     * when the reason field is left empty when
     * storing a record
     */
    it("tests the correct error message is returned when the reason field is left empty when storing a record", function(){

    });

    /**
     * Test the correct error message is returned
     * when the reason field is not a string when
     * storing a record
     */
    it("tests the correct error message is returned when the reason field is not a string when storing a record", function(){

    });

    /**
     * Test the correct error message is returned
     * when the reason field is longer than 255
     * characters when storing a record
     */
    it("tests the correct error message is returned when the reason field is longer than 255 characters when storing a record", function(){

    });
})->group("HistoryReasonStoreErrorsTests");

/**
 * Tests the correct error messages are returned
 * when the validation rules for the title field
 * are broken when updating a record
 */
describe("Tests the correct error messages are returned when the validation rules for the title field are broken when updating a record", function(){
    // Before each test
    beforeEach(function(){

    });

    // After each test
    afterEach(function(){

    });

    /**
     * Test the correct error message is returned
     * when the title field is empty when updating
     * a record
     */
    it("tests the correct error message is returned when the title field is left empty when updating a record", function(){

    });

    /**
     * Test the correct error message is returned
     * when the title field is not a string when
     * updating a record
     */
    it("tests the correct error message is returned when the title field is not a string when updating a record", function(){

    });

    /**
     * Test the correct error message is returned
     * when the title field is longer than 55 characters
     * when updating a record
     */
    it("tests the correct error message is returned when the title field is longer than 55 characters when updating a record", function(){

    });
})->group("HistoryTitleUpdateErrorsTests");

/**
 * Tests the correct error messages are retruned
 * when the validation rules for the reason field
 * are broken when updating a record
 */
describe("Tests the correct error messages are returned when the validation rules for the reason field are broken when updating a record", function(){
    // Before each test
    beforeEach(function(){

    });

    // After each test
    afterEach(function(){

    });

    /**
     * Test the correct error message is returned
     * when the reason field is empty when updating
     * a record
     */
    it("tests the correct error message is returned when the reason field is empty when updating a record", function(){

    });

    /**
     * Test the correct error message is returned
     * when the reason field is not a string when
     * updating a record
     */
    it("tests the correct error message is returned when the reason field is not a string when updating a record", function(){

    });

    /**
     * Test the correct error message is returned
     * when the reason field is longer than 255 characters
     * when updating record
     */
    it("tests the correct error message is returned when the reason field is longer than 255 characters when updating a record", function(){

    });
})->group("HistoryReasonUpdateErrorsTests");
