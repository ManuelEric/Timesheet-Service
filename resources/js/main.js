import App from '@/App.vue';
import { registerPlugins } from '@core/utils/plugins';
import '@vuepic/vue-datepicker/dist/main.css';
import { createApp } from 'vue';

// Styles
import '@core-scss/template/index.scss';
import '@layouts/styles/index.scss';

// Create vue app
const app = createApp(App)

// Register plugins
registerPlugins(app)

// Mount vue app
app.mount('#app')
