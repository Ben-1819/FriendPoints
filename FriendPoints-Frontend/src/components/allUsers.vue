<template>
  <div>
    <h1 class="title">All Users</h1>
    <div class="userList">
      <ul>
        <li v-for="user in users" :key="user.id">
          {{ user.first_name }} {{ user.last_name }}
          <button class="addFriendBtn">Add user as friend</button>
        </li>
      </ul>
    </div>

    <button class="homebtn" @click="home">Back to home</button>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useAuthStore } from "@/stores/auth";
import { useRouter } from "vue-router";

// Create a constant called authStore and set it to the useAuthStore method
const authStore = useAuthStore();

// Create a constant called router and set it to the useRouter method
const router = useRouter();

// Create a constant called users and set it to an empty array
const users = ref([]);

// Whenever the component is mounted
onMounted(() => {
  // Get the token from the browsers local storage
  const token = localStorage.getItem("token");
  console.log(token);
  // If the token has a value
  if (token) {
    // Set the token in the auth store
    authStore.setToken(token);
    // Fetch the user from the auth store
    authStore.fetchUser();

    console.log("Calling the all users method");
    // Call the allUsers method
    allUsers();
  }
});

// allUsers method - fetches all of the users from the database
const allUsers = async () => {
  try {
    const response = await axios.get("http://127.0.0.1:8000/api/userIndex", {
      headers: {
        // Pass the JWT in the authorization header
        Authorization: `Bearer ${authStore.token}`,
      },
    });
    console.log("Retrieved all users");

    // Set the users constant to the users returned in the json response
    users.value = response.data.users;
  } catch (error) {
    console.log("An error has occured");
    console.log("An error has occured".error);
  }
};

// Home method - takes the user back to the home screen
const home = () => {
  router.push("/home");
};

// addFriend method - Takes the user to the add friend component
const addFriend = () => {};
</script>

<style scoped>
.title {
  text-align: center;
  font-size: 1.2rem;
}

.homebtn {
  display: flex;
  flex-direction: row;
  justify-content: center;
  margin-top: 10px;
}

.addFriendBtn {
  border-radius: 15%;
  background-color: #10b981;
  border: none;
}
</style>
