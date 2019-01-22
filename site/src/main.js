import Vue from 'vue'
import App from './App.vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import HelloWorld from "./components/HelloWorld";
import View from "./components/View";
import BootstrapVue from 'bootstrap-vue'
import VueGoogleCharts from 'vue-google-charts'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(VueGoogleCharts)
Vue.use(BootstrapVue);
Vue.use(VueRouter)
Vue.use(VueAxios, axios)

Vue.config.productionTip = false


const routes = [
  { path: '/', component: HelloWorld },
  { path: '/view/:url_key', component: View }
]

const router = new VueRouter({
  routes
})



new Vue({
  router,
  render: h => h(App),
}).$mount('#app')
