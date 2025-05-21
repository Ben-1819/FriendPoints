<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

uses(RefreshDatabase::class);

/**
 * Tests the correct error messages are returned
 * when the validation rules for the title field
 * are broken when storing a record
 */
describe("Tests the correct error messages are returned when the validation rules for the title field are broken when storing a record", function(){
    // Before each test
    beforeEach(function(){

    });

    // After each test
    afterEach(function(){

    });

    /**
     * Test the correct error message is returned
     * when the title field is empty when storing
     * a record
     */
    it("tests the correct error message is returned when the title field is empty when storing a record", function(){

    });

    /**
     * Test the correct error message is returned
     * when the title field is not a string when
     * storing a record
     */
    it("tests the correct error message is returned when the title field is not a string when storing a record", function(){

    });

    /**
     * Tests the corrrect error message is returned
     * when the title field is longer than 55 characters
     * when storing a record
     */
    it("tests the correct error message is returned when the title field is longer than 55 characters when storing a record", function(){

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

    });

    // After each test
    afterEach(function(){

    });

    /**
     * Test the correct error message is returned
     * when the reason field is left empty when
     * storing a record
     */
    it("tests the correct error message is returned when the reason field is left empty when storing a record", function(){

    });

    /**
     * Test the correct error message is returned
     * when the reason field is not a string when
     * storing a record
     */
    it("tests the correct error message is returned when the reason field is not a string when storing a record", function(){

    });

    /**
     * Test the correct error message is returned
     * when the reason field is longer than 255
     * characters when storing a record
     */
    it("tests the correct error message is returned when the reason field is longer than 255 characters when storing a record", function(){

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

    });

    // After each test
    afterEach(function(){

    });

    /**
     * Test the correct error message is returned
     * when the title field is empty when updating
     * a record
     */
    it("tests the correct error message is returned when the title field is left empty when updating a record", function(){

    });

    /**
     * Test the correct error message is returned
     * when the title field is not a string when
     * updating a record
     */
    it("tests the correct error message is returned when the title field is not a string when updating a record", function(){

    });

    /**
     * Test the correct error message is returned
     * when the title field is longer than 55 characters
     * when updating a record
     */
    it("tests the correct error message is returned when the title field is longer than 55 characters when updating a record", function(){

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

    });

    // After each test
    afterEach(function(){

    });

    /**
     * Test the correct error message is returned
     * when the reason field is empty when updating
     * a record
     */
    it("tests the correct error message is returned when the reason field is empty when updating a record", function(){

    });

    /**
     * Test the correct error message is returned
     * when the reason field is not a string when
     * updating a record
     */
    it("tests the correct error message is returned when the reason field is not a string when updating a record", function(){

    });

    /**
     * Test the correct error message is returned
     * when the reason field is longer than 255 characters
     * when updating record
     */
    it("tests the correct error message is returned when the reason field is longer than 255 characters when updating a record", function(){

    });
})->group("HistoryReasonUpdateErrorsTests");
