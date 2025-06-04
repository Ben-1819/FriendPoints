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
 * Test that check the groupIndex method
 * in FriendController works as intented
 */
describe("Tests to check that the groupIndex method in FriendController works as intented", function(){
    // Before each test
    beforeEach(function(){

    });

    // After each test
    afterEach(function(){

    });

    /**
     * Test that the groupIndex method works
     * when there is a logged in user and the
     * group being searched for exists
     */
    it("tests the groupIndex method works when there is a logged in user and the group being searched for exists", function(){

    });

    /**
     * Test that the groupIndex method doesn't work
     * when there is no logged in user and the group
     * being searched for exists
     */
    it("tests the groupIndex method doesn't work when there is no logged in user and the group being searched for exixts", function(){

    });

    /**
     * Test that the groupIndex method doesn't work
     * when there is a logged in user and the group
     * being searched for doesn't exist
     */
    it("tests the groupIndex method doesn't work when there is a logged in user and the group being searched for doesn't exist", function(){

    });
})->group("FriendGroupIndexTests");

/**
 * Tests that check the store method
 * in the FriendController
 * works as intented
 */
describe("Tests that check the store method in the FriendController works as intented", function(){
    // Before each test
    beforeEach(function(){

    });

    // After each test
    afterEach(function(){

    });

    /**
     * Test the store method works when valid
     * data is entered and there is a user logged in
     */
    it("tests the store method works when valid data is used and there is a user logged in", function(){

    });

    /**
     * Test the store method doesn't work when
     * invalid data is entered and there is a
     * user logged in
     */
    it("tests the store method doesn't work when invalid data is entered and there is a user logged in", function(){

    });

    /**
     * Test the store method doesn't work when
     * valid data is entered and there is no
     * user logged in
     */
    it("tests the store method doesn't work when valid data is entered and there is no user logged in", function(){

    });
})->group("FriendStoreTests");

/**
 * Tests that check the show method in the
 * FriendController works as intented
 */
describe("Tests that the check the show method in the FriendController works as intented", function(){
    // Before each test
    beforeEach(function(){

    });

    // After each test
    afterEach(function(){

    });

    /**
     * Test the show method works when the friend
     * being shown exists and there is a user logged in
     */
    it("tests that the show method works when the friend being shown exists and there is a user logged in", function(){

    });

    /**
     * Test the show method doesn't work when the
     * friend being shown does not exist and there
     * is a user logged in
     */
    it("tests that the show method doesn't work when the friend being shown does not exist and there is a user logged in", function(){

    });

    /**
     * Test the show method doesn't work when the
     * friend being shown exists and there is no
     * user logged in
     */
    it("tests that the show method doesn't work when the friend being shown exists and there is no user logged in", function(){

    });

    /**
     * Test the show method doesn't work wen the
     * friend being shown exists but doesn't belong
     * to the currently logged in user
     */
    it("tests that the show method doesn't work when the friend being shown exists but doesn't belong to the currently logged in user", function(){

    });
})->group("FriendShowTests");

/**
 * Tests that check the update method in the
 * FriendController works as intented
 */
describe("Tests that check the update method in the FriendController works as intented", function(){
    // Before each test
    beforeEach(function(){

    });

    // After each test
    afterEach(function(){

    });

    /**
     * Test the update method works when valid data is
     * entered and the friend both exists and belongs to
     * the current user
     */
    it("tests the update method works when valid data is used and the friend exists and belongs to the current user", function(){

    });

    /**
     * Test the update method works when increasing a friends
     * points when valid data is entered and the friend both
     * exists and belongs to the current user
     */
    it("tests the update method works when increasing a friends points when valid data is entered and the friend exists and belongs to the current user", function(){

    });

    /**
     * Test the update method works when decreasing a friends
     * points when valid data is entered and the friend both
     * exists and belongs to the current user
     */
    it("tests the update method works when decreasing a friends points when valid data is used and the friend exists and belongs to the user", function(){

    });

    /**
     * Test the update method doesn't work when invalid
     * data is entered and the friend both exists and belongs
     * to the current user
     */
    it("tests the update method doesn't work when invalid data is used and the friend exists and belongs to the current user", function(){

    });

    /**
     * Test the update method doesn't work when
     * valid data is entered and the friend doesn't
     * exist
     */
    it("tests the update method doesn't work when valid data is used and the friend doesn't exist", function(){

    });

    /**
     * Test the update method doesn't work when
     * valid data is entered and the friend exists
     * but doesn't belong to the current user
     */
    it("tests the update method doesn't work when valid data is entered and the friend exists but doesn't belong to the current user", function(){

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
