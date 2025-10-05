<template>
  <div>
    <div class="topscreen">
      <button class="abutton">
        <router-link class="blackText" to="/home">Home</router-link>
      </button>
      <h1 id="title">{{ history.title }}</h1>
    </div>
    <div class="mainArea">
      <div class="infoSection">
        <p>Reason for change: {{ history.reason }}</p>
        <p>Points before: {{ history.before }}</p>
        <p>Points after: {{ history.after }}</p>
        <p>Total change: {{ (changeType, history.change) }}</p>
        <p>{{ history.friend_id }}</p>
      </div>
      <div class="buttonsSection">
        <button class="abutton">
          <router-link class="blackText" :to="`/showFriend/${friend.id}`"
            >View Friend</router-link
          >
        </button>
        <button class="abutton" @click="goToFriendHistories">
          All historical records for this friend
        </button>
      </div>
      <div class="buttonsSection">
        <button class="abutton">
          <router-link class="blackText" :to="`/home`"
            >Edit historical record</router-link
          >
        </button>
        <button class="abutton">Delete historical record</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import { useAuthStore } from "@/stores/auth";
import axios from "axios";
import { useRouter, useRoute } from "vue-router";

const authStore = useAuthStore();

const router = useRouter();

const route = useRoute();

const id = route.params.id;

const friend = ref([]);

const history = ref([]);

const errors = ref([]);

const changeType = computed(() => {
  return history.before > history.after ? "-" : "+";
});

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
    console.log(
      "Token doesn't exist or has expired, sending the user to the login component"
    );
    router.push("/login");
  }
});

const getHistoryRecord = async () => {
  try {
    const response = await axios.get(
      `http://127.0.0.1:8000/api/history/${id}/show`,
      { headers: { Authorization: `Bearer ${authStore.token}` } }
    );
    console.log("Historical record retrieved.");
    console.log(response.data.history);
    history.value = response.data.history;
  } catch (error) {
    console.log("An error has occurred: ", error);
    errors.value = error.response.data.errors;
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
    console.log("The friend that the history belongs to has been retrieved.");

    friend.value = response.data.friend;
  } catch (error) {
    console.log("An error has occurred: ", error);
    errors.value = error.response.data.errors;
  }
};

const goToFriendHistories = () => {
  router.push({
    name: "FriendHistories",
    params: {
      id: friend.value.id,
    },
  });
};
</script>

<style scoped>
.topscreen {
  display: flex;
  flex-direction: row;
  justify-content: start;
  margin-top: 10px;
  margin-bottom: 10px;
}

#title {
  text-align: center;
}

.mainArea {
  margin-top: 10px;
  margin-bottom: 10px;
}

.infoSection {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: center;
}

.abutton {
  border-radius: 25%;
  border: none;
  background-color: #10b981;
  margin-left: 10px;
  margin-right: 10px;
}

.buttonSection {
  display: flex;
  flex-direction: row;
  justify-content: space-evenly;
  align-items: center;
  margin-top: 10px;
  margin-bottom: 10px;
}

.blackText {
  color: black;
}
</style>
