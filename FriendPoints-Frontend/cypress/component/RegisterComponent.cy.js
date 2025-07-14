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

    // Check the first name error message was returned
    cy.shouldShowFieldError(
      "firstName",
      "First name can not be longer than 55 characters"
    );
  });
});
