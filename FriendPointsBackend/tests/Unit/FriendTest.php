<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

uses(RefreshDatabase::class);

/**
 * Tests that check the index method in the
 * FriendController works as intented
 */
describe("Tests to check that the index method in the FriendController works as intented", function(){
    // Before each test
    beforeEach(function(){
        // Create a user using the user factory
        $this->user = User::factory()->createOne();
    });

    // After each test
    afterEach(function(){
        log::info("Test in the friendIndexTests group complete");
    });

    /**
     * Test that the index method works when
     * there is a logged in user
     */
    it("tests the index method works when there is a logged in user", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a friend for the user
        $friend = createFriend($this->user);

        // Make a get request to the index route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->getJson("/api/index");

        // Declare what the response should be
        $response->assertStatus(200)
            ->assertJsonStructure([
                "friends",
            ]);
    });

    /**
     * Test that the index method doesn't work
     * when there is no logged in user
     */
    it("tests the index method doesn't work when there is no user logged in", function(){
        // Create a friend for the user
        $friend = createFriend($this->user);

        // Make a get request to the friend index route
        $response = $this->getJson("/api/index");

        // Declare what the response should be
        $response->assertStatus(401)
            ->assertJson([
                "error" => "Unauthorised"
            ]);
    });
})->group("FriendIndexTests");

/**
 * Test that check the group1Index method
 * in FriendController works as intented
 */
describe("Tests to check that the group1Index method in FriendController works as intented", function(){
    // Before each test
    beforeEach(function(){
        // Create a user
        $this->user = User::factory()->create([
            "password" => "password",
        ]);

        // Create a friend for the user
        $this->friend = createFriend($this->user);
    });

    // After each test
    afterEach(function(){
        log::info("Test in the FriendGroup1Index group complete");
    });

    /**
     * Test that the group1Index method works
     * when there is a logged in user
     */
    it("tests the group1Index method works when there is a logged in user", function(){
        // Create a token for the user
        $token  = JWTAuth::fromUser($this->user);

        // Make a get request to the group1Index route
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson("/api/group1/index");

        // Declare what the response should be
        $response->assertStatus(200)
            ->assertJsonStructure([
                "friends",
            ]);
    });

    /**
     * Test that the group1Index method doesn't work
     * when there is no logged in user
     */
    it("tests the group1Index method doesn't work when there is no logged in user", function(){
        // Make a get request to the group1Index route
        $response = $this->getJson("/api/group1/index");

        // Declare what the response should be
        $response->assertStatus(401)
            ->assertJson([
                "error" => "Unauthorised",
            ]);
    });
})->group("FriendGroup1IndexTests");


/**
 * Test that check the group2Index method
 * in FriendController works as intented
 */
describe("Tests to check that the group2Index method in FriendController works as intented", function(){
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
        log::info("Test in the FriendGroup2IndexTests complete");
    });

    /**
     * Test that the group2Index method works
     * when there is a logged in user and the
     * group being searched for exists
     */
    it("tests the group2Index method works when there is a logged in user and the group being searched for exists", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Make a get request to the group2Index route
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson("/api/group2/index");

        // Declare what the response should be
        $response->assertStatus(200)
            ->assertJsonStructure([
                "friends",
            ]);
    });

    /**
     * Test that the group2Index method doesn't work
     * when there is no logged in user
     */
    it("tests the group2Index method doesn't work when there is no logged in user", function(){
        // Make a get request to the group2Index route
        $response = $this->getJson("/api/group2/index");

        // Declare what the response should be
        $response->assertStatus(401)
            ->assertJson([
                "error" => "Unauthorised",
            ]);
    });
})->group("FriendGroup2IndexTests");

/**
 * Tests that check the store method
 * in the FriendController
 * works as intented
 */
