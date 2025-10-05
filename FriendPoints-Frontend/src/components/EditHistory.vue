<template>
  <div></div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useAuthStore } from "@/stores/auth";
import { useRouter } from "vue-router";

const authStore = useAuthStore();

const router = useRouter();

const props = defineProps({
  id: {
    type: String,
    required: true,
  },
});

const friend = ref([]);

const history = ref([]);

const success = ref(null);

onMounted(() => {
  const token = localStorage.getItem("token");

  if (token) {
    authStore.setToken(token);
    authStore.fetchUser();
    getHistoryRecord();
    setTimeout(() => {
      getFriendRecord();
    }, 1500);
  } else if (token === null) {
    router.push("/login");
  }
});

const getHistoryRecord = async () => {
  try {
    const response = await axios.get(
      `http://127.0.0.1:8000/api/history/${props.id}/show`,
      {
        headers: { Authorization: `Bearer ${authStore.token}` },
      }
    );
    console.log("Historical record retrieved");
    history.value = response.data.history;
  } catch (error) {
    console.log("An error has occurred: ", error);
  }
};

const getFriendRecord = async () => {
  try {
    const response = await axios.get(
      `http://127.0.0.1:8000/api/${history.value.friend_id}/show`,
      {
        headers: { Authorization: `Bearer ${authStore.token}` },
      }
    );
    console.log("Friend record retrieved");
    friend.value = response.data.friend;
  } catch (error) {
    console.log("An error has occurred: ", error);
  }
};

const updateHistoryRecord = async () => {
  try {
    const response = await axios.put(
      `http://127.0.0.1:8000/api/history/${props.id}/update`,
      {
        title: history.value.title,
        reason: history.value.reason,
      },
      {
        headers: { Authorization: `Bearer: ${authStore.token}` },
      }
    );
    console.log(
      "History record updated, moving to the view history screen for this record in 2 seconds"
    );

    success.value = response.data.success;

    setTimeout(() => {
      showHistory();
    }, 2000);
  } catch (error) {
    console.log("An error has occurred: ", error);
  }
};

const showHistory = () => {
  router.push({
    name: "ShowHistory",
    params: history.value.id,
  });
};
</script>

<style scoped></style>
