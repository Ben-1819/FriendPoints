<template>
  <div class="navbar">
    <Navbar />
  </div>
  <div>
    <div class="topscreen">
      <h1 id="title">Friend Information</h1>
    </div>
    <div class="mainArea">
      <p>Name: {{ (friend.first_name, friend.last_name) }}</p>
      <p>Group: {{ friend.group }}</p>
      <p>Points: {{ friend.points }}</p>
    </div>
    <div class="options">
      <button class="abutton" @click="goToAddPoints(id)">Add Points</button>
      <button class="abutton" @click="goToRemovePoints(id)">
        Remove Points
      </button>
    </div>
    <div class="options">
      <button class="abutton" @click="goToChangeGroup(id)">Change Group</button>
      <button class="abutton" @click="goToDeleteFriend(id)">
        Delete Friend
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useAuthStore } from "@/stores/auth";
import axios from "axios";
import { useRouter, useRoute } from "vue-router";
import Navbar from "./Navbar.vue";

const authStore = useAuthStore();

const router = useRouter();

const route = useRoute();

const id = route.params.id;

const friend = ref([]);

onMounted(() => {
  const token = localStorage.getItem("token");

  if (token) {
    authStore.setToken(token);
    authStore.fetchUser();
    getFriendRecord();
  } else if (token === null) {
    logout();
  }
});

const getFriendRecord = async () => {
  try {
    const response = await axios.get(`http://127.0.0.1:8000/api/${id}/show`, {
      headers: { Authorization: `Bearer ${authStore.token}` },
    });
    console.log("Friend retrieved from the database");

    friend.value = response.data.friend;
  } catch (error) {
    console.log("An error has occurred".error);
  }
};

const logout = () => {
  authStore.logout();
  router.push({
    name: "Login",
  });
};

const goToAddPoints = (id) => {
  router.push({
    name: "AddPoints",
    params: {
      id: id,
    },
  });
};

const goToRemovePoints = (id) => {
  router.push({
    name: "RemovePoints",
    params: {
      id: id,
    },
  });
};

const goToChangeGroup = (id) => {
  router.push({
    name: "ChangeGroup",
    params: {
      id: id,
    },
  });
};

const goToDeleteFriend = (id) => {
  router.push({
    name: "DeleteFriend",
    params: {
      id: id,
    },
  });
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

.navbar {
  margin-bottom: 10px;
}
</style>
