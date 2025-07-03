<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

uses(RefreshDatabase::class);

/**
 * Tests to check the index method in the
 * HistoryController works as intented
 */
describe("Tests to check the index method in the HistoryController works as intented", function(){
    // Before each test
    beforeEach(function(){
        // Create a user using the user factory
        $this->user = User::factory()->createOne();
        $this->friend = createFriend($this->user);
        $this->history = createHistory($this->friend);
    });

    // After each test
    afterEach(function(){
        log::info("Test in the HistoryIndexTests group complete.");
    });

    /**
     * Test the index method works when there
     * is a user logged in
     */
    it("tests the index method works when there is a user logged in", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Make a get request to the history index route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->getJson("/api/history/records");

        // Declare what the response should be
        $response->assertStatus(200)
            ->assertJsonStructure([
                "records",
            ]);
    });

    /**
     * Test the index method doesn't work when
     * there is no user logged in
     */
    it("tests the index method doesn't work when there is no user logged in", function(){
        // Make a get request to the history index route
        $response = $this->getJson("/api/history/records");

        // Declare what the response should be
        $response->assertStatus(401)
            ->assertJson([
                "error" => "Unauthorised"
            ]);
    });
})->group("HistoryIndexTests");

/**
 * Tests to check the friendIndex method in the
 * HistoryController works as intented
 */
describe("Tests to check the friendIndex method in the HistoryController works as intented", function(){
    // Before each test
    beforeEach(function(){
        // Create a user using the user factory
        $this->user = User::factory()->createOne();

        // Create a friend for the user
        $this->friend = createFriend($this->user);

        // Create a history record for the friend
        $this->history = createHistory($this->friend);
    });

    // After each test
    afterEach(function(){
        log::info("Test in the HistoryFriendIndexTests group completed");
    });

    /**
     * Test the friendIndex method works when there
     * is a user logged in and the friend exists
     */
    it("tests the friendIndex method works when there is a user logged in and the friend exists", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Set the friend's ID to a variable
        $friendID = $this->friend->id;

        // Make a get request to the friendIndex route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->getJson("/api/history/$friendID/FriendIndex");

        // Declare what the response should be
        $response->assertStatus(200)
            ->assertJsonStructure([
                "records",
            ]);
    });

    /**
     * Test the friendIndex method doesn't work when there
     * is no user logged in and the friend exists
     */
    it("tests the friendIndex method doesn't work when there is no user logged in and the friend exists", function(){
        // Set a variable for the friend's id
        $friendID = $this->friend->id;

        // Make a get request to the friendIndex route
        $response = $this->getJson("/api/history/$friendID/FriendIndex");

        // Declare what the response should be
        $response->assertStatus(401)
            ->assertJson([
                "error" => "Unauthorised",
            ]);
    });
})->group("HistoryFriendIndexTests");

/**
 * Tests to check the store method in the
 * HistoryController works as intented
 */
