<template>
  <div>
    <div class="topscreen">
      <button class="abutton" @click="home">Home</button>
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
    // Push the user back to the login page
    router.push("/login");
  }
});

// addPoints method
const addPoints = (id) => {
  router.push(`/addPoints/${id}`);
};

// removePoints method
const removePoints = (id) => {
  router.push(`/removePoints/${id}`);
};

// changeGroup method
const changeGroup = (id) => {
  router.push(`/changeGroup/${id}`);
};

// deleteFriend method
const deleteFriend = (id) => {
  router.push(`/deleteFriend/${id}`);
};

// home method
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
</style>
