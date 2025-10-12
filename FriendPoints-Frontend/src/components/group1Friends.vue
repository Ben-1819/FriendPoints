<template>
  <div class="navbar">
    <Navbar />
  </div>
  <div>
    <div class="topscreen">
      <button class="abutton" @click="home">Home</button>
      <h1 class="title">Group 1 friends</h1>
    </div>
    <div class="group1List">
      <ul>
        <li v-for="friend in group1Friends" :key="friend.id">
          {{ friend.first_name }} {{ friend.last_name }} - Points:
          {{ friend.points }}
          <button class="abutton">Edit friend</button>
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

// Create a constant called group1Friends and set it to an empty array
const group1Friends = ref([]);

// onMounted hook - define code to be ran whenever the component is mounted
onMounted(() => {
  // Create a constant called token and set it to the token from local storage
  const token = localStorage.getItem("token");

  // If the token exists
  if (token) {
    // Set the token in the authStore
    authStore.setToken(token);
    // Fetch the user from the authStore
    authStore.setUser();

    getGroup1Friends;
  } else if (token === null) {
    router.push("/login");
  }
});

// group1Friends method - retrieves all of the users group 1 friends
const getGroup1Friends = async () => {
  try {
    const response = await axios.get("http://127.0.0.1:8000/api/group1/index", {
      headers: {
        Authorization: `Bearer ${authStore.token}`,
      },
    });
    console.log("Retrieved all of the users group 1 friends");
    // Set the value of group1Friends to the object returned in the response
    group1Friends.value = response.data.friends;
  } catch (error) {
    console.log("An error has occurred", error);
  }
};

// home method - takes the user back to the home screen when clicked
const home = () => {
  router.push("/home");
};

// editFriend method - takes the user to the edit friend menu
const editFriend = () => {};
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

.navbar {
  margin-bottom: 10px;
}
</style>
