import Vue from "vue";
import VueRouter from "vue-router";

import Home from "./components/Home";

Vue.use(VueRouter);

const routes = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            name: "home",
            component: Home
        }
    ]
})

export default routes;
