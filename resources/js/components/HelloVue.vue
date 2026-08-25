<script setup>
const message = 'Vue.jsの表示に成功しました！';
const mountedMessage = ref('');
import { computed , onMounted , ref , watch } from 'vue';
import TechnologyItem from './TechnologyItem.vue';

const count = ref(0);
const name = ref('');
const nameChangeMessage = ref('');
const technologies = ref([
    'Laravel',
    'Vue.js',
    'MySQL',
    'Git',
    'HTML / CSS',
]);
const isLoading = ref(false);
const loadMessage = ref('');
const loadError = ref('');

const technologyCount = computed(() => {
    return technologies.value.length;
});

const newTechnology = ref('');

onMounted(() => {
    mountedMessage.value = 'Vueコンポーネントが表示されました。';
});

watch(name, (newValue, oldValue) => {
    if (newValue === oldValue) { return;}
    nameChangeMessage.value = '入力内容が変更されました。';
});

const increment = () => {
    count.value++;
};
const decrement = () => {
    count.value--;
};
const reset = () => {
    count.value = 0;
};

const addTechnology = () => {
    const technology = newTechnology.value.trim();
    if (!technology) {return;}
    technologies.value.push(technology);
    newTechnology.value = '';
};

const removeTechnology = (index) => {
    technologies.value.splice(index, 1);
};
const wait = (milliseconds) => {
    return new Promise((resolve) => {
        setTimeout(resolve, milliseconds);
});
};

const loadData = async (shouldFail = false) => {
    isLoading.value = true;
    loadMessage.value = '';
    loadError.value = '';

    try {
        await wait(2000);

        if (shouldFail) {
            throw new Error('データの読み込みに失敗しました。');
        }

        loadMessage.value = 'データの読み込みが完了しました。';
    } catch (error) {
        loadError.value = error.message;
    } finally {
        isLoading.value = false;
    }
};



</script>

<template>
    <div class="vue-message">
        <h2>{{ message }}</h2>

        <p
            v-if="mountedMessage"
            class="mounted-message"
        >
            {{ mountedMessage }}
        </p>

        <p>
            LaravelとVue.jsが正常に連携しています。
        </p>

        <div class="counter-area">
            <p class="count-display">
                カウント：{{ count }}
            </p>

            <div class="counter-buttons">
                <button type="button" @click="increment">
                    増やす
                </button>

                <button type="button" @click="decrement">
                    減らす
                </button>

                <button type="button" @click="reset">
                    リセット
                </button>
            </div>
        </div>

        <div class="name-area">
            <label for="name">
                名前
            </label>

            <input
                id="name"
                v-model="name"
                type="text"
                placeholder="名前を入力してください"
            >

            <p v-if="name.trim()" class="greeting">
                こんにちは、{{ name }}さん！
            </p>
            <p v-else class="empty-message">
            名前を入力してください。
            </p>
            <p
                v-if="nameChangeMessage"
                class="change-message"
            >
                {{ nameChangeMessage }}
            </p>
        </div>

        <div class="technology-area">
            <h3>学習中の技術</h3>
            <p class="technology-count">
                登録件数：{{ technologyCount }}件
            </p>

            <div class="technology-form">
                <input
                    v-model="newTechnology"
                    type="text"
                    placeholder="追加する技術名"
                    @keyup.enter="addTechnology"
                >

                <button
                    type="button"
                    @click="addTechnology"
                >
                    追加
                </button>
            </div>

            <ul
                v-if="technologies.length > 0"
                class="technology-list"
            >
                <TechnologyItem
                    v-for="(technology, index) in technologies"
                    :key="`${technology}-${index}`"
                    :technology="technology"
                    @remove="removeTechnology(index)"
                />
            </ul>

            <p v-else class="empty-message">
                学習中の技術はありません。
            </p>
        </div>
        <div class="async-area">
    <h3>非同期処理の確認</h3>

    <div class="async-buttons">
        <button
            type="button"
            class="load-button"
            :disabled="isLoading"
            @click="loadData(false)"
        >
            正常に読み込む
        </button>

        <button
            type="button"
            class="error-button"
            :disabled="isLoading"
            @click="loadData(true)"
        >
            エラーを発生させる
        </button>
    </div>

    <p
        v-if="isLoading"
        class="loading-message"
    >
        データを読み込んでいます...
    </p>

    <p
        v-else-if="loadError"
        class="load-error-message"
    >
        {{ loadError }}
    </p>

    <p
        v-else-if="loadMessage"
        class="load-complete-message"
    >
        {{ loadMessage }}
    </p>
