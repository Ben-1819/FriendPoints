<template>
  <div class="navbar">
    <Navbar />
  </div>
  <div>
    <div class="topscreen">
      <button class="abutton" @click="home">Home</button>
      <h1 class="title">Group 2 friends</h1>
    </div>
    <div class="group2List">
      <ul>
        <li v-for="friend in group2Friends" :key="friend.id">
          {{ friend.first_name }} {{ friend.last_name }} - Points:
          {{ friend.points }} <button class="abutton">Edit friend</button>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useAuthStore } from "@/stores/auth";
import { useRouter } from "vue-router";
import Navbar from "./Navbar.vue";

// Create a constant called authStore and set it to the useAuthStore method
const authStore = useAuthStore();

// Create a constant called router and set it to the useRouter method
const router = useRouter();

// Create a constant called group2Friends and set it to an empty array
const group2Friends = ref([]);

// onMounted hook - define code to run whenever the component is mounted
onMounted(() => {
  // Get the token from local storage
  const token = localStorage.getItem("token");

  // If the token exists
  if (token) {
    // Set the token in the auth store
    authStore.setToken(token);
    // Fetch the user from the auth store
    authStore.fetchUser();

    getGroup2Friends;
  } else if (token === null) {
    // If the token is null send the user back to the login screen
    router.push("/login");
  }
});

// Home method - Takes the user back to the home page
const home = () => {
  router.push("/home");
};

// getGroup2Friends Method - Gets all of the users group 2 friends
const getGroup2Friends = async () => {
  try {
    const response = await axios.get("http://127.0.0.1:8000/api/group2/index", {
      headers: {
        // Pass the token from the auth store into the authorization header
        Authorization: `Bearer ${authStore.token}`,
      },
    });
    console.log("All group 2 friends retrieved");
    // Set the value of the group2Friends constant to the data from the response
    group2Friends.value = response.data.friends;
  } catch (error) {
    console.log("An error has occurred".error);
  }
};

// editFriend method - Takes the user to the edit friend menu
const editFriend = () => {};
</script>

<style scoped>
.topscreen {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
}

.title {
  text-align: center;
  font-size: 1.2rem;
}

.navbar {
  margin-bottom: 10px;
}
</style>
