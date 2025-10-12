<template>
  <div></div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useAuthStore } from "@/stores/auth";
import axios from "axios";
import { useRouter } from "vue-router";

const authStore = useAuthStore();
const router = useRouter();

const friends = ref([]);

onMounted(() => {
  const token = localStorage.getItem("token");

  if (token) {
    authStore.setToken(token);
    authStore.fetchUser();
    getFriendRankings();
  } else if (token === null) {
    router.push({
      name: "Login",
    });
  }
});

const getFriendRankings = async () => {
  try {
    const response = await axios.get(`http://127.0.0.1:8000/api/index`, {
      headers: { Authorization: `Bearer ${authStore.token}` },
    });

    console.log("Friends retrieved successfully");
    friends.value = response.data.friends;
  } catch (error) {
    console.log("An error has occurred: ", error);
  }
};

const goToHome = () => {
  router.push({
    name: "Home",
  });
};
</script>

<style lang="scss" scoped></style>