describe("Tests to check the store method in the HistoryController works as intented", function(){
    // Before each test
    beforeEach(function(){
        // Create a user using the user factory
        $this->user = User::factory()->createOne();

        // Create a friend using the createFriend method
        $this->friend = createFriend($this->user);
    });

    // After each test
    afterEach(function(){
        log::info("Test in the HistoryStoreTests group complete");
    });

    /**
     * Test the store method works when valid data
     * is used, there is a user logged in and the
     * friend the history record is for belongs
     * to the logged in user
     */
    it("tests the store method works when valid data is used, there is a user logged in and the friend the record belongs to belongs to the logged in user", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable and set it to the friends id
        $friendID = $this->friend->id;

        // Make a post request to the store history route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->postJson("/api/history/$friendID/store",[
                "id" => $friendID,
                "title" => "Test",
                "reason" => "Test",
                "before" => 20,
                "after" => 30,
                "change" => 10,
            ]);

        // Declare what the response should be
        $response->assertStatus(201)
            ->assertJson([
                "success" => "Historical record successfully created",
            ]);
    });

    /**
     * Test the store method doesn't work when invalid
     * data is used, there is a user logged in and the
     * friend the history record is for belongs
     * to the logged in user
     */
    it("tests the store method doesn't work when invalid data is used, there is a logged in user and the friend the history record is for belongs to the logged in user", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable and set it to the friends id
        $friendID = $this->friend->id;

        // Make a post request to the store history route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->postJson("/api/history/$friendID/store",[
                "id" => $friendID,
                // Leave the title field null
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
     * Test the store method doesn't work when valid data
     * is used and there is no user logged in
     */
    it("tests the store method doesn't work when valid data is used and there is no user logged in", function(){
        // Create a variable and set it to the friend's id
        $friendID = $this->friend->id;

        // Make a post request to the store route
        $response = $this->postJson("/api/history/$friendID/store",[
            "id" => $friendID,
            "title" => "Test",
            "reason" => "Test",
            "before" => 20,
            "after" => 30,
            "change" => 10,
        ]);

        // Declare what the response should be
        $response->assertStatus(401)
            ->assertJson([
                "error" => "Unauthorised",
            ]);
    });

    /**
     * Test the store method doesn't work when valid data
     * is used and there is a logged in user but the history
     * record is for a friend that doesn't exist
     */
    it("tests the store method doesn't work when valid data is used and there is a logged in user but the history record is for a friend that doesn't exist", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable and set it to a number that is not the friend's id
        $friendID = 500;

        // Make a post request to the store route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->postJson("/api/history/$friendID/store",[
                "id" => $friendID,
                "title" => "Test",
                "reason" => "Test",
                "before" => 20,
                "after" => 30,
                "change" => 10,
            ]);

        // Declare what the response should be
        $response->assertStatus(404)
            ->assertJson([
                "error" => "Friend not found",
            ]);
    });

    /**
     * Test the store method doesn't work when valid data
     * is used and there is a logged in user but the friend the
     * history record is for doesn't belong to them
     */
    it("tests the store method doesn't work when valid data is used and there is a user logged in but the friend that the history record is for doesn't belong to the logged in user", function(){
        // Create a second user using the user factory
        $user2 = User::factory()->createOne();

        // Create a token for the second user
        $token = JWTAuth::fromUser($user2);

        // Create a variable and set it to the friend's id
        $friendID = $this->friend->id;

        // Make a post request to the store route
        $response = $this->withHeader("Authorization", "Bearer $token")
            ->postJson("/api/history/$friendID/store",[
                "id" => $friendID,
                "title" => "Test",
                "reason" => "Test",
                "before" => 20,
                "after" => 30,
                "change" => 10,
            ]);

        // Declare what the response should be
        $response->assertStatus(401)
            ->assertJson([
                "error" => "You are not authorised to perform this action",
            ]);
    });
})->group("HistoryStoreTests");

/**
 * Tests to check the show method in the
 * HistoryController works as intented
 */
describe("Tests to check the show method in the HistoryController works as intented", function(){
    // Before each test
    beforeEach(function(){
        // Create a user using the user factory
        $this->user = User::factory()->createOne();

        // Create a friend for the user
        $this->friend = createFriend($this->user);

        // Create a historical record for the user
        $this->history = createHistory($this->friend);
    });

    // After each test
    afterEach(function(){
        log::info("Test in the HistoryShowTests group complete");
    });

    /**
     * Test the show method works when there is
     * a user logged in and the record being shown
     * exists
     */
    it("tests that the show method works when there is a user logged in and the record being shown exists", function(){
        // Create a token for the user
        $token = JWTAuth::fromUser($this->user);

        // Create a variable and set it to the historical records id
        $historyID = $this->history->id;

        // Make a get request to the history show route
        $response  = $this->withHeader("Authorization", "Bearer $token")
            ->getJson("/api/history/$historyID/show");

        // Declare what the response should be
        $response->assertStatus(200)
            ->assertJsonStructure([
                "history",
            ]);
    });

    /**
     * Test the show method doesn't work when there is
     * no user logged in
     */
    it("tests the show method doesn't work when there is no user logged in", function(){
        // Create a variable and set it to the historical records id
        $historyID = $this->history->id;

        // Make a get request to the history show route
        $response  = $this->getJson("/api/history/$historyID/show");

        // Declare what the response should be
        $response->assertStatus(401)
            ->assertJson([
                "error" => "Unauthorised",
            ]);
    });
})->group("HistoryShowTests");

