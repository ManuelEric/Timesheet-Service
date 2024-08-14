import App from '@/App.vue';
import VueCountdown from '@chenfengyuan/vue-countdown';
import { registerPlugins } from '@core/utils/plugins';
import moment from 'moment';
import { Calendar, DatePicker, setupCalendar } from 'v-calendar';
import { createApp } from 'vue';
import { VDateInput } from 'vuetify/labs/VDateInput';

// Styles
import '@core-scss/template/index.scss';
import '@layouts/styles/index.scss';
import 'v-calendar/style.css';

// Create vue app
const app = createApp(App)
app.use(setupCalendar, {})
// Use the components
app.component('VDateInput', VDateInput)
app.component('VCCalendar', Calendar)
app.component('VCDatePicker', DatePicker)
app.component(VueCountdown.name, VueCountdown);

// Register plugins
registerPlugins(app)

app.config.globalProperties.$moment=moment;

// Turn Off Warning Log 
app.config.warnHandler = function (msg, vm, trace) {
    return null
  }

// Mount vue app
app.mount('#app')
