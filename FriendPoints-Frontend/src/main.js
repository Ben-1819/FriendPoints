import "./assets/main.css";

import { createApp } from "vue";
import { createPinia } from "pinia";
import { createRouter, createWebHistory } from "vue-router";
import axios from "axios";
import App from "./App.vue";
import Register from "./components/Register.vue";
import Login from "./components/Login.vue";
import Home from "./components/Home.vue";
import allUsers from "./components/allUsers.vue";
import addFriend from "./components/addFriend.vue";
import friendMenu from "./components/friendMenu.vue";
import allFriends from "./components/allFriends.vue";
import group1Friends from "./components/group1Friends.vue";
import editFriendMenu from "./components/editFriendMenu.vue";

const app = createApp(App);
const pinia = createPinia();

window.axios = axios;

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: "/register", component: Register },
    { path: "/login", component: Login },
    { path: "/home", component: Home },
    { path: "/users", component: allUsers },
    { path: "/addFriend/:id", component: addFriend, props: true },
    { path: "/friendMenu", component: friendMenu },
    { path: "/allFriends", component: allFriends },
    { path: "/group1Friends", component: group1Friends },
    { path: "/editFriendMenu/:id", component: editFriendMenu, props: true },
  ],
});
app.use(pinia).use(router).mount("#app");
