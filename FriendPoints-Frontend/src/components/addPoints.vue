<template>
  <div>
    <div class="topscreen">
      <button class="abutton" @click="home">Home</button>
      <h1 class="title">Add Points</h1>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useAuthStore } from "@/stores/auth";
import { useRouter, useRoute } from "vue-router";

const authStore = useAuthStore();

const router = useRouter();

const route = useRoute();

const id = route.params.id;

const friend = ref([]);

const errors = ref([]);

onMounted(() => {
  console.log("addPoints component running");

  // Get the token from local storage
  const token = localStorage.getItem("token");

  if (token) {
    authStore.setToken(token);
    authStore.fetchUser();
  } else if (token === null) {
    router.push("/home");
  }
});

const home = () => {
  router.push("/home");
};

// getFriend method - retrieves a specified record from the friend table when it runs
const getFriend = async () => {
  try {
    const response = await axios.get(`http://127.0.0.1:8000/api/${id}/show`, {
      headers: { Authorization: `Bearer ${authStore.token}` },
    });

    console.log("Friend retrieved from database");

    friend.value = response.data.friend;
  } catch (error) {
    console.log("An error has occurred");
  }
};
</script>

<style scoped></style>
