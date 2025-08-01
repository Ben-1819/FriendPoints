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
        // Create a user using the user factory
        $this->user = User::factory()->createOne();

        // Create a friend for the user
        $this->friend = createFriend($this->user);
    });

    // After each test
    afterEach(function(){
        log::info("Test in the HistoryReasonStoreErrorsTests group complete");
    });

    /**
     * Test the correct error message is returned
     * when the reason field is left empty when
     * storing a record
     */
    it("tests the correct error message is returned when the reason field is left empty when storing a record", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable and set it to the friend's id
        $friendID = $this->friend->id;

        // Make a post request to the store history route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->postJson("/api/history/$friendID/store",[
                "id" => $friendID,
                "title" => "Test",
                // Leave the reason field empty
                "reason" => "",
                "before" => 20,
                "after" => 30,
                "change" => 10,
            ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "reason" => "Reason is a required field",
            ]);
    });

    /**
     * Test the correct error message is returned
     * when the reason field is not a string when
     * storing a record
     */
    it("tests the correct error message is returned when the reason field is not a string when storing a record", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable and set it to the friend's id
        $friendID = $this->friend->id;

        // Make a post request to the store history route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->postJson("/api/history/$friendID/store",[
                "id" => $friendID,
                "title" => "Test",
                // Put an integer in the reason field
                "reason" => 1,
                "before" => 20,
                "after" => 30,
                "change" => 10,
            ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "reason" => "Reason must be a string value",
            ]);
    });

    /**
     * Test the correct error message is returned
     * when the reason field is longer than 255
     * characters when storing a record
     */
    it("tests the correct error message is returned when the reason field is longer than 255 characters when storing a record", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable and set it to the friend's id
        $friendID = $this->friend->id;

        // Make a post request to the store history route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->postJson("/api/history/$friendID/store",[
                "id" => $friendID,
                "title" => "Test",
                // Make the reason field longer than 255 characters
                "reason" => fake()->realTextBetween(256, 260),
                "before" => 20,
                "after" => 30,
                "change" => 10,
            ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "reason" => "Reason can't be longer than 255 characters",
            ]);
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
        // Create a user using the user factory
        $this->user = User::factory()->createOne();

        // Create a friend that belongs to the user
        $this->friend = createFriend($this->user);

        // Create a history belonging to the friend
        $this->history = createHistory($this->friend);
    });

    // After each test
    afterEach(function(){
        log::info("Test in HistoryTitleUpdateErrorsTests group complete");
    });

    /**
     * Test the correct error message is returned
     * when the title field is empty when updating
     * a record
     */
    it("tests the correct error message is returned when the title field is left empty when updating a record", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable and set it to the history's id
        $historyID = $this->history->id;

        // Make a put request to the update history route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->putJson("/api/history/$historyID/update",[
                // Leave the title field empty
                "title" => "",
                "reason" => "Updated",
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
     * updating a record
     */
    it("tests the correct error message is returned when the title field is not a string when updating a record", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable and set it to the history's id
        $historyID = $this->history->id;

        // Make a put request to the update history route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->putJson("/api/history/$historyID/update",[
                // Enter an integer in the title field
                "title" => 1,
                "reason" => "Updated",
            ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "title" => "Title must be a string value",
            ]);
    });

    /**
     * Test the correct error message is returned
     * when the title field is longer than 55 characters
     * when updating a record
     */
    it("tests the correct error message is returned when the title field is longer than 55 characters when updating a record", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable and set it to the history's id
        $historyID = $this->history->id;

        // Make a put request to the update history route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->putJson("/api/history/$historyID/update",[
                // Enter a thing longer than 55 characters in the field
                "title" => fake()->realTextBetween(56, 60),
                "reason" => "Updated",
            ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "title" => "Title can't be longer than 55 characters",
            ]);
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
        // Create a user using the user factory
        $this->user = User::factory()->createOne();

        // Create a friend that belongs to the user
        $this->friend = createFriend($this->user);

        // Create a history that belongs to the friend
        $this->history = createHistory($this->friend);
    });

    // After each test
    afterEach(function(){
        log::info("Test in HistoryReasonUpdateErrorsTest group complete");
    });

    /**
     * Test the correct error message is returned
     * when the reason field is empty when updating
     * a record
     */
    it("tests the correct error message is returned when the reason field is empty when updating a record", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable and set it to the history's id
        $historyID = $this->history->id;

        // Make a put request to the update history route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->putJson("/api/history/$historyID/update",[
                "title" => "Updated",
                // Leave the reason field empty
                "reason" => "",
            ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "reason" => "Reason is a required field",
            ]);
    });

    /**
     * Test the correct error message is returned
     * when the reason field is not a string when
     * updating a record
     */
    it("tests the correct error message is returned when the reason field is not a string when updating a record", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable and set it to the history's id
        $historyID = $this->history->id;

        // Make a put request to the update history route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->putJson("/api/history/$historyID/update",[
                "title" => "Updated",
                // Enter an integer in the reason field
                "reason" => 1,
            ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "reason" => "Reason must be string value",
            ]);
    });

    /**
     * Test the correct error message is returned
     * when the reason field is longer than 255 characters
     * when updating record
     */
    it("tests the correct error message is returned when the reason field is longer than 255 characters when updating a record", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable and set it to the history's id
        $historyID = $this->history->id;

        // Make a put request to the update history route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->putJson("/api/history/$historyID/update",[
                "title" => "Updated",
                // Enter a string longer than 255 characters in the reason field
                "reason" => fake()->realTextBetween(256, 260),
            ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "reason" => "Reason can't be longer than 255 characters",
            ]);
    });
})->group("HistoryReasonUpdateErrorsTests");
