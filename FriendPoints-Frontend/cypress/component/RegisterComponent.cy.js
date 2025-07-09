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
});