describe("Tests that check the store method in the FriendController works as intented", function(){
    // Before each test
    beforeEach(function(){
        // Create a user using the user factory
        $this->user = User::factory()->create([
            "password" => "password",
        ]);
        // Create a second user to be made a friend
        $this->user2 = User::factory()->createOne();
    });

    // After each test
    afterEach(function(){
        log::info("Test in the FriendStoreTests group complete");
    });

    /**
     * Test the store method works when valid
     * data is entered and there is a user logged in
     */
    it("tests the store method works when valid data is used and there is a user logged in", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);
        $id = $this->user2->id;
        // Make a post request to the store route
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson("/api/$id/store",[
                "group" => "Both",
                "points" => 500,
            ]);

        // Declare what the response should be
        $response->assertStatus(201)
            ->assertJson([
                "success" => "New friend successfully added"
            ]);
    });

    /**
     * Test the store method doesn't work when
     * invalid data is entered and there is a
     * user logged in
     */
    it("tests the store method doesn't work when invalid data is entered and there is a user logged in", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        $id = $this->user2->id;
        // make a post request to the store route
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson("/api/$id/store",[
                // Leave the group field empty
                "group" => "",
                "points" => 500
            ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "group" => "Group is a required field",
            ]);
    });

    /**
     * Test the store method doesn't work when
     * valid data is entered and there is no
     * user logged in
     */
    it("tests the store method doesn't work when valid data is entered and there is no user logged in", function(){
        $id = $this->user2->id;
        // Make a post request to the store route
        $response = $this->postJson("/api/$id/store",[
            "group" => "Both",
            "points" => 500,
        ]);

        // Declare what the response should be
        $response->assertStatus(401)
            ->assertJson([
                "error" => "Unauthorised",
            ]);
    });
})->group("FriendStoreTests");

/**
 * Tests that check the show method in the
 * FriendController works as intented
 */
describe("Tests that the check the show method in the FriendController works as intented", function(){
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
        log::info("Test in the FriendShowTests group complete");
    });

    /**
     * Test the show method works there is a user logged in
     */
    it("tests that the show method works when the friend being shown exists and there is a user logged in", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Make a get request to the show options route
        $response  = $this->withHeader("Authorization", "Bearer $token")
            ->getJson("/api/showOptions");

        // Declare what the response should be
        $response->assertStatus(200)
            ->assertJsonStructure([
                "options",
            ]);
    });

    /**
     * Test the show method doesn't work when
     * there is no user logged in
     */
    it("tests that the show method doesn't work when there is no user logged in", function(){
        // Make a get request to the showOptionsRoute
        $response = $this->getJson("/api/showOptions");

        // Declare what the response should be
        $response->assertStatus(401)
            ->assertJson([
                "error" => "Unauthorised",
            ]);
    });
})->group("FriendShowTests");

/**
 * Tests that check the update method in the
 * FriendController works as intented
 */
