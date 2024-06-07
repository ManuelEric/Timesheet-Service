import App from '@/App.vue';
import { registerPlugins } from '@core/utils/plugins';
import { Calendar, DatePicker, setupCalendar } from 'v-calendar';
import { createApp } from 'vue';

// Styles
import '@core-scss/template/index.scss';
import '@layouts/styles/index.scss';
import 'v-calendar/style.css';

// Create vue app
const app = createApp(App)
app.use(setupCalendar, {})

// Use the components
app.component('VCCalendar', Calendar)
app.component('VCDatePicker', DatePicker)

// Register plugins
registerPlugins(app)

// Mount vue app
app.mount('#app')
