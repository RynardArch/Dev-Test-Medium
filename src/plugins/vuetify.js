// src/plugins/vuetify.js
import 'vuetify/styles'; // Global CSS has to be imported
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import '@mdi/font/css/materialdesignicons.css'

export default createVuetify({
  components,
  directives,
  icons: {
    iconfont: 'mdi', // This specifies the use of Material Design Icons
  },
});
