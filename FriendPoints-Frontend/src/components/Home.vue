<template>
  <div>
    <h1 class="title">Friend Points</h1>
    <h2 class="title">Welcome {{ authStore.user.first_name }}</h2>
    <div class="buttonGroup">
      <button data-cy="allUsersBtn" @click="allUsers">All Users</button>
      <button data-cy="friendsBtn">Your Friends</button>
    </div>
    <div class="buttonGroup">
      <button data-cy="rankingsBtn">Current Rankings</button>
      <button data-cy="logoutBtn" @click="logout">Logout</button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useAuthStore } from "@/stores/auth";
import { useRouter } from "vue-router";

// Create a constant called router and set it to the useRouter method
const router = useRouter();
// Create a constant authStore and set it to the useAuthStore method
const authStore = useAuthStore();

// Whenever the component is mounted
onMounted(() => {
  // Get the token from local storage.
  const token = localStorage.getItem("token");
  // If the token has a value
  if (token) {
    // Set the token in the auth store to the token retrieved from the browsers local storage.
    authStore.setToken(token);
    // Call the fetchUser action in the authStore
    authStore.fetchUser();
  } else if (token === null) {
    console.log("No token found in local storage");
    // Send the user back to the login screen
    router.push("/login");
  }
});

const allUsers = () => {
  // Push the user to the users page
  router.push("/users");
};

const yourFriends = () => {};

const currentRankings = () => {};

const logout = () => {
  authStore.logout();
  router.push("/login");
};
</script>

<style scoped>
.title {
  text-align: center;
  margin-bottom: 10px;
}

.buttonGroup {
  position: relative;
  display: flex;
  flex-direction: row;
  justify-content: center;
  margin-top: 10px;
  margin-bottom: 10px;
}

.buttonGroup button {
  border-radius: 15%;
  font-size: 1.2rem;
  background-color: #10b981;
  border: none;
  margin-left: 10px;
  margin-right: 10px;
}
</style>
