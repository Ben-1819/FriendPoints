<template>
  <div class="navbar">
    <Navbar />
  </div>
  <div>
    <div class="topscreen">
      <h1 id="title">
        {{ friend.first_name + " " + friend.last_name }}'s Histories
      </h1>
    </div>
    <div class="mainArea">
      <div class="historyCards">
        <div
          class="historyCard"
          v-for="history in historyRecords"
          :key="history.id"
        >
          <h4 class="historyText">{{ history.title }}</h4>
          <p class="historyText">{{ history.reason }}</p>
          <div class="centred">
            <button class="abutton" @click="goToHistory(history.id)">
              View History
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useAuthStore } from "@/stores/auth";
import { useRouter, useRoute } from "vue-router";
import Navbar from "./Navbar.vue";

const authStore = useAuthStore();

const router = useRouter();

const route = useRoute();
const props = defineProps({
  id: {
    type: String,
    required: true,
  },
});
//const id = route.params.id;

const historyRecords = ref([]);

const friend = ref([]);

onMounted(() => {
  const token = localStorage.getItem("token");
  console.log("id prop:", props.id);
  if (token) {
    authStore.setToken(token);
    authStore.fetchUser();
    getFriendRecord();
    getFriendsHistoryRecords();
  } else if (token === null) {
    logout();
  }
});

const getFriendRecord = async () => {
  try {
    const response = await axios.get(
      `http://127.0.0.1:8000/api/${props.id}/show`,
      {
        headers: { Authorization: `Bearer ${authStore.token}` },
      }
    );
    console.log("Friend record has been retrieved");

    friend.value = response.data.friend;
    console.log(friend.value);
  } catch (error) {
    console.log("An error has occurred: ", error);
  }
};

const getFriendsHistoryRecords = async () => {
  try {
    const response = await axios.get(
      `http://127.0.0.1:8000/api/history/${props.id}/FriendIndex`,
      { headers: { Authorization: `Bearer ${authStore.token}` } }
    );
    console.log(
      "All history records belonging to ",
      friend.value.first_name,
      friend.value.last_name,
      "retrieved."
    );

    historyRecords.value = response.data.records;
    console.log(historyRecords.value);
  } catch (error) {
    console.log("An error has occurred: ", error);
  }
};

const logout = () => {
  authStore.logout();
  router.push({
    name: "Login",
  });
};

const goToHistory = (id) => {
  router.push({
    name: "ShowHistory",
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
  margin-top: 10px;
  margin-bottom: 10px;
}

#title {
  text-align: center;
}

.historyCards {
  display: grid;
  grid-template-columns: repeat(1, minmax(0, 1fr));
  gap: 1.5rem;
  place-items: center;
}

/*Small screens (640px and up)*/
@media (min-width: 640px) {
  .historyCards {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }
}

/*Medium screens (768px and up)*/
@media (min-width: 768px) {
  .historyCards {
    grid-template-columns: repeat(3, minmax(0, 1fr));
  }
}

/*Large screens (1024px and up)*/
@media (min-width: 1024px) {
  .historyCards {
    grid-template-columns: repeat(4, minmax(0, 1fr));
  }
}

.historyCard {
  background-color: white;
  box-shadow: 5px, 5px, 5px, 5px, grey;
  border-radius: 25%;
  overflow: hidden;
  border: 2px;
  border: solid;
  border: black;
  margin: 4px;
}

.historyText {
  color: black;
  text-align: center;
}

.abutton {
  border-radius: 15%;
  border: none;
  background-color: #10b981;
}

.blackText {
  color: black;
}

.centred {
  display: flex;
  justify-content: center;
}

.navbar {
  margin-bottom: 10px;
}
</style>
