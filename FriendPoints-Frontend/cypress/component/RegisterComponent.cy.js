import Register from "@/components/Register.vue";

describe("Tests to ensure the first_name error messages are returned when invalid data is entered into the first_name field", () => {
  it("tests the correct error message is returned when the first name field is left blank in the register component", () => {
    cy.mount(Register);

    // Check the error messages do not exist currently
    cy.noErrors();

    // Call the custom register command
    cy.register({
      // Pass null in as the first_name parameter
      first_name: null,
      last_name: "Brown",
      email: "ben@gmail.com",
      password: "password",
    });

    // Check the first name error message was returned
    cy.shouldShowFieldError("firstName", "First name is a required field");

    // Check there are no other error messages
    cy.noLastNameErrors();
    cy.noEmailErrors();
    cy.noPasswordErrors();
  });

  it("tests the correct error message is returned when the data entered in the first name field is not a string", () => {
    // Mount the Register component
    cy.mount(Register);

    // Check there are no error messages
    cy.noErrors();

    // Call the custom register command
    cy.register({
      // Pass in an integer as the first_name parameter
      first_name: 1,
      last_name: "Brown",
      email: "ben@gmail.com",
      password: "password",
    });

    // Check the first name error message was returned
    cy.shouldShowFieldError(
      "firstName",
      "First name must be of data type string"
    );

    // Check there are no other error messages
    cy.noLastNameErrors();
    cy.noEmailErrors();
    cy.noPasswordErrors();
  });

  it("tests the correct error message is returned when a string longer than 55 characters is entered into the first name field", () => {
    // Mount the register component
    cy.mount(Register);

    // Check there are no error messages
    cy.noErrors();

    // Get the first name field and enter a string 56 characters long into it
    cy.get('[data-cy="firstNameInput"]')
      .invoke("val", stringGen(56))
      .type("!")
      .invoke("val")
      .should("have.length", 56);

    // Get the last name field and enter valid data into it
    cy.get('[data-cy="lastNameInput"]').type("Brown");

    // Get the email field and enter valid data into it
    cy.get('[data-cy="emailInput"]').type("ben@gmail.com");

    // Get the password field and enter valid data into it
    cy.get('[data-cy="passwordInput"]').type("password");

    // Click the submit button
    cy.get('[data-cy="register-button"]').click();

    // Check the first name error message was returned
    cy.shouldShowFieldError(
      "firstName",
      "First name can not be longer than 55 characters"
    );

    // Check there are no other error messages
    cy.noLastNameErrors();
    cy.noEmailErrors();
    cy.noPasswordErrors();
  });
});

describe("Tests to ensure the last_name error messages are returned when invalid data is entered into the last_name field", () => {
  it("tests the correct error message is returned when the last_name field is left empty", () => {
    // Mount the register component
    cy.mount(Register);

    // Check there are no error messages
    cy.noErrors();

    // Call the custom register command
    cy.register({
      first_name: "Ben",
      // Leave the last_name field empty
      last_name: "",
      email: "ben@gmail.com",
      password: "password",
    });

    // Check the last name error message was returned
    cy.shouldShowFieldError("lastName", "Last name is a required field");

    // Check there are no other error messages
    cy.noFirstNameErrors();
    cy.noEmailErrors();
    cy.noPasswordErrors();
  });

  it("tests the correct error message is returned when the data entered into the last_name field is not a string value", () => {
    // Mount the register component
    cy.mount(Register);

    // Check there are no error messages
    cy.noErrors();

    // Call the custom register command
    cy.register({
      first_name: "Ben",
      // Enter an integer into the last_name field
      last_name: 1,
      email: "ben@gmail.com",
      password: "password",
    });

    // Check the last name error message was returned
    cy.shouldShowFieldError(
      "lastName",
      "Last name must be of data type string"
    );

    // Check there are no other error messages
    cy.noFirstNameErrors();
    cy.noEmailErrors();
    cy.noPasswordErrors();
  });

  it("tests the correct error message is returned when a string longer than 55 characters is entered into the last_name field", () => {
    // Mount the register component
    cy.mount(Register);

    // Check there are no error messages
    cy.noErrors();

    // Get the first name field and enter valid data into it
    cy.get('[data-cy="firstNameInput"]').type("Ben");

    // Get the last name field and enter a string 56 characters long into it
    cy.get('[data-cy="lastNameInput"]')
      .invoke("val", stringGen(56))
      .type("!")
      .invoke("val")
      .should("have.length", 56);

    // Get the email field and enter valid data into it
    cy.get('[data-cy="emailInput"]').type("ben@gmail.com");

    // Get the password field and enter valid data into it
    cy.get('[data-cy="passwordInput"]').type("password");

    // Check the last name error message was returned
    cy.shouldShowFieldError([
      "lastName",
      "Last name can not be longer than 55 characters",
    ]);

    // Check the other fields have no error messages
    cy.noFirstNameErrors();
    cy.noEmailErrors();
    cy.noPasswordErrors();
  });
});

