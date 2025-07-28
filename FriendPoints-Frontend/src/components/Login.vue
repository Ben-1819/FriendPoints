<template>
  <div>
    <h1 id="title">Login To Your Account</h1>
    <form @submit.prevent="attemptLogin">
      <div class="flexColumn">
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
            >{{ validationErrors.email }}</span
          >
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
          >
            {{ validationErrors.password }}
          </span>
        </div>
        <div class="bottom-buttons">
          <button id="register-button" data-cy="register-button">Login</button>
          <router-link to="/register"
            >Need to register for an account? Click here</router-link
          >
        </div>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import { useAuthStore } from "@/stores/auth";
import { useRouter } from "vue-router";

const router = useRouter();
const email = ref("");
const password = ref("");
const validationErrors = ref({});

const authStore = useAuthStore();

// register method, allows the user to make a post request and register their account
const attemptLogin = async () => {
  try {
    // Make a post request to the login route
    const response = await axios
      .post("http://127.0.0.1:8000/api/login", {
        // Send the email variable in the email field
        email: email.value,
        // Send the password variable in the password field
        password: password.value,
      })
      .then((response) => {
        // Create a variable called token and set it to the token from the response data
        const token = response.data.token;
        // Create a variable called user and set it to the user from the response data
        const user = response.data.user;
        // Set the user in the auth store to the user from the response data
        console.log("authStore:", authStore);
        authStore.setUser(response.data.user);
        // Set the token in the auth store to the variable token
        authStore.setToken(token);
        // Store the token in the browsers local storage
        localStorage.setItem("token", token);
        authStore.fetchUser();
        router.push("/home");
      });
  } catch (error) {
    // Log the error to the console
    //console.log(`An error has occured ${error.message}`);
    console.log("An error has occured: ", error);

    // Check if there were validation errors
    if (error.response && error.response.status === 422) {
      // Set the validation errors to the validation errors returned in the response
      validationErrors.value = error.response.data.errors;
    }
  }
};
// clearFieldError method - clears the error messages whenever you start typing
const clearFieldError = (field) => {
  if (validationErrors.value[field]) {
    delete validationErrors.value[field];
  }
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
