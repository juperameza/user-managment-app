/**
 * main.ts
 *
 * Bootstraps Vuetify and other plugins then mounts the App`
 */

// Plugins
import { registerPlugins } from '@/plugins'

// Components
import App from './App.vue'

// Composables
import { createApp } from 'vue'

import axios from 'axios';

axios.defaults.baseURL="http://127.0.0.1"
const app = createApp(App)

registerPlugins(app)

app.mount('#app')
