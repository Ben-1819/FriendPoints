import "./assets/main.css";

import { createApp } from "vue";
import { createPinia } from "pinia";
import { createRouter, createWebHistory } from "vue-router";
import axios from "axios";
import App from "./App.vue";

window.axios = axios;

const router = createRouter({
  history: createWebHistory(),
  routes: [],
});
createApp(App).use(createPinia()).mount("#app");
