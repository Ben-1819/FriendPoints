<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

uses(RefreshDatabase::class);

/**
 * Tests to check the index method in the
 * HistoryController works as intented
 */
describe("Tests to check the index method in the HistoryController works as intented", function(){
    // Before each test
    beforeEach(function(){

    });

    // After each test
    afterEach(function(){

    });

    /**
     * Test the index method works when there
     * is a user logged in
     */
    it("tests the index method works when there is a user logged in", function(){

    });

    /**
     * Test the index method doesn't work when
     * there is no user logged in
     */
    it("tests the index method doesn't work when there is no user logged in", function(){

    });
})->group("HistoryIndexTests");

/**
 * Tests to check the byFriend method in the
 * HistoryController works as intented
 */
describe("Tests to check the byFriend method in the HistoryController works as intented", function(){
    // Before each test
    beforeEach(function(){

    });

    // After each test
    afterEach(function(){

    });

    /**
     * Test the byFriend method works when there
     * is a user logged in and the friend exists
     */
    it("tests the byFriend method works when there is a user logged in and the friend exists", function(){

    });

    /**
     * Test the byFriend method doesn't work when there
     * is no user logged in and the friend exists
     */
    it("tests the byFriend method doesn't work when there is no user logged in and the friend exists", function(){

    });

    /**
     * Test the byFriend method doesn't work when there
     * is a user logged in and the friend doesn't exist
     */
    it("tests the byFriend method doesn't work when there is a user logged in and the friend doesn't exist", function(){

    });
})->group("HistoryByFriendTests");

/**
 * Tests to check the store method in the
 * HistoryController works as intented
 */
describe("Tests to check the show method in the HistoryController works as intented", function(){
    // Before each test
    beforeEach(function(){

    });

    // After each test
    afterEach(function(){

    });

    /**
     * Test the store method works when valid data
     * is used, there is a user logged in and the
     * friend the history record is for belongs
     * to the logged in user
     */
    it("tests the store method works when valid data is used, there is a user logged in and the friend the record belongs to belongs to the logged in user", function(){

    });

    /**
     * Test the store method doesn't work when invalid
     * data is used, there is a user logged in and the
     * friend the history record is for belongs
     * to the logged in user
     */
    it("tests the store method doesn't work when invalid data is used, there is a logged in user and the friend the history record is for belongs to the logged in user", function(){

    });

    /**
     * Test the store method doesn't work when valid data
     * is used and there is no user logged in
     */
    it("tests the store method doesn't work when valid data is used and there is no user logged in", function(){

    });

    /**
     * Test the store method doesn't work when valid data
     * is used and there is a logged in user but the history
     * record is for a friend that doesn't exist
     */
    it("tests the store method doesn't work when valid data is used and there is a logged in user but the history record is for a friend that doesn't exist", function(){

    });

    /**
     * Test the store method doesn't work when valid data
     * is used and there is a logged in user but the friend the
     * history record is for doesn't belong to them
     */
    it("tests the store method doesn't work when valid data is used and there is a user logged in but the friend that the history record is for doesn't belong to the logged in user", function(){

    });
})->group("HistoryStoreTests");

/**
 * Tests to check the show method in the
 * HistoryController works as intented
 */
describe("Tests to check the show method in the HistoryController works as intented", function(){
    // Before each test
    beforeEach(function(){

    });

    // After each test
    afterEach(function(){

    });

    /**
     * Test the show method works when there is
     * a user logged in and the record being shown
     * exists
     */
    it("tests that the show method works when there is a user logged in and the record being shown exists", function(){

    });

    /**
     * Test the show method doesn't work when there is
     * a user logged in and record being shown doesn't exist
     */
    it("tests the show method doesn't work when there is a user logged in and the record being shown doesn't exist", function(){

    });

    /**
     * Test the show method doesn't work when there is
     * no user logged in
     */
    it("tests the show method doesn't work when there is no user logged in", function(){

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
