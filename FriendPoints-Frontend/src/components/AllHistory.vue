<template>
  <div>
    <div class="topscreen">
      <button class="abutton">
        <router-link class="blackText" to="/home">home</router-link>
      </button>
      <h1 id="title">History Index</h1>
    </div>
    <div class="mainArea">
      <div class="historyCards">
        <div
          class="historyCard"
          v-for="history in historyRecords"
          :key="history.id"
        >
          <h4 class="history-text">{{ history.title }}</h4>
          <p class="history-text">{{ truncateText(history.reason, 15) }}</p>
          <div class="centred">
            <button class="abutton">
              <router-link class="blackText" :to="`/showHistory/${history.id}`"
                >View History</router-link
              >
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useAuthStore } from "@/stores/auth";
import axios from "axios";
import { useRouter } from "vue-router";

const authStore = useAuthStore();

const router = useRouter();

const historyRecords = ref([]);

onMounted(() => {
  const token = localStorage.getItem("token");

  if (token) {
    authStore.setToken(token);
    authStore.fetchUser();
    getHistoryRecords();
  } else if (token === null) {
    router.push("/login");
  }
});

const getHistoryRecords = async () => {
  try {
    const response = await axios.get(
      "http://127.0.0.1:8000/api/history/records",
      { headers: { Authorization: `Bearer ${authStore.token}` } }
    );
    console.log("Retrieved all historical records");

    historyRecords.value = response.data.records;
  } catch (error) {
    console.log("An error has occurred: ".error);
  }
};

/**
 * @param str this parameter is the string that is being passed into the function to be truncated
 * @param maxLength this is the length that the string can be before it is truncated
 * truncateText function - shortens the text displayed to the user
 */
const truncateText = (str, maxLength) => {
  return str.length > maxLength ? str.substring(0, maxLength) + "..." : str;
};
</script>

<style scoped>
.topscreen {
  display: flex;
  flex-direction: row;
  justify-content: start;
  align-items: center;
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

/* small screens (640px and up) */
@media (min-width: 640px) {
  .historyCards {
    grid-template-columns: repeat(2, minmax(0, 1fr)); /*grid-cols-2*/
  }
}

/* medium screens (768px and up) */
@media (min-width: 768px) {
  .historyCards {
    grid-template-columns: repeat(3, minmax(0, 1fr));
  }
}

/* large screens (1024px and up) */
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

.history-text {
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
</style>
