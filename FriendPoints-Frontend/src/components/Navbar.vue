<template>
  <div></div>
</template>

<script setup>
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
    name: "AllHistories",
  });
};

const logout = () => {
  authStore.logout();
  router.push({
    name: "Login",
  });
};
</script>

<style lang="scss" scoped></style>
