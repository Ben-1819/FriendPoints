<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

uses(RefreshDatabase::class);

/**
 * Tests to check the error messages for the
 * email field are correct when validation
 * rules are broken
 */
describe("Tests to check that the error messages for the email field are correct when validation rules are broken", function(){
    // Before each test
    beforeEach(function(){

    });

    // After each test
    afterEach(function(){

    });

    /**
     * Test that the correct error message is returned
     * when the email field is left blank
     */
    it("tests that the correct error message is returned when the email field is left blank", function(){

    });

    /**
     * Test that the correct error message is returned
     * when the email field is not an email value
     */
    it("tests that the correct error message is returned when the email field is not an email value", function(){

    });

    /**
     * Test that the correct error message is returned
     * when the email field is longer than 55 characters
     */
    it("tests that the correct error message is returned when the email field is longer than 55 characters", function(){

    });
})->group("LoginEmailErrors");

/**
 * Tests to check the error messages for the
 * password field are correct when validation
 * rules are broken
 */
describe("Tests to check that the error messages for the password field are correct when validation rules are broken", function(){
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
    it("checks that the correct error message is returned when the password field is left empty", function(){

    });

    /**
     * Test that the correct error message is returned
     * when the password field is not a string value
     */
    it("tests that the correct error message is returned when the password field is not a string value", function(){

    });

    /**
     * Test that the correct error message is returned
     * when the password field is less than 6 characters long
     */
    it("tests that the correct error message is returned when the password field is less than 6 characters long", function(){

    });
})->group("LoginPasswordErrors");