</div>
    </div>
</template>

<style scoped>
.vue-message {
    padding: 20px;
    border: 2px solid #42b883;
    border-radius: 8px;
    background-color: #f0fff8;
    color: #2c3e50;
}

.vue-message h2 {
    margin-top: 0;
    color: #42b883;
}

.counter-area {
    margin-top: 25px;
    padding-top: 20px;
    border-top: 1px solid #b8dfcd;
}

.count-display {
    margin: 0 0 15px;
    font-size: 22px;
    font-weight: bold;
}

.counter-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.counter-buttons button {
    padding: 10px 18px;
    border: none;
    border-radius: 6px;
    background-color: #42b883;
    color: white;
    font-size: 15px;
    cursor: pointer;
}

.counter-buttons button:hover {
    background-color: #369b70;
}

.name-area {
    margin-top: 25px;
    padding-top: 20px;
    border-top: 1px solid #b8dfcd;
}

.name-area label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

.name-area input {
    width: 100%;
    padding: 10px;
    box-sizing: border-box;
    border: 1px solid #aeb6bf;
    border-radius: 6px;
    font-size: 16px;
}

.greeting {
    margin: 15px 0 0;
    font-size: 18px;
    font-weight: bold;
    color: #2c3e50;
}

.empty-message {
    margin: 15px 0 0;
    color: #7f8c8d;
    font-size: 15px;
}

.technology-area {
    margin-top: 25px;
    padding-top: 20px;
    border-top: 1px solid #b8dfcd;
}

.technology-area h3 {
    margin: 0 0 15px;
    color: #2c3e50;
}

.technology-area ul {
    margin: 0;
    padding-left: 22px;
}

.technology-area li {
    margin-bottom: 8px;
    color: #34495e;
}

.technology-form {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
}

.technology-form input {
    flex: 1;
    padding: 10px;
    box-sizing: border-box;
    border: 1px solid #aeb6bf;
    border-radius: 6px;
    font-size: 16px;
}

.technology-form button {
    padding: 10px 18px;
    border: none;
    border-radius: 6px;
    background-color: #3498db;
    color: white;
    font-size: 15px;
    cursor: pointer;
}

.technology-form button:hover {
    background-color: #2980b9;
}

.technology-list {
    margin: 0;
    padding: 0;
    list-style: none;
}

.technology-count {
    margin: 0 0 15px;
    color: #5d6d7e;
    font-size: 14px;
    font-weight: bold;
}

.change-message {
    margin: 10px 0 0;
    padding: 8px 10px;
    background-color: #fff3cd;
    color: #856404;
    border-radius: 6px;
    font-size: 14px;
}
.mounted-message {
    margin: 0 0 15px;
    padding: 10px 12px;
    background-color: #eaf2fb;
    color: #2471a3;
    border-radius: 6px;
    font-size: 14px;
}

.async-area {
    margin-top: 25px;
    padding-top: 20px;
    border-top: 1px solid #b8dfcd;
}

.async-area h3 {
    margin: 0 0 15px;
    color: #2c3e50;
}

.load-button {
    padding: 10px 18px;
    border: none;
    border-radius: 6px;
    background-color: #8e44ad;
    color: white;
    font-size: 15px;
    cursor: pointer;
}

.load-button:hover:not(:disabled) {
    background-color: #71368a;
}

.load-button:disabled {
    cursor: not-allowed;
    opacity: 0.6;
}

.loading-message {
    margin: 15px 0 0;
    color: #8e44ad;
    font-weight: bold;
}

.load-complete-message {
    margin: 15px 0 0;
    padding: 10px 12px;
    background-color: #eafaf1;
    color: #27864f;
    border-radius: 6px;
    font-weight: bold;
}


.async-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.error-button {
    padding: 10px 18px;
    border: none;
    border-radius: 6px;
    background-color: #e74c3c;
    color: white;
    font-size: 15px;
    cursor: pointer;
}

.error-button:hover:not(:disabled) {
    background-color: #c0392b;
}

.error-button:disabled {
    cursor: not-allowed;
    opacity: 0.6;
}

.load-error-message {
    margin: 15px 0 0;
    padding: 10px 12px;
    background-color: #fdecea;
    color: #c0392b;
    border-radius: 6px;
    font-weight: bold;
}
</style>