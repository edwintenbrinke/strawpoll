import Vue from 'vue'
import App from './App.vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import Create from "./views/Create";
import View from "./views/View";
import BootstrapVue from 'bootstrap-vue'
import VueGoogleCharts from 'vue-google-charts'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import ViewLive from "./views/ViewLive";

Vue.use(VueGoogleCharts)
Vue.use(BootstrapVue);
Vue.use(VueRouter)
Vue.use(VueAxios, axios)

Vue.config.productionTip = false


const routes = [
  { path: '/', component: Create },
  { path: '/view/:url_key', component: View },
  { path: '/view/live/:url_key', component: ViewLive }
]

const router = new VueRouter({
  routes
})



new Vue({
  router,
  render: h => h(App),
}).$mount('#app')
