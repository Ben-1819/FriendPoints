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

    });

    /**
     * Test that the correct error message is returned
     * when the first_name field is left empty
     */
    it("tests that the correct error message is returned when the first_name field is left empty", function(){

    });

    /**
     * Test that the correct error message is returned
     * when the first_name field is not a string
     */
    it("tests that the correct error message is returned when the first_name field is not a string", function(){

    });

    /**
     * Test that the correct error message is returned
     * when the first_name field is longer than 55 characters
     */
    it("tests that the correct error message is returned when the first_name field is longer than 55 characters", function(){

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
