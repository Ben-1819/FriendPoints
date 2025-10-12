<template>
  <div class="navbar">
    <Navbar />
  </div>
  <div>
    <div class="topscreen">
      <button class="abutton">
        <router-link id="blackText" to="/home">Home</router-link>
      </button>
      <h1 class="title">Add Points</h1>
    </div>
    <div class="mainArea">
      <div class="friendInformation">
        <p>Name: {{ friend.first_name }} {{ friend.last_name }}</p>
        <p>Current Points: {{ friend.points }}</p>
      </div>
      <div class="addPointsArea">
        <form @submit.prevent="addPoints">
          <div class="addPointsInput">
            <label for="pointsInput">Amount of points to add:</label>
            <input
              type="number"
              id="pointsInput"
              name="pointsInput"
              v-model="addedPoints"
            />
            <span v-if="errors.points" class="validationErrors">{{
              errors.points
            }}</span>
          </div>
          <div class="addHistoryInput">
            <h2>Create a record of the update</h2>
            <div class="titleInput">
              <label for="titleInputBox">Title:</label>
              <input
                type="text"
                id="titleInputBox"
                name="titleInputBox"
                v-model="title"
              />
              <span v-if="errors.title" class="validationErrors">{{
                errors.title
              }}</span>
            </div>
            <div class="reasonInput">
              <label for="reasonInputBox">Reason:</label>
              <input
                type="text"
                id="reasonInputBox"
                name="reasonInputBox"
                v-model="reason"
              />
              <span v-if="errors.reason" class="validationErrors">{{
                errors.reason
              }}</span>
            </div>
          </div>
          <div class="centred">
            <button type="submit" class="abutton">Add points</button>
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
import { useRouter, useRoute } from "vue-router";
import Navbar from "./Navbar.vue";

const authStore = useAuthStore();

const router = useRouter();

const route = useRoute();

const id = route.params.id;

const friend = ref([]);

const errors = ref([]);

const addedPoints = ref();

const title = ref("");

const reason = ref("");

const before = ref();

const after = ref();

const change = ref();

onMounted(() => {
  console.log("addPoints component running");

  // Get the token from local storage
  const token = localStorage.getItem("token");

  if (token) {
    authStore.setToken(token);
    authStore.fetchUser();
    getFriend();
  } else if (token === null) {
    router.push("/home");
  }
});

// getFriend method - retrieves a specified record from the friend table when it runs
const getFriend = async () => {
  try {
    const response = await axios.get(`http://127.0.0.1:8000/api/${id}/show`, {
      headers: { Authorization: `Bearer ${authStore.token}` },
    });

    console.log("Friend retrieved from database");

    friend.value = response.data.friend;
  } catch (error) {
    console.log("An error has occurred");
  }
};

// addPoints method - adds points to the user and then creates a history record of why they got points
const addPoints = async () => {
  try {
    const addPointsResponse = await axios.put(
      `http://127.0.0.1:8000/api/${id}/addPoints`,
      {
        // Pass the value of addedPoints in the points parameter
        points: addedPoints.value,
      },
      { headers: { Authorization: `Bearer ${authStore.token}` } }
    );
    console.log("Added the points to the user");
    console.log(addPointsResponse.data);
    // Create a constant called before and set it to the before value returned in the response
    before.value = addPointsResponse.data.before;
    // Create a constant called after and set it to the after value returned in the response
    after.value = addPointsResponse.data.after;
    // Create a constant called change and set it to the change value returned in the response
    change.value = addPointsResponse.data.change;
  } catch (error) {
    console.log("An error has occurred".error);
    errors.value = error.response.data.errors;
  }
  try {
    const historyResponse = await axios.post(
      `http://127.0.0.1:8000/api/history/${id}/store`,
      {
        // Pass the value of title in the title parameter
        title: title.value,
        // Pass the value of reason in the reason parameter
        reason: reason.value,
        // Pass the value of before in the before parameter
        before: before.value,
        // Pass the value of after in the after parameter
        after: after.value,
        // Pass the value of change in the change parameter
        change: change.value,
      },
      { headers: { Authorization: `Bearer ${authStore.token}` } }
    );
    console.log("Created the historical record for the update");

    // Wait for 2 seconds
    console.log("Sending the user to the showFriend component");
    setTimeout(() => {
      router.push(`/showFriend/${id}`);
    }, 2000);
  } catch (error) {
    console.log("An error has occurred".error);
    errors.value = error.response.data.errors;
  }
};
</script>

<style scoped>
.topscreen {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  font-size: 1.2rem;
  margin-bottom: 10px;
}

.title {
  text-align: center;
}

.mainArea {
  margin-top: 10px;
}

.friendInformation {
  margin-top: 10px;
  padding-top: 10px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  text-align: center;
}

.addPointsArea {
  margin-top: 10px;
  padding-top: 10px;
}

.addPointsInput {
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
}

.addPointsInput > * {
  margin-left: 5px;
  margin-right: 5px;
}

.addHistoryInput {
  margin-top: 10px;
  margin-bottom: 10px;
  text-align: center;
  font-size: 1.2rem;
}

.titleInput {
  margin-top: 10px;
  margin-bottom: 10px;
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
}

.titleInput > * {
  margin-left: 5px;
  margin-right: 5px;
}

.reasonInput {
  margin-top: 10px;
  margin-bottom: 10px;
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
}

.reasonInput > * {
  margin-left: 5px;
  margin-right: 5px;
}

.centred {
  margin-top: 5px;
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
}

.abutton {
  border-radius: 15%;
  border: none;
  background-color: #10b981;
}

#blackText {
  color: black;
}

.navbar {
  margin-bottom: 10px;
}
</style>
