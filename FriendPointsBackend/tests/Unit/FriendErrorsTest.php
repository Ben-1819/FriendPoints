<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

uses(RefreshDatabase::class);

/**
 * Tests that check the correct error message is
 * returned when the validation rules for the group
 * field are broken when creating a friend
 */
describe("tests that check the correct error message is returned when the validation rules for the group field are broken when creating a friend", function(){
    // Before each test
    beforeEach(function(){
        // Create a user using the user factory
        $this->user = User::factory()->create([
            "password" => "password",
        ]);

        // Create a second user to be used as a friend
        $this->user2 = User::factory()->create([
            "password" => "password 2",
        ]);
    });

    // After each test
    afterEach(function(){
        log::info("Test in FriendStoreGroupErrorsTests group complete");
    });

    /**
     * Test the correct error message is returned
     * when the group field is left empty
     */
    it("tests the correct error message is returned when the group field is left empty", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable using the second user's id
        $user2ID = $this->user2->id;

        // Make a post request to the store route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->postJson("/api/$user2ID/store",[
                // Leave the group field empty
                "group" => "",
                "points" => 500,
            ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "group" => "Group is a required field",
            ]);
    });

    /**
     * Test the correct error message is returned
     * when the group field is not a string value
     */
    it("tests the correct error message is returned when the data entered in the group field is not a string value", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable using the second user's id
        $user2ID = $this->user2->id;

        // Make a post request to the store route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->postJson("/api/$user2ID/store",[
                // Enter an integer in the group field
                "group" => 5,
                "points" => 500,
            ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "group" => "Group must be a string value",
            ]);
    });

    /**
     * Test the correct error message is returned
     * when the group field exceeds 55 characters
     */
    it("tests the correct error message is returned when the group field exceeds 55 characters", function(){
        // Use faker
        $faker = Faker\Factory::create();

        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable using the second user's id
        $user2ID = $this->user2->id;

        // Make a post request to the store route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->postJson("/api/$user2ID/store",[
                // Enter a string longer than 55 characters as the group
                "group" => $faker->realTextBetween(56, 60),
                "points" => 500,
            ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "group" => "Group can not exceed 55 characters",
            ]);
    });
})->group("FriendStoreGroupErrorsTests");

/**
 * Tests that check the correct error message is
 * returned when the validation rules for the points
 * field are broken when creating a friend
 */
describe("tests that check the correct error message is returned when the validation rules for the points field are broken when creating a friend", function(){
    // Before each test
    beforeEach(function(){
        // Create a user using the user factory
        $this->user = User::factory()->create([
            "password" => "password",
        ]);

        // Create a second user to be added as a friend
        $this->user2 = User::factory()->createOne();
    });

    // After each test
    afterEach(function(){
        log::info("Test in the FriendStorePointsErrorsTests group complete");
    });

    /**
     * Test the correct error message is returned
     * when the points field is left empty
     */
    it("tests the correct error message is returned when the points field is left empty", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable using the second users id
        $user2ID = $this->user2->id;

        // Make a post request to the store route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->postJson("/api/$user2ID/store",[
                "group" => "Group1",
                // Leave the points field empty
                "points" => "",
            ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "points" => "Points is a required field",
            ]);
    });

    /**
     * Test the correct error message is returned
     * when the points field is not an integer
     */
    it("tests that the correct error message is returned when the points field is not an integer", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable equal to the second users id
        $user2ID = $this->user2->id;

        // Make a post request to the store route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->postJson("/api/$user2ID/store",[
                "group" => "Group 2",
                // Enter a string in the points field
                "points" => "string",
            ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "points" => "Points must be an integer value",
            ]);
    });
})->group("FriendStorePointsErrorsTests");

/**
 * Tests that check the correct error message is
 * returned when the validation rules for the group
 * field are broken when updating a friend
 */
