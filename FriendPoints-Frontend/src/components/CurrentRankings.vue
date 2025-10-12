<template>
  <div>
    <div class="topScreen">
      <button class="abutton" @click="goToHome">Home</button>
      <h1 class="title">Current rankings</h1>
    </div>
    <div class="mainArea">
      <ol>
        <li
          v-for="friend in friends"
          :key="friend.id"
          @click="goToFriendsHistories(friend.id)"
        >
          {{ friend.first_name }} {{ friend.last_name }} -
          {{ friend.points }} points
        </li>
      </ol>
    </div>
  </div>
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

const goToFriendsHistories = (id) => {
  router.push({
    name: "FriendHistories",
    params: {
      id: id,
    },
  });
};
</script>

<style lang="scss" scoped></style>