describe("Tests to ensure the email error messages are returned when invalid data is entered into the email field", () => {
  it("tests the correct error message is returned when the email field is left empty", () => {
    // Mount the component
    cy.mount(Register);

    // Check there are no errors
    cy.noErrors();

    // Call the custom register command
    cy.register({
      first_name: "Ben",
      last_name: "Brown",
      // Leave the email field blank
      email: "",
      password: "password",
    });

    // Check the correct email error message is present
    cy.shouldShowFieldError("email", "Email is a required field");

    // Check the other fields have no errors
    cy.noFirstNameErrors();
    cy.noLastNameErrors();
    cy.noPasswordErrors();
  });

  it("tests the correct error message is returned when the data entered into the email field is not a string value", () => {
    // Mount the component
    cy.mount(Register);

    // Check there are no errors
    cy.noErrors();

    // Call the custom register command
    cy.register({
      first_name: "Ben",
      last_name: "Brown",
      // Enter an integer into the email field
      email: 1,
      password: "password",
    });

    // Check the correct email error message is present
    cy.shouldShowFieldError("email", "Email must be of data type string");

    // Check the other fields have no errors
    cy.noFirstNameErrors();
    cy.noLastNameErrors();
    cy.noPasswordErrors();
  });

  it("tests the correct error message is returned when the data entered into the email field is not an email", () => {
    // Mount the component
    cy.mount(Register);

    // Check there are no errors
    cy.noErrors();

    // Call the custom register command
    cy.register({
      first_name: "Ben",
      last_name: "Brown",
      // Enter an invalid email into the email field
      email: "bensemail",
      password: "password",
    });

    // Check the correct email error message is present
    cy.shouldShowFieldError("email", "Email must be in a valid email format");

    // Check the other fields have no errors
    cy.noFirstNameErrors();
    cy.noLastNameErrors();
    cy.noPasswordErrors();
  });

  it("tests the correct error message is returned when the data entered into the email field is longer than 55 characters", () => {
    // Mount the component
    cy.mount(Register);

    // Check there are no errors
    cy.noErrors();

    // Get the first name field and enter valid data into it
    cy.get('[data-cy="firstNameInput"]').type("Ben");

    // Get the last name field and enter valid data into it
    cy.get('[data-cy="lastNameInput"]').type("Brown");

    // Get the email field and enter a string 56 characters long into it
    cy.get('[data-cy="emailInput')
      .invoke("val", stringGen(46))
      .type("@gmail.com")
      .should("have.length", 56);

    // Get the password field and enter valid data into it
    cy.get('[data-cy="passwordInput"]').type("password");

    // Check that the correct email error message is present
    cy.shouldShowFieldError(
      "email",
      "Email can not be longer than 55 characters"
    );

    // Check the other fields have no errors
    cy.noFirstNameErrors();
    cy.noLastNameErrors();
    cy.noPasswordErrors();
  });
});
