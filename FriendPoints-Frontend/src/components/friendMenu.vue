<template>
  <div>
    <div class="topscreen">
      <button class="abutton" @click="home">Home</button>
      <h1 class="title">Friends menu</h1>
    </div>
    <div class="options">
      <button class="abutton" @click="allFriends">All friends</button>
      <button class="abutton" @click="notFriends">Non-friended users</button>
    </div>
    <div class="options">
      <button class="abutton" @click="group1Friends">Group 1 friends</button>
      <button class="abutton" @click="group2Friends">Group 2 friends</button>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from "vue";
import { useAuthStore } from "@/stores/auth";
import { useRouter } from "vue-router";

// Create a constant called authStore and set it to the useAuthStore method
const authStore = useAuthStore();

// Create a constant called router and set it to the useRouter method
const router = useRouter();

// onMounted hook - code to run whenever the component is mounted
onMounted(() => {
  // Create a constant called token and set it to the value of the token from local storage
  const token = localStorage.getItem("token");

  // If the token exists
  if (token) {
    // Set the token in the auth store
    authStore.setToken(token);
    // Fetch the user from the auth store
    authStore.fetchUser();
  } else if (token === null) {
    // If the token doesn't exist then push the user back to the login view
    router.push("/login");
  }
});

// home method - takes the user back to the home screen
const home = () => {
  // Push the user to to the component
  router.push("/home");
};

// allFriends method - takes the user to the allFriends component
const allFriends = () => {
  // Push the user to the allFriends component
  router.push("/allFriends");
};

// notFriends method - takes the user to the allUsers component
const notFriends = () => {
  // Push the user to the allUsers component
  router.push("/users");
};

// group1Friends method - takes the user to the group 1 friends component
const group1Friends = () => {
  // Push the user to the group1Friends component
  router.push("/group1Friends");
};

// group2Friends method - takes the user to the group 2 friends component
const group2Friends = () => {};
</script>

<style scoped>
.topscreen {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}

.title {
  text-align: center;
  font-size: 1.2rem;
}

.abutton {
  background-color: #10b981;
  border-radius: 15%;
  border: none;
  margin-left: 10px;
  margin-right: 10px;
}

.options {
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  margin-top: 10px;
  margin-bottom: 10px;
}
</style>
