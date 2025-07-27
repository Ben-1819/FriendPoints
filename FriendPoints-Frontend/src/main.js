import "./assets/main.css";

import { createApp } from "vue";
import { createPinia } from "pinia";
import { createRouter, createWebHistory } from "vue-router";
import axios from "axios";
import App from "./App.vue";
import Register from "./components/Register.vue";
import Login from "./components/Login.vue";

const app = createApp(App);
const pinia = createPinia();

window.axios = axios;

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: "/register", component: Register },
    { path: "/login", component: Login },
  ],
});
app.use(pinia).use(router).mount("#app");
