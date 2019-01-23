import Vue from 'vue'
import App from './App.vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import Create from "./views/Create";
import View from "./views/View";
import ViewLive from "./views/ViewLive";
import BootstrapVue from 'bootstrap-vue'
import VueGoogleCharts from 'vue-google-charts'
import Config from '../api-config'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(VueGoogleCharts)
Vue.use(BootstrapVue);
Vue.use(VueRouter)
Vue.use(VueAxios, axios)

Vue.config.productionTip = false

Vue.prototype.$_config = Config;

const routes = [
  { path: '/', component: Create },
  { path: '/view/:url_key', component: View },
  { path: '/view/live/:url_key', component: ViewLive }
];

const router = new VueRouter({
  routes
});

new Vue({
  router,
  render: h => h(App),
}).$mount('#app')
