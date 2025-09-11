<template>
  <div>
    <div class="topscreen">
      <button class="abutton">
        <router-link id="blackText" to="/home">Home</router-link>
        <h1 id="title">Friend Information</h1>
      </button>
    </div>
    <div class="mainArea">
      <p>Name: {{}}</p>
      <p>Group: {{}}</p>
      <p>Points: {{}}</p>
    </div>
    <div class="options">
      <button class="abutton">
        <router-link id="blackText" :to="`/addPoints/${id}`"
          >Add Points</router-link
        >
      </button>
      <button class="abutton">
        <router-link id="blackText" :to="`/removePoints/${id}`"
          >Remove Points</router-link
        >
      </button>
    </div>
    <div class="options">
      <button class="abutton">
        <router-link id="blackText" :to="`/changeGroup/${id}`"
          >Change Group</router-link
        >
      </button>
      <button class="abutton">
        <router-link id="blackText" :to="`/deleteFriend/${id}`"
          >Delete Friend</router-link
        >
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useAuthStore } from "@/stores/auth";
import axios from "axios";
import { useRouter, useRoute } from "vue-router";

const authStore = useAuthStore();

const router = useRouter();

const route = useRoute();

const id = route.params.id();

const friend = ref([]);

onMounted(() => {
  const token = localStorage.getItem("token");

  if (token) {
    authStore.setToken(token);
    authStore.fetchUser();
  } else if (token === null) {
    router.push("/home");
  }
});

const getFriendRecord = async () => {
  try {
    const response = await axios.get(`http:127.0.0.1:8000/api/${id}/show`, {
      headers: { Authorization: `Bearer ${authStore.token}` },
    });
    console.log("Friend retrieved from the database");

    friend.value = response.data.friend;
  } catch (error) {
    console.log("An error has occurred".error);
  }
};
</script>

<style scoped>
.topscreen {
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
}

#title {
  text-align: center;
}

.mainArea {
  margin-top: 10px;
  margin-bottom: 10px;
  display: flex;
  flex-direction: column;
  justify-content: space-evenly;
  align-items: center;
}

.options {
  margin-top: 10px;
  margin-bottom: 10px;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
}

.abutton {
  border-radius: 15%;
  border: none;
  background-color: #10b981;
}

#blackText {
  color: black;
}
</style>
