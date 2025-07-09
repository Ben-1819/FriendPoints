<template>
  <h1 id="title">Register</h1>
  <div class="register-form">
    <form v-on:submit.prevent="register">
      <div class="flexcolumn">
        <div class="group">
          <input
            type="text"
            v-model="first_name"
            data-cy="firstNameInput"
            placeholder="Enter your first name here"
            @input="clearFieldError('first_name')"
          />
          <span
            v-if="validationErrors.first_name"
            data-cy="firstNameError"
            class="validationError"
            >{{ validationErrors.first_name }}</span
          >
        </div>
        <div class="group">
          <input
            type="text"
            v-model="last_name"
            data-cy="lastNameInput"
            placeholder="Enter your last name here"
            @input="clearFieldError('last_name')"
          />
          <span
            v-if="validationErrors.last_name"
            data-cy="lastNameError"
            class="validationError"
            >{{ validationErrors.last_name }}</span
          >
        </div>
        <div class="group">
          <input
            type="email"
            v-model="email"
            data-cy="emailInput"
            placeholder="Enter your email here"
            @input="clearFieldError('email')"
          />
          <span
            v-if="validationErrors.email"
            data-cy="emailError"
            class="validationError"
          >
            {{ validationErrors.email }}
          </span>
        </div>
        <div class="group">
          <input
            type="password"
            v-model="password"
            data-cy="passwordInput"
            placeholder="Enter your password here"
            @input="clearFieldError('password')"
          />
          <span
            v-if="validationErrors.password"
            data-cy="passwordError"
            class="validationError"
            >{{ validationErrors.password }}</span
          >
        </div>
        <div class="bottom-buttons">
          <button id="register-button" data-cy="register-button">
            Register now
          </button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import { useAuthStore } from "@/stores/auth";
import { mapStores } from "pinia";
export default {
  data() {
    return {
      first_name: "",
      last_name: "",
      email: "",
      password: "",
      validationErrors: {},
      success: null,
    };
  },
  computed: {
    ...mapStores(useAuthStore),
  },
  methods: {
    // register method, allows the user to make a post request and register their account
    async register() {
      try {
        // Make a post request to the register route
        const response = await axios.post(
          "http://127.0.0.1:8000/api/register",
          {
            // Send the first_name variable in the first name field
            first_name: this.first_name,
            // Send the last_name variable in the last name field
            last_name: this.last_name,
            // Send the email variable in the email field
            email: this.email,
            // Send the password variable in the password field
            password: this.password,
          }
        );
        this.authStore.setToken(response.data.token);
        this.authStore.setUser(response.data.user);
        localStorage.setItem("token", response.data.token);
      } catch (error) {
        console.log("An error occured" + error);
        // Use an if statement to check for validation errors
        if (error.response && error.response.status === 422) {
          this.validationErrors = error.response.data.errors;
        }
      }
    },
    // clearFieldError method, clears the error messages when the user starts typing in a field
    clearFieldError(field) {
      if (this.validationErrors[field]) {
        delete this.validationErrors[field];
      }
    },
  },
};
</script>

<style scoped>
#title {
  text-align: center;
  margin-bottom: 10px;
}

.bottom-buttons {
  position: relative;
  display: flex;
  flex-direction: row;
  justify-content: center;
}

.bottom-buttons button {
  border-radius: 15%;
  font-size: 1.2rem;
}

.flexcolumn {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.flexcolumn input {
  margin-top: 5px;
  margin-bottom: 5px;
  border-radius: 15%;
  border: 1px solid white;
  background-color: black;
  color: white;
  height: 30px;
}

.focused {
  border-color: #10b981;
  background-color: #f0fff4;
}

#register-button {
  background-color: #10b981;
  border: none;
}

.validationError {
  color: red;
  font-style: oblique;
}
</style>
