<template>
  <div class="navbar">
    <Navbar />
  </div>
  <div>
    <div class="topscreen">
      <button class="abutton">
        <router-link id="blackText" to="/home">Home</router-link>
      </button>
      <h1 class="title">Confirm delete friend</h1>
    </div>
    <div class="mainArea">
      <form @submit.prevent="deleteFriend">
        <div class="friendInformation">
          <p>First name: {{ friend.first_name }}</p>
          <p>Last name: {{ friend.last_name }}</p>
          <p>Group: {{ friend.group }}</p>
          <p>Points: {{ friend.points }}</p>
        </div>
        <div class="centred">
          <button type="submit" class="abutton">Delete Friend</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useAuthStore } from "@/stores/auth";
import { useRoute, useRouter } from "vue-router";
import Navbar from "./Navbar.vue";

// Create a constant called authStore and set it to the value of the useAuthStore method
const authStore = useAuthStore();

// Create a constant called router and set it to the value of the useRouter method
const router = useRouter();

// Create a constant called route and set it to the useRoute method
const route = useRoute();

// Create the id constant and set it to the id in the route parameter
const id = route.params.id;

const friend = ref([]);

const success = ref("");

const errors = ref([]);

// onMounted hook - runs when the component is mounted
onMounted(() => {
  console.log("deleteFriend component running");
  // Get the JWT from the browsers local storage
  const token = localStorage.getItem("token");

  // If the token exists
  if (token) {
    authStore.setToken(token);
    authStore.fetchUser();
    console.log("getFriend method running");
    getFriend();
  } else if (token === null) {
    // Push the user back to the login page
    router.push("/login");
  }
});

// deleteFriend method - deletes a friend when it is ran
const deleteFriend = async () => {
  try {
    const response = await axios.delete(
      `http://127.0.0.1:8000/api/${id}/delete`,
      {
        headers: {
          Authorization: `Bearer ${authStore.token}`,
        },
      }
    );

    console.log(
      "Friend has been deleted, sending the user back to the home page in 2 seconds"
    );

    success.value = response.data.success;

    setTimeout(() => {
      router.push("/home");
    }, 2000);
  } catch (error) {
    console.log("An error has occurred: ", error);
    if (error.response && error.response.status === 401) {
      errors.value = error.response.data.error;
    }
  }
};

// getFriend method - retrieves a specified record from the friends table when it runs
const getFriend = async () => {
  try {
    const response = await axios.get(`http://127.0.0.1:8000/api/${id}/show`, {
      headers: { Authorization: `Bearer ${authStore.token}` },
    });

    console.log("Friend successfully retrieved");

    friend.value = response.data.friend;
  } catch (error) {
    console.log("An error has occurred: ", error);
  }
};

const home = () => {
  router.push("/home");
};
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
}

.mainArea {
  margin-top: 10px;
  margin-bottom: 10px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.mainArea > * {
  margin-top: 5px;
  margin-bottom: 5px;
  padding-left: 5px;
  padding-right: 5px;
}

.friendInformation {
  padding-top: 10px;
  padding-bottom: 10px;
}

.abutton {
  border-radius: 15%;
  border: none;
  background-color: #10b981;
}

.centred {
  display: flex;
  flex-direction: row;
}

#blackText {
  color: black;
}

.navbar {
  margin-bottom: 10px;
}
</style>
