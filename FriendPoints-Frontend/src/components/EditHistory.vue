<template>
  <div>
    <div class="topscreen">
      <button class="abutton">
        <router-link class="blackText" to="/home">Home</router-link>
      </button>
      <h1 id="title">Update Historical record</h1>
    </div>
    <div class="mainArea">
      <div class="friendInformation">
        <p>
          Friend historical record belongs to:
          {{ friend.first_name + " " + friend.last_name }}
        </p>
      </div>
      <div class="updateHistoryArea">
        <form @submit.prevent="updateHistoryRecord">
          <h2 id="title">Update the historical records reason or title</h2>
          <div class="updateTitleInput">
            <label for="titleInput">Title:</label>
            <input
              type="text"
              name="titleInput"
              id="titleInput"
              v-model="history.title"
            />
            <span v-if="errors.title" class="validationErrors">{{
              errors.title
            }}</span>
          </div>
          <div class="updateReasonInput">
            <label for="reasonInput">Reason:</label>
            <input
              type="text"
              name="reasonInput"
              id="reasonInput"
              v-model="history.reason"
            />
            <span v-if="errors.reason" class="validationErrors">{{
              errors.reason
            }}</span>
          </div>
          <div class="centred">
            <button type="submit" class="abutton">Update record</button>
          </div>
        </form>
      </div>
      <div class="centered">
        <h2 id="title">Delete history</h2>
        <p>
          Only click this button if you want to delete the current history
          record
        </p>
        <button class="abutton" @click="deleteHistoryRecord">
          Delete history record
        </button>
      </div>
    </div>
  </div>
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

const deleteHistoryRecord = async () => {
  try {
    const response = await axios.delete(
      `http://127.0.0.1:8000/api/${history.value.id}/delete`,
      {
        headers: { Authorization: `Bearer ${authStore.token}` },
      }
    );
    console.log(
      "Historical record successfully deleted, returning to home page in 2 seconds"
    );

    success.value = response.data.success;
    setTimeout(() => {
      router.push("/home");
    }, 2000);
  } catch (error) {
    console.log("An error has occurred: ", error);
  }
};
</script>

<style scoped></style>
