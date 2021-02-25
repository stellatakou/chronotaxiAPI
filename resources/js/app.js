/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./bootstrap');

import Vue from "vue";
import Vuetify from "vuetify";

import routes from "./router.js";
import App from "./views/App";

Vue.use(Vuetify);

const app = new Vue({
    el: "#app",
    routes: routes,
    render: h => h(App)
})

export default app;
