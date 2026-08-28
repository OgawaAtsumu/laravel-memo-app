import './bootstrap';

import { createApp } from 'vue';
import HelloVue from './components/HelloVue.vue';
import MemoList from './components/MemoList.vue';

const vueElement = document.getElementById('vue-app');

if (vueElement) {
createApp(HelloVue).mount(vueElement);
}

const memoListElement = document.getElementById('vue-memo-list');

if (memoListElement) {
createApp(MemoList).mount(memoListElement);
}