<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

uses(RefreshDatabase::class);

/**
 * Tests that check the correct error message is
 * returned when the validation rules for the group
 * field are broken when creating a friend
 */
describe("tests that check the correct error message is returned when the validation rules for the group field are broken when creating a friend", function(){
    // Before each test
    beforeEach(function(){

    });

    // After each test
    afterEach(function(){

    });

    /**
     * Test the correct error message is returned
     * when the group field is left empty
     */
    it("tests the correct error message is returned when the group field is left empty", function(){

    });

    /**
     * Test the correct error message is returned
     * when the group field is not a string value
     */
    it("tests the correct error message is returned when the data entered in the group field is not a string value", function(){

    });

    /**
     * Test the correct error message is returned
     * when the group field exceeds 55 characters
     */
    it("tests the correct error message is returned when the group field exceeds 55 characters", function(){

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

    });

    // After each test
    afterEach(function(){

    });

    /**
     * Test the correct error message is returned
     * when the points field is left empty
     */
    it("tests the correct error message is returned when the points field is left empty", function(){

    });

    /**
     * Test the correct error message is returned
     * when the points field is not an integer
     */
    it("tests that the correct error message is returned when the points field is not an integer", function(){

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

    });

    // After each test
    afterEach(function(){

    });

    /**
     * Test the correct error message is returned
     * when the group field is left empty
     */
    it("tests the correct error message is returned when the group field is left empty", function(){

    });

    /**
     * Test the correct error message is returned
     * when the group field is not a string value
     */
    it("tests the correct error message is returned when the group field is not a string value", function(){

    });

    /**
     * Test the correct error message is returned
     * when the group field is longer than 55 characters
     */
    it("tests the correct error message is returned when the group field is longer than 55 characters long", function(){

    });
})->group("FriendUpdateGroupErrorsTests");

/**
 * Tests that check the correct error message is
 * returned when the validation rules for the points
 * field are broken when updating a friend
 */
describe("tests that check the correct error message is returned when the validation rules for the points field are broken when updating a friend", function(){
    // Before each test
    beforeEach(function(){

    });

    // After each test
    afterEach(function(){

    });

    /**
     * Test the correct error message is returned
     * when the points field is left empty
     */
    it("tests the correct error message is returned when the points field is left empty", function(){

    });

    /**
     * Test the correct error message is returned
     * when the points field in not an integer
     */
    it("tests the correct error message is returned when the points field is not an integer", function(){

    });
})->group("FriendUpdatePointsErrorsTests");
