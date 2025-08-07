<template>
  <div>
    <div class="topscreen">
      <button class="aButton" @click="backHome">Back to home</button>
      <h1 class="title">All Friends</h1>
    </div>

    <div class="friendsList">
      <ul>
        <li v-for="friend in friends" :key="friend.id">
          {{ friend.first_name }} {{ friend.last_name }} - Points:
          {{ friend.points }} <button class="aButton">Edit friend</button>
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

// Create a constant authStore and set it to the useAuthStore method
const authStore = useAuthStore();

// Create a constant router and set it to the useRouter method
const router = useRouter();

// Create a constant friends and set it to an empty array
const friends = ref([]);

// onMounted Hook - Code that will be ran whenever the component is mounted
onMounted(() => {
  // Get the token from local storage
  const token = localStorage.getItem("token");

  // If the token exists
  if (token) {
    // Set the token in the authStore
    authStore.setToken(token);
    // Fetch the user from the auth store
    authStore.fetchUser();
    // Call the allFriends method
    console.log("Calling the allFriends method");
    allFriends();
  } else if (token === null) {
    // If the token is null push the user back to the login screen
    router.push("/login");
  }
});

// allFriends method - retrieves all users that the logged in user has added as a friend
const allFriends = async () => {
  try {
    // Make an axios request to the allFriends route
    const response = await axios.get("http://127.0.0.1:8000/api/index", {
      headers: {
        Authorization: `Bearer ${authStore.token}`,
      },
    });

    console.log("Retrieved all friends");
    // Set the value of the friends constant to the users returned in the response
    friends.value = response.data.friends;
  } catch (error) {
    console.log("An error has occurred".error);
  }
};

// backHome method - Takes the user back to the home component
const backHome = () => {
  // Push the user back to the home component
  router.push("/home");
};
</script>

<style scoped>
.title {
  text-align: center;
  font-size: 1.2rem;
}

.friendsList {
  display: flex;
  flex-direction: column;
  justify-content: space-evenly;
  align-items: center;
}

.aButton {
  border-radius: 15%;
  background-color: #10b981;
  border: none;
}

.topscreen {
  display: flex;
  flex-direction: row;
  justify-content: space-evenly;
  align-items: center;
}
</style>
