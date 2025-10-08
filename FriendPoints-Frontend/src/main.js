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
import addPoints from "./components/addPoints.vue";
import removePoints from "./components/removePoints.vue";
import changeGroup from "./components/changeGroup.vue";
import deleteFriend from "./components/deleteFriend.vue";
import showFriend from "./components/showFriend.vue";
import AllHistory from "./components/AllHistory.vue";
import ShowHistory from "./components/ShowHistory.vue";
import FriendHistories from "./components/FriendHistories.vue";
import EditHistory from "./components/EditHistory.vue";

const app = createApp(App);
const pinia = createPinia();

window.axios = axios;

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: "/register",
      name: "Register",
      component: Register,
    },
    { path: "/login", name: "Login", component: Login },
    { path: "/home", name: "Home", component: Home },
    { path: "/users", name: "Users", component: allUsers },
    {
      path: "/addFriend/:id",
      name: "AddFriend",
      component: addFriend,
      props: true,
    },
    { path: "/friendMenu", name: "FriendMenu", component: friendMenu },
    { path: "/allFriends", name: "AllFriends", component: allFriends },
    { path: "/group1Friends", name: "Group1Friends", component: group1Friends },
    {
      path: "/editFriendMenu/:id",
      name: "EditFriendMenu",
      component: editFriendMenu,
      props: true,
    },
    {
      path: "/addPoints/:id",
      name: "AddPoints",
      component: addPoints,
      props: true,
    },
    {
      path: "/removePoints/:id",
      name: "RemovePoints",
      component: removePoints,
      props: true,
    },
    {
      path: "/changeGroup/:id",
      name: "ChangeGroup",
      component: changeGroup,
      props: true,
    },
    {
      path: "/deleteFriend/:id",
      name: "DeleteFriend",
      component: deleteFriend,
      props: true,
    },
    {
      path: "/showFriend/:id",
      name: "ShowFriend",
      component: showFriend,
      props: true,
    },
    { path: "/allHistory/", name: "AllHistory", component: AllHistory },
    {
      path: "/showHistory/:id",
      name: "ShowHistory",
      component: ShowHistory,
      props: true,
    },
    {
      path: "/friendHistories/:id",
      name: "FriendHistories",
      component: FriendHistories,
      props: true,
    },
    {
      path: "/editHistory/:id",
      name: "EditHistory",
      component: EditHistory,
      props: true,
    },
  ],
});
app.use(pinia).use(router).mount("#app");
