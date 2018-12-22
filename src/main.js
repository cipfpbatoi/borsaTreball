import Vue from 'vue'
import axios from 'axios'
import './plugins/vuetify'
import App from './App.vue'
import router from './router'

Vue.config.productionTip = false

// Para pasar siempre el token en las peticiones axios
const USERAUTH = sessionStorage.getItem('user-data')
if (USERAUTH) {
  axios.defaults.headers.common['Authorization'] = JSON.parse(USERAUTH).token;
}

new Vue({
  router,
  render: h => h(App)
}).$mount('#app')
