<template>
  <div class="fullBleed">
    <ul>
      <li @click="goToHome" class="navbarLink">Home</li>
      <li @click="goToYourFriends" class="navbarLink">Your Friends</li>
      <li @click="goToCurrentRankings" class="navbarLink">Current Rankings</li>
      <li @click="goToAllHistories" class="navbarLink">All Histories</li>
      <li @click="logout" class="navbarLink" id="rightLink">Logout</li>
    </ul>
  </div>
</template>

<script setup>
import { onMounted } from "vue";
import { useAuthStore } from "@/stores/auth";
import { useRouter } from "vue-router";

const authStore = useAuthStore();

const router = useRouter();

onMounted(() => {
  const token = localStorage.getItem("token");

  if (token) {
    authStore.setToken(token);
    authStore.fetchUser();
  } else if (token === null) {
    logout();
  }
});

const goToHome = () => {
  router.push({
    name: "Home",
  });
};

const goToYourFriends = () => {
  router.push({
    name: "AllFriends",
  });
};

const goToCurrentRankings = () => {
  router.push({
    name: "CurrentRankings",
  });
};

const goToAllHistories = () => {
  router.push({
    name: "AllHistory",
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
div {
  width: 100%;
  max-width: none;
  margin: 0;
  padding: 0;
  position: absolute;
  top: 0px;
  left: 0px;
}

ul {
  list-style-type: none;
  display: flex;
  justify-content: flex-start;
  align-items: center;
  background-color: #111111;
  height: 50px;
}

.navbarLink {
  display: block;
  position: relative;
  color: #10b981;
  padding-left: 5px;
  padding-right: 5px;
  transition: color 1s ease;
}

#rightLink {
  margin-left: auto;
  margin-right: 10px;
}

.navbarLink::after {
  content: "";
  position: absolute;
  left: 0;
  bottom: 0;
  width: 0;
  height: 2px;
  background-color: #10b981;
  transition: width 1s ease;
}

.navbarLink:hover::after {
  width: 100%;
}
</style>
