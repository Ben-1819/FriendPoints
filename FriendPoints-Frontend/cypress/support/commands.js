// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************
//
//
// -- This is a parent command --
// Cypress.Commands.add('login', (email, password) => { ... })
//
//
// -- This is a child command --
// Cypress.Commands.add('drag', { prevSubject: 'element'}, (subject, options) => { ... })
//
//
// -- This is a dual command --
// Cypress.Commands.add('dismiss', { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This will overwrite an existing command --
// Cypress.Commands.overwrite('visit', (originalFn, url, options) => { ... })

/**
 * register command - Allows the user to quickly fill in all the input fields in the
 * registration form and submit it during testing
 */
Cypress.Commands.add(
  "register",
  ({ first_name, last_name, email, password }) => {
    // Check if the first_name parameter is null or undefined
    if (first_name !== null && first_name !== undefined) {
      cy.get('[data-cy="firstNameInput"]').clear().type(first_name);
    }
    // Check if the last_name parameter is null or undefined
    if (last_name !== null && last_name !== undefined) {
      cy.get('[data-cy="lastNameInput"]').clear().type(last_name);
    }
    // Check if the email parameter is null or undefined
    if (email !== null && email !== undefined) {
      cy.get('[data-cy="emailInput"]').clear().type(email);
    }
    // Check if the password parameter is null or undefined
    if (password !== null && password !== undefined) {
      cy.get('[data-cy="passwordInput"]').clear().type(password);
    }
    cy.get('[data-cy="register-button"]').click();
  }
);

/**
 * shouldShowFieldError command - Allows for quick checking of the error messages being
 * shown after validation is not met
 */
Cypress.Commands.add("shouldShowFieldError", (field, expectedMessage) => {
  cy.get(`[data-cy="${field}Error"]`)
    .should("be.visible")
    .and("contain", expectedMessage);
});

/**
 * noErrors command - Allows the user to check if there are any error messages present
 * using only one line
 */
Cypress.Commands.add("noErrors", () => {
  cy.get('[data-cy="firstNameError"]').should("not.exist");
  cy.get('[data-cy="lastNameError"]').should("not.exist");
  cy.get('[data-cy="emailError"]').should("not.exist");
  cy.get('[data-cy="passwordError"]').should("not.exist");
});

/**
 * noFirstNameErrors command - Used to quickly check there are no first name errors
 */
Cypress.Commands.add("noFirstNameErrors", () => {
  cy.get('[data-cy="firstNameError"]').should("not.exist");
});

/**
 * noLastNameErrors command - Used to quickly check there are no last name errors
 */
Cypress.Commands.add("noLastNameErrors", () => {
  cy.get('[data-cy="lastNameError"]').should("not.exist");
});

/**
 * noEmailErrors command - Used to quickly check there are no email errors
 */
Cypress.Commands.add("noEmailErrors", () => {
  cy.get('[data-cy="emailError"]').should("not.exist");
});

/**
 * noPasswordErrors command - Used to quickly check there are no password errors
 */
Cypress.Commands.add("noPasswordErrors", () => {
  cy.get('[data-cy="passwordError"]').should("not.exist");
});