describe("tests that check the correct error message is returned when the validation rules for the group field are broken when updating a friend", function(){
    // Before each test
    beforeEach(function(){
        // Create a user with the user factory
        $this->user = User::factory()->create([
            "password" => "password",
        ]);

        // Create a friend belonging to the user
        $this->friend = createFriend($this->user);
    });

    // After each test
    afterEach(function(){
        log::info("Test in FriendUpdateGroupErrorsTests complete");
    });

    /**
     * Test the correct error message is returned
     * when the group field is left empty
     */
    it("tests the correct error message is returned when the group field is left empty", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable and set it to the friends id
        $friendID = $this->friend->id;

        // Make a put request to the update route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->putJson("/api/$friendID/update",[
                // Leave the group field blank
                "group" => "",
            ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "group" => "Group is a required field",
            ]);
    });

    /**
     * Test the correct error message is returned
     * when the group field is not a string value
     */
    it("tests the correct error message is returned when the group field is not a string value", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable and set it to the friend's id
        $friendID = $this->friend->id;

        // Make a put request to the update route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->putJson("/api/$friendID/update",[
                // Enter an integer in the group field
                "group" => 2,
            ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "group" => "Group must be a string value",
            ]);
    });

    /**
     * Test the correct error message is returned
     * when the group field is longer than 55 characters
     */
    it("tests the correct error message is returned when the group field is longer than 55 characters long", function(){
        // Use faker
        $faker = Faker\Factory::create();

        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable and set it to the friend's id
        $friendID = $this->friend->id;

        // Make a put request to the update route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->putJson("/api/$friendID/update",[
                // Make the group field larger than 55 characters
                "group" => $faker->realTextBetween(56, 60),
            ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "group" => "Group can not exceed 55 characters",
            ]);
    });
})->group("FriendUpdateGroupErrorsTests");

/**
 * Tests that check the correct error message is
 * returned when the validation rules for the points
 * field are broken when increasing a friends points
 */
describe("tests that check the correct error message is returned when the validation rules for the points field are broken when increasing a friends points", function(){
    // Before each test
    beforeEach(function(){
        // Create a user using the user factory
        $this->user = User::factory()->create([
            "password" => "password",
        ]);

        // Create a friend for the user
        $this->friend = createFriend($this->user);
    });

    // After each test
    afterEach(function(){
        log::info("Test in the FriendAddPointsErrorsTests group complete");
    });

    /**
     * Test the correct error message is returned
     * when the points field is left empty
     */
    it("tests the correct error message is returned when the points field is left empty", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable and set it equal to the friend's id
        $friendID = $this->friend->id;

        // Make a put request to the addPoints route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->putJson("/api/$friendID/addPoints",[
                // Leave the points field empty
                "points" => "",
            ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "points" => "Points is a required field",
            ]);
    });

    /**
     * Test the correct error message is returned
     * when the points field in not an integer
     */
    it("tests the correct error message is returned when the points field is not an integer", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable and set it equal to the friends id
        $friendID = $this->friend->id;

        // Make a put request to the addPoints route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->putJson("/api/$friendID/addPoints",[
                // Enter a string in the points field
                "points" => "points",
            ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "points" => "Points must be an integer value",
            ]);
    });
})->group("FriendAddPointsErrorsTests");

/**
 * Tests that check the correct error message is
 * returned when the validation rules for the points
 * field are broken when decreasing a friends points
 */
describe("tests that check the correct error message is returned when the validation rules for the points field are broken when decreasing a friends points", function(){
    // Before each test
    beforeEach(function(){
        // Create a user using the user factory
        $this->user = User::factory()->create([
            "password" => "password",
        ]);

        // Create a friend for the user
        $this->friend = createFriend($this->user);
    });

    // After each test
    afterEach(function(){
        log::info("Test in the FriendRemovePointsErrorsTests group complete");
    });

    /**
     * Test the correct error message is returned
     * when the points field is left empty
     */
    it("tests the correct error message is returned when the points field is left empty", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable and set it equal to the friend's id
        $friendID = $this->friend->id;

        // Make a put request to the removePoints route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->putJson("/api/$friendID/removePoints",[
                // Leave the points field empty
                "points" => "",
            ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "points" => "Points is a required field",
            ]);
    });

    /**
     * Test the correct error message is returned
     * when the points field in not an integer
     */
    it("tests the correct error message is returned when the points field is not an integer", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable and set it equal to the friend's id
        $friendID = $this->friend->id;

        // Make a put request to the removePoints route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->putJson("/api/$friendID/removePoints",[
                // Enter a string as the points field
                "points" => "string",
            ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "points" => "Points must be an integer value",
            ]);
    });
})->group("FriendRemovePointsErrorsTests");
