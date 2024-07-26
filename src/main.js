import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import vuetify from './plugins/vuetify';
import axios from 'axios';

axios.defaults.baseURL = 'http://localhost:8000/api';

const app = createApp(App);

// Use router and Vuetify plugins
app.use(router);
app.use(vuetify);

// Mount Vue app
app.mount('#app');

