<template>
  <div class="navbar">
    <Navbar />
  </div>
  <div>
    <div class="topscreen">
      <h1 class="title">Remove Points</h1>
    </div>
    <div class="mainArea">
      <div class="friendInformation">
        <p>Name: {{ friend.first_name }} {{ friend.last_name }}</p>
        <p>Points: {{ friend.points }}</p>
      </div>
      <div class="removePointsArea">
        <form @submit.prevent="removePoints">
          <div class="removePointsInput">
            <label for="pointsInput">Amount of points to remove</label>
            <input
              type="number"
              id="pointsInput"
              name="pointsInput"
              v-model="removedPoints"
            />
            <span v-if="errors.point" class="validationErrors">{{
              errors.points
            }}</span>
          </div>
          <div class="addHistoryInput">
            <h2>Create A Record Of The Update</h2>
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
            <button type="submit" class="abutton">Remove Points</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useAuthStore } from "@/stores/auth";
import axios from "axios";
import { useRouter, useRoute } from "vue-router";
import Navbar from "./Navbar.vue";

const authStore = useAuthStore();

const router = useRouter();

const route = useRoute();

const id = route.params.id;

const friend = ref([]);

const errors = ref([]);

const removedPoints = ref();

const title = ref("");

const reason = ref("");

const before = ref();

const after = ref();

const change = ref();

onMounted(() => {
  const token = localStorage.getItem("token");

  if (token) {
    authStore.setToken(token);
    authStore.fetchUser();
    getFriend();
  } else if (token === null) {
    logout();
  }
});

// getFriend method - Gets the specified friends record from the database
const getFriend = async () => {
  try {
    const response = await axios.get(`http://127.0.0.1:8000/api/${id}/show`, {
      headers: { Authorization: `Bearer ${authStore.token}` },
    });
    console.log("Friend successfully retrieved");

    friend.value = response.data.friend;
  } catch (error) {
    console.log("An error has occurred ".error);
    errors.value = error.response.data.errors;
  }
};

// removePoints method - removes points from the specified friend and creates a historical record of why
const removePoints = async () => {
  try {
    const removedPointsResponse = await axios.put(
      `http://127.0.0.1:8000/api/${id}/removePoints`,
      {
        points: removedPoints.value,
      },
      {
        headers: {
          Authorization: `Bearer ${authStore.token}`,
        },
      }
    );
    console.log("Points successfully removed");

    before.value = removedPointsResponse.data.before;

    after.value = removedPointsResponse.data.after;

    change.value = removedPointsResponse.data.change;
  } catch (error) {
    console.log("An error has occurred: ".error);
  }
  try {
    const historyResponse = await axios.post(
      `http://127.0.0.1:8000/api/history/${id}/store`,
      {
        title: title.value,
        reason: reason.value,
        before: before.value,
        after: after.value,
        change: change.value,
      },
      {
        headers: {
          Authorization: `Bearer ${authStore.token}`,
        },
      }
    );
    console.log("Historical record created");

    // Wait for 2 seconds
    console.log("Sending the user to the showFriendComponent");
    setTimeout(() => {
      router.push(`/showFriend/${id}`);
    }, 2000);
  } catch (error) {
    console.log("An error has occurred: ".error);
  }
};

const logout = () => {
  authStore.logout();
  router.push({
    name: "Login",
  });
};
</script>

<style scoped>
.topscreen {
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  font-size: 1.2rem;
  margin-bottom: 10px;
}

#title {
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
