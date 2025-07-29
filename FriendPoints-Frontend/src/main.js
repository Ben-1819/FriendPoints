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
  ],
});
app.use(pinia).use(router).mount("#app");
