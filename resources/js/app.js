// Imports
import './bootstrap';
import "vue-toastification/dist/index.css";
import { createApp } from 'vue';
import Toast from "vue-toastification";
import ContactComponent from './components/ContactComponent.vue';
import HomeComponent from './components/HomeComponent.vue';

// Create app
const app = createApp({});

// Add Toastification
app.use(Toast, {
    position: 'top-center',
    closeButton: false,
    transition: "Vue-Toastification__fade",
});

// Register components
app.component('contact-component', ContactComponent);
app.component('home-component', HomeComponent);

// Mount app
app.mount('#app');