describe("Tests that check the update method in the FriendController works as intented", function(){
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
        log::info("Test in FriendUpdateTests group complete");
    });

    /**
     * Test the update method works when valid data is
     * entered and the friend both exists and belongs to
     * the current user
     */
    it("tests the update method works when valid data is used and the friend exists and belongs to the current user", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable for the friend id
        $friendID = $this->friend->id;
        // Make a put request to the update route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->putJson("/api/$friendID/update",[
                "group" => "Group 1",
            ]);

        // Declare what the response should be
        $response->assertStatus(200)
            ->assertJsonStructure([
                "success",
            ]);
    });

    /**
     * Test the addPoints method works when increasing a friends
     * points when valid data is entered and the friend both
     * exists and belongs to the current user
     */
    it("tests the addPoints method works when increasing a friends points when valid data is entered and the friend exists and belongs to the current user", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Set the friends id to a variable
        $friendID = $this->friend->id;

        // Make a put request to the add points route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->putJson("/api/$friendID/addPoints",[
                "points" => 500,
            ]);

        // Declare what the response should be
        $response->assertStatus(200)
            ->assertJsonStructure([
                "success",
                "id",
                "before",
                "after",
                "change",
            ]);
    });

    /**
     * Test the addPoints method doesn't work when invalid data
     * is entered the the friend being updated belongs to the
     * current user
     */
    it("tests the addPoints method doesn't work when invalid data is entered and the friend being updated belongs to the current user", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Set the friends id to a variable
        $friendID = $this->friend->id;

        // Make a put request to the addPoints route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->putJson("/api/$friendID/addPoints",[
                // Send the points as a string
                "points" => "string",
            ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "points" => "Points must be an integer value",
            ]);
    });

    /**
     * Test the addPoints method doesn't work when valid data is
     * entered but the friend being updated doesn't belong to the
     * user
     */
    it("tests the addPoints method doesn't work when valid data is entered but the friend being updated doesn't belong to the user", function(){
        // Create a second user
        $user = User::factory()->createOne();

        // Create a token for the second user
        $token = JWTAuth::fromUser($user);

        // Create a variable for the friends id
        $friendID = $this->friend->id;

        // Make a put request to the addPoints route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->putJson("/api/$friendID/addPoints",[
                "points" => "500",
            ]);

        // Declare what the response should be
        $response->assertStatus(401)
            ->assertJson([
                "error" => "You are not authorised to perform this action",
            ]);
    });

    /**
     * Test the addPoints method doesn't work when valid data is
     * entered and the friend being updated doesn't exist
     */
    it("tests the addPoints method works when valid data is entered and the friend being updated doesn't exist", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable that is one greater than the friends id
        $friendID = $this->friend->id + 1;

        // Make a put request to the addPoints route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->putJson("/api/$friendID/addPoints",[
                "points" => 500,
            ]);

        // Declare what the response should be
        $response->assertStatus(404);
    });

    /**
     * Test the addPoints method doesn't work when there is no user
     * logged in
     */
    it("tests the addPoints method doesn't work when there is no user logged in", function(){
        // Set the friends id to a variable
        $friendID = $this->friend->id;

        // Make a put request to the addPoints route
        $response = $this->putJson("/api/$friendID/addPoints",[
            "points" => 500,
        ]);

        // Declare what the response should be
        $response->assertStatus(401)
            ->assertJson([
                "error" => "Unauthorised",
            ]);
    });

    /**
     * Test the removePoints method works when valid data is
     * entered and the friend both exists and belongs to the
     * current user
     */
    it("tests the removePoints method works when decreasing a friends points when valid data is used and the friend exists and belongs to the user", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Set the friends id to a variable
        $friendID = $this->friend->id;

        // Make a put request to the remove points route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->putJson("/api/$friendID/removePoints",[
                "points" => 10,
            ]);

        // Declare what the response should be
        $response->assertStatus(200)
            ->assertJsonStructure([
                "success",
                "id",
                "before",
                "after",
                "change",
            ]);
    });

    /**
     * Test the removePoints method doesn't work when invalid
     * data is entered and the friend belongs to the current user
     */
    it("tests the removePoints method doesn't work when invalid data is entered and the friend belongs to the current user", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Set the friends id to a variable
        $friendID = $this->friend->id;

        // Make a put request to the removePoints route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->putJson("/api/$friendID/removePoints",[
                // Enter a string with as points
                "points" => "string",
            ]);

        // Declare what the response should be
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                "points" => "Points must be an integer value",
            ]);
    });

    /**
     * Test the removePoints method doesn't work when valid data is
     * entered and the friend doesn't belong to the current user
     */
    it("tests the removePoints method doesn't work when valid data is entered and the friend doesn't belong to the current user", function(){
        // Make a second user using the user factory
        $user = User::factory()->createOne();

        // Create a token for the user
        $token = JWTAuth::fromUser($user);

        // Set the friends id to a variable
        $friendID = $this->friend->id;

        // Make a put request to the removePoints route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->putJson("/api/$friendID/removePoints",[
                "points" => 10,
            ]);

        // Declare what the response should be
        $response->assertStatus(401)
            ->assertJson([
                "error" => "You are not authorised to perform this action",
            ]);
    });

    /**
     * Test the removePoints method doesn't work when valid data is
     * entered and the friend being updated doesn't exist
     */
    it("tests the removePoints method doesn't work when valid data is entered and the friend being updated doesn't exist", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable that is one greater than the friends id
        $friendID = $this->friend->id + 1;

        // Make a put request to the removePoints route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->putJson("/api/$friendID/removePoints",[
                "points" => 10,
            ]);

        // Declare what the response should be
        $response->assertStatus(404);
    });

    /**
     * Test the removePoints method doesn't work when there is no
     * user logged in
     */
    it("tests the removePoints method doesn't work when there is no user logged in", function(){
        // Set the friends id to a variable
        $friendID = $this->friend->id;

        // Make a put request to the removePoints route
        $response = $this->putJson("/api/$friendID/removePoints",[
            "points" => 10,
        ]);

        // Declare what the response should be
        $response->assertStatus(401)
            ->assertJson([
                "error" => "Unauthorised",
            ]);
    });
})->group("FriendUpdateTests");

/**
 * Tests that check the delete method in the
 * FriendController works as intented
 */
describe("Tests that check the delete method in the FriendController works as intented", function(){
    // Before each test
    beforeEach(function(){

    });

    // After each test
    afterEach(function(){

    });

    /**
     * Test the delete method works when the
     * friend being deleted exists and belongs
     * to the current user
     */

    it("tests the delete method works when the friend being deleted exists and belongs to the current user", function(){

    });

    /**
     * Test the delete method doesn't work when
     * the friend being deleted exists but doesn't
     * belong to the current user
     */
    it("tests the delete method doesn't work when the friend being deleted exists but doesn't belong to the current user", function(){

    });

    /**
     * Test the delete method doesn't work when
     * the friend being deleted doesn't exist
     */
    it("tests the delete method doesn't work when the friend being deleted doesn't exist", function(){

    });

    /**
     * Test the delete method doesn't work when
     * there is no user logged in
     */
    it("tests the delete method doesn't work when there is no user logged in", function(){

    });
})->group("FriendDeleteTests");
