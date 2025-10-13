<template>
  <div class="navbar">
    <Navbar />
  </div>
  <div>
    <div class="topscreen">
      <h1 class="title">Edit friends menu</h1>
    </div>
    <div class="options">
      <button class="abutton" @click="addPoints(id)">Add Points</button>
      <button class="abutton" @click="removePoints(id)">Remove Points</button>
    </div>
    <div class="options">
      <button class="abutton" @click="changeGroup(id)">Change group</button>
      <button class="abutton" @click="deleteFriend(id)">Delete Friend</button>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from "vue";
import { useAuthStore } from "@/stores/auth";
import { useRoute, useRouter } from "vue-router";
import Navbar from "./Navbar.vue";

// Create a constant called authStore and set it to the useAuthStore method
const authStore = useAuthStore();

// Create a constant called router and set it to the useRouter method
const router = useRouter();

// Create a constant called route and set it to the useRoute method
const route = useRoute();

// Get the id from the route params
const id = route.params.id;

onMounted(() => {
  console.log("editFriendMenu component mounted");
  const token = localStorage.getItem("token");
  // If the token exists
  if (token) {
    authStore.setToken(token);
    authStore.fetchUser();
  } else if (token === null) {
    logout();
  }
});

// addPoints method
const addPoints = (id) => {
  router.push({
    name: "AddPoints",
    params: {
      id: id,
    },
  });
};

// removePoints method
const removePoints = (id) => {
  router.push({
    name: "RemovePoints",
    params: {
      id: id,
    },
  });
};

// changeGroup method
const changeGroup = (id) => {
  router.push({
    name: "ChangeGroup",
    params: {
      id,
      id,
    },
  });
};

// deleteFriend method
const deleteFriend = (id) => {
  router.push({
    name: "DeleteFriend",
    params: {
      id: id,
    },
  });
};

const logout = () => {
  authStore.logout();
  router.push({
    name: "Login",
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

.title {
  text-align: center;
  font-size: 1.2rem;
}

.options {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
}

.abutton {
  border-radius: 15%;
  background-color: #10b981;
  border: none;
}

.navbar {
  margin-bottom: 10px;
}
</style>
