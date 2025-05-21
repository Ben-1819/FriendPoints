<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

uses(RefreshDatabase::class);

// Tests to check that the register method works as intented
describe("Tests to check that the register method works as intented", function(){
    // Before each test
    beforeEach(function(){

    });

    // After each test
    afterEach(function(){

    });

    /**
     * Test that users can register for an account using
     * valid input data
     */
    it("tests that users can register for an account when using valid input data", function(){

    });

    /**
     * Test that users cannot register for an account when
     * invalid data is entered in the first_name field
     */
    it("tests that users cannot register for an account when invalid data is entered in the first_name field", function(){

    });

    /**
     * Test that users cannot register for an account when
     * invalid data is entered in the last_name field
     */
    it("tests that users cannot register for an account when invalid data is entered in the last_name field", function(){

    });

    /**
     * Test that users cannot register for an account when
     * invalid data is entered in the email field
     */
    it("tests that users can not register when invalid data is entered in the email field", function(){

    });

    /**
     * Test that users cannot register for an account when
     * invalid data is entered in the password field
     */
    it("tests that users can not register for an account when invalid data is entered in the password field", function(){

    });
})->group("RegisterTests");
