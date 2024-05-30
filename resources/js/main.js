import App from '@/App.vue';
import { registerPlugins } from '@core/utils/plugins';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import { createApp } from 'vue';

// Styles
import '@core-scss/template/index.scss';
import '@layouts/styles/index.scss';

// Create vue app
const app = createApp(App)

app.component('VueDatePicker', VueDatePicker);

// Register plugins
registerPlugins(app)

// Mount vue app
app.mount('#app')
