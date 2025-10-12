<template>
  <div class="navbar">
    <Navbar />
  </div>
  <div>
    <div class="topscreen">
      <button class="abutton">
        <router-link class="blackText" to="/home">Home</router-link>
      </button>
      <h1 class="title">Update Historical record</h1>
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
          <h2 class="title">Update the historical records reason or title</h2>
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
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useAuthStore } from "@/stores/auth";
import { useRouter } from "vue-router";
import Navbar from "./Navbar.vue";

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

const success = ref();

const errors = ref([]);

onMounted(() => {
  const token = localStorage.getItem("token");

  if (token) {
    console.log(token);
    authStore.setToken(token);
    authStore.fetchUser();
    getHistoryRecord()
      .then(() => getFriendRecord())
      .catch((err) => console.log("An error has occurred: ", err));
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
        headers: { Authorization: `Bearer ${authStore.token}` },
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

<style scoped>
.topscreen {
  display: flex;
  flex-direction: row;
  justify-content: start;
  align-items: center;
  margin-top: 10px;
  margin-bottom: 10px;
}

.mainArea {
  display: flex;
  flex-direction: column;
  justify-content: space-evenly;
  align-items: center;
  margin-top: 10px;
  margin-bottom: 10px;
}

.updateTitleInput {
  margin-top: 5px;
  margin-bottom: 5px;
}

.updateReasonInput {
  margin-top: 5px;
  margin-bottom: 5px;
}

.centred {
  display: flex;
  justify-content: center;
  margin-top: 10px;
}

.abutton {
  border-radius: 15%;
  border: none;
  background-color: #10b981;
}

.blackText {
  color: black;
}

.navbar {
  margin-bottom: 10px;
}
</style>
