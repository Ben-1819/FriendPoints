<template>
  <div>
    <div class="topScreen">
      <button class="backBtn" @click="backToUsers">Back</button>
      <h1 class="title">Add a friend</h1>
    </div>

    <form @submit.prevent="addFriend">
      <div class="inputForm">
        <div class="inputGroup">
          <label
            data-cy="groupSelectDropdownLabel"
            for="groupSelectDropdown"
            class="inputLabel"
            >Enter the friend group the user is in:</label
          >
          <select
            data-cy="groupSelect"
            id="groupSelectDropdown"
            v-model="selected"
            @click="clearFieldErrors('group')"
          >
            <option data-cy="group1Option" value="group1">Group 1</option>
            <option data-cy="group2Option" value="group2">Group 2</option>
            <option data-cy="bothOption" value="both">Both</option>
          </select>

          <span v-if="errorMessages.group" data-cy="groupErrorMessage">{{
            errorMessages.group
          }}</span>
        </div>
        <div class="inputGroup">
          <label data-cy="pointsInputLabel" for="pointsInput" class="inputLabel"
            >Enter the users inital amount of points:</label
          >
          <input
            data-cy="pointsInput"
            id="pointsInput"
            type="number"
            placeholder="Enter inital points"
            v-model="points"
            @input="clearFieldErrors('points')"
          />

          <span v-if="errorMessages.points" data-cy="pointsErrorMessage">{{
            errorMessages.points
          }}</span>
        </div>
        <button data-cy="addFriendBtn" type="submit">Add Friend</button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useAuthStore } from "@/stores/auth";
import { useRouter, useRoute } from "vue-router";

// Create the authStore constant and set it to the useAuthStoreMethod
const authStore = useAuthStore();

// Create the router constant and set it to the useRouter method
const router = useRouter();

// Create the route constant and set it to the useRoute method
const route = useRoute();

// Create the id constant and set it to the id in the route parameter
const id = route.params.id;

// Create the selected constant, it stores the group the user will be in
const selected = ref("");

// Create the points constant, it will store the amount of points the friend starts with
const points = ref();

// Create the successMessage constant, it will store the success message if the addFriend request succeeds
const successMessage = ref("");

// Create the errorMessages constant, it will store the error messages for if the validation rules are broken
const errorMessages = ref({});

// Define code to be ran whenever the component is mounted
onMounted(() => {
  // Get the token from the browsers local storage and assign it to the constant token
  const token = localStorage.getItem("token");
  // If the token exists
  if (token) {
    // Set the token in the authStore
    authStore.setToken(token);
    // Fetch the user from the authStore
    authStore.fetchUser();
    console.log("ID prop:", id);
  } else if (token === null) {
    console.log("No token in storage, sending the user to the login screen");
    router.push("/login");
  }
});

// addFriend method - adds the user to the database as a friend
const addFriend = async () => {
  try {
    // Make an axios post request
    const response = await axios.post(
      `http://127.0.0.1:8000/api/${id}/store`,
      {
        // Send the value of the selected constant in the group field
        group: selected.value,
        // Send the value of the points constant in the points field
        points: points.value,
      },
      {
        // Define the headers that will be used in the request
        headers: {
          // Pass the JWT from the authStore in the Authorization header
          Authorization: `Bearer ${authStore.token}`,
        },
      }
    );
    console.log("Success");
    // Set the success message in the response to the successMessage constant
    successMessage.value = response.data.success;
    setTimeout(() => {
      console.log("Returning to home screen in two seconds");
      // Return to the home component
      router.push("/home");
    }, 2000);
  } catch (error) {
    // Log that an error occured
    console.log("An error has occured");
    console.log("An error has occurred".error);

    // Check if there were validation errors
    if (error.response && error.response.status === 422) {
      // Set the validationErrors constant to the validation errors returned
      errorMessages.value = error.response.data.errors;
    }
  }
};

// clearFieldErrors method - clears the field errors when the user start typing
const clearFieldErrors = (field) => {
  if (errorMessages.value[field]) {
    delete errorMessages.value[field];
  }
};

// backToUsers method - Brings the user back to the users list
const backToUsers = () => {
  router.push("/users");
};
</script>

<style scoped>
.title {
  text-align: center;
  font-size: 1.2rem;
}

.inputForm {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-evenly;
}

.inputLabel {
  margin-right: 10px;
}

.inputGroup {
  margin-top: 10px;
  margin-bottom: 10px;
}

.topScreen {
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: center;
}

.topScreen button {
  margin-right: 25px;
}
</style>
