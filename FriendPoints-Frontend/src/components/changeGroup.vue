<template>
  <div class="navbar">
    <Navbar />
  </div>
  <div>
    <div class="topscreen">
      <button class="abutton">
        <router-link id="blackText" to="/home">Home</router-link>
      </button>
      <h1 id="title">Change Group</h1>
    </div>
    <div class="mainArea">
      <div class="friendInformation">
        <p>Name: {{ friend.first_name }} {{ friend.last_name }}</p>
        <p>Current Group: {{ friend.group }}</p>
      </div>
      <form @submit.prevent="changeGroup">
        <div class="groupChangeArea">
          <label for="groupChangeDropdown"
            >Select the group you want to put the friend in:</label
          >
          <select
            name="groupChangeDropdown"
            id="groupChangeDropdown"
            v-model="newGroup"
          >
            <option disabled value="">Select a group</option>
            <option
              v-for="group in availableGroups"
              :key="group"
              :value="group"
            >
              {{ group }}
            </option>
          </select>
          <span v-if="validationErrors.group" class="validationErrors">{{
            validationErrors.group
          }}</span>
        </div>
        <div class="submitButton">
          <button class="abutton">Change group</button>
          <span v-if="success">{{ success }}</span>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import { useAuthStore } from "@/stores/auth";
import axios from "axios";
import { useRoute, useRouter } from "vue-router";
import Navbar from "./Navbar.vue";

const authStore = useAuthStore();

const router = useRouter();

const route = useRoute();

const newGroup = ref("");

const id = route.params.id;

const friend = ref([]);

const validationErrors = ref([]);

const credentialsError = ref([]);

const success = ref("");

const groups = ref(["group1", "group2", "both"]);

const availableGroups = computed(() => {
  // Guard for inital render
  const current = friend.value.group ?? "";
  return groups.value.filter((g) => g !== current);
});

onMounted(() => {
  const token = localStorage.getItem("token");

  if (token) {
    console.log("Change group component mounted");
    authStore.setToken(token);
    authStore.fetchUser();
    getFriend();
  } else if (token === null) {
    router.push("/home");
  }
});

const getFriend = async () => {
  try {
    const response = await axios.get(`http://127.0.0.1:8000/api/${id}/show`, {
      headers: { Authorization: `Bearer ${authStore.token}` },
    });
    console.log("Friend retrieved from database");

    friend.value = response.data.friend;
  } catch (error) {
    console.log("An error has occurred: ".error);
  }
};

const changeGroup = async () => {
  try {
    const response = await axios.put(
      `http://127.0.0.1:8000/api/${id}/update`,
      {
        group: newGroup.value,
      },
      {
        headers: {
          Authorization: `Bearer ${authStore.token}`,
        },
      }
    );

    console.log(
      "Group updated, returning to viewFriend component in 2 seconds"
    );

    success.value = response.data.success;
    setTimeout(() => {
      router.push(`/showFriend/${id}`);
    }, 2000);
  } catch (error) {
    console.log("An error has occurred: ".error);

    if (error.response && error.response.status === 422) {
      validationErrors.value = errors.response.data.errors;
    } else if (error.response && error.response.status === 401) {
      credentialsError.value = errors.response.data.errors;
    }
  }
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

.mainArea {
  margin-top: 10px;
  margin-bottom: 10px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.mainArea > * {
  margin-top: 5px;
  margin-bottom: 5px;
  padding-left: 5px;
  padding-right: 5px;
}

.friendInformation {
  padding-top: 10px;
  padding-bottom: 10px;
}

.abutton {
  border-radius: 15%;
  border: none;
  background-color: #10b981;
}

.submitButton {
  margin-top: 10px;
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
}

.groupChangeArea > * {
  margin-left: 10px;
  margin-right: 10px;
}

#blackText {
  color: black;
}

.navbar {
  margin-bottom: 10px;
}
</style>
