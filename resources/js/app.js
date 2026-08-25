import './bootstrap';

import { createApp } from 'vue';
import HelloVue from './components/HelloVue.vue';

const vueElement = document.getElementById('vue-app');

if (vueElement) {
createApp(HelloVue).mount(vueElement);
}