/**
 * Tests to check the update method in the
 * HistoryController works as intented
 */
describe("Tests to check the update method in the HistoryController works as intented", function(){
    // Before each test
    beforeEach(function(){

    });

    // After each test
    afterEach(function(){

    });

    /**
     * Test the update method works when valid data
     * is used, the is a user logged in, the friend
     * that the history record is for belongs to the
     * logged in user and the record being updated exists
     */
    it("tests the update method works when valid data is used, there is a user logged in, the friend that the history record is for belongs to the current user and the record being updated exists", function(){

    });

    /**
     * Test the update method doesn't work when
     * invalid data is used, there is a user logged
     * in, the friend the history record is for belongs
     * to the logged in user and the record being updated
     * exists
     */
    it("tests the update method doesn't work when invalid data is used, there is a user logged in, the friend the history record is for belongs to the current user and the record being updated exists", function(){

    });

    /**
     * Test the update method doesn't work when
     * valid data is used, there is a user logged
     * in, the friend the history record is for doesn't
     * belong to the logged in user and the record being
     * updated exists
     */
    it("tests the update method doesn't work when valid data is used, there is a user logged in, the friend the history record is for doesn't belong to the logged in user and the record being updated exists", function(){

    });

    /**
     * Test the update method doesn't work when
     * valid data is used, there is a user logged
     * in, the friend the history record is for belongs
     * to the logged in user and the record being
     * updated doesn't exist
     */
    it("tests the update method doesn't work when valid data is used, there is a user logged in, the friend the history record is for belongs to the logged in user and the record being updated doesn't exist", function(){

    });

    /**
     * Test the update method doesn't work when
     * valid data is used and there is no user
     * logged in
     */
    it("tests the update method doesn't work when valid data is used and there is no user logged in", function(){

    });
})->group("HistoryUpdateTests");

/**
 * Tests to check the delete method in the
 * HistoryController works as intented
 */
describe("Tests to check that the delete method in the HistoryController works as intented", function(){
    // Before each test
    beforeEach(function(){

    });

    // After each test
    afterEach(function(){

    });

    /**
     * Test the delete method works when there is a
     * user logged in, the friend the history record is
     * for belongs to the logged in user and the record
     * being deleted exists
     */
    it("tests the delete method works when there is a user logged in, the friend the history record is for belongs to the logged in user and the record being deleted exists", function(){

    });

    /**
     * Test the delete method doesn't work when there
     * is a user logged in, the friend the history record
     * is for belongs to the logged in user and the record
     * being deleted does not exist
     */
    it("tests the delete method doesn't work when there is a user logged in, the friend the history record is for belongs to the logged in user and the record being deleted doesn't exist", function(){

    });

    /**
     * Test the delete method doesn't work when there
     * is a user logged in, the friend the history record
     * is for doesn't belong to the logged in user and
     * the record being deleted exists
     */
    it("tests the delete method doesn't work when there is a user logged in, the friend the history record is for doesn't belong to the logged in user and the record being deleted exists", function(){

    });

    /**
     * Test the delete method doesn't work when there
     * is no user logged in
     */
    it("tests the delete method doesn't work when there is no user logged in", function(){

    });
})->group("HistoryDeleteTests");
