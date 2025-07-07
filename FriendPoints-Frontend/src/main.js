import "./assets/main.css";

import { createApp } from "vue";
import { createPinia } from "pinia";
import axios from "axios";
import App from "./App.vue";

window.axios = axios;
createApp(App).use(createPinia()).mount("#app");
