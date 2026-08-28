<script setup>
import { computed , onMounted, ref } from 'vue';
import axios from 'axios';
import MemoFilter from './MemoFilter.vue';
import MemoCard from './MemoCard.vue';
import MemoForm from './MemoForm.vue';

const memos = ref([]);
const isLoading = ref(false);
const errorMessage = ref('');
const categories = ref([]);
const searchKeyword = ref('');
const selectedCategoryId = ref('');

const form = ref({
    category_id: '',
    title: '',
    content: '',
});

const updateForm = (updatedForm) => {
    form.value = updatedForm;
    };

const editingMemoId = ref(null);
const deletingMemoId = ref(null);

const formErrors = ref({});
const isSubmitting = ref(false);
const successMessage = ref('');

const filteredMemos = computed(() => {
    const keyword = searchKeyword.value
        .trim()
        .toLowerCase();

    return memos.value.filter((memo) => {
        const matchesKeyword =
            !keyword ||
            memo.title.toLowerCase().includes(keyword) ||
            memo.content.toLowerCase().includes(keyword);

        const matchesCategory =
            !selectedCategoryId.value ||
            String(memo.category?.id) ===
                String(selectedCategoryId.value);

        return matchesKeyword && matchesCategory;
    });
});

const clearFilters = () => {
    searchKeyword.value = '';
    selectedCategoryId.value = '';
};

const fetchMemos = async () => {
    isLoading.value = true;
    errorMessage.value = '';

    try {
        const response = await axios.get('/api/memos');

        memos.value = response.data.data;
    } catch (error) {
        console.error(error);

        if (error.response?.status === 401) {
            errorMessage.value = 'ログインが必要です。';
        } else {
            errorMessage.value = 'メモの取得に失敗しました。';
        }
    } finally {
        isLoading.value = false;
    }
};

const fetchCategories = async () => {
    try {
        const response = await axios.get('/api/categories');

        categories.value = response.data.data;
    } catch (error) {
        console.error(error);

        errorMessage.value = 'カテゴリの取得に失敗しました。';
    }
};

const submitForm = () => {
    if (editingMemoId.value === null) {
        createMemo();
        return;
    }

    updateMemo();
};

const startEdit = (memo) => {
    editingMemoId.value = memo.id;

    form.value = {
        category_id: memo.category?.id ?? '',
        title: memo.title,
        content: memo.content,
    };

    formErrors.value = {};
    successMessage.value = '';

    window.scrollTo({
        top: 0,
        behavior: 'smooth',
    });
};

const cancelEdit = () => {
    editingMemoId.value = null;

    form.value = {
        category_id: '',
        title: '',
        content: '',
    };

    formErrors.value = {};
    successMessage.value = '';
};

const updateMemo = async () => {
    isSubmitting.value = true;
    formErrors.value = {};
    successMessage.value = '';
    errorMessage.value = '';

    try {
        await axios.put(`/api/memos/${editingMemoId.value}`, {
            category_id: form.value.category_id,
            title: form.value.title,
            content: form.value.content,
        });

        successMessage.value = 'メモを更新しました。';

        editingMemoId.value = null;

        form.value = {
            category_id: '',
            title: '',
            content: '',
        };

        await fetchMemos();
    } catch (error) {
        console.error(error);

        if (error.response?.status === 422) {
            formErrors.value = error.response.data.errors;
        } else if (error.response?.status === 401) {
            errorMessage.value = 'ログインが必要です。';
        } else if (error.response?.status === 404) {
            errorMessage.value = '更新対象のメモが見つかりません。';
        } else {
            errorMessage.value = 'メモの更新に失敗しました。';
        }
    } finally {
        isSubmitting.value = false;
    };
};

const createMemo = async () => {
    isSubmitting.value = true;
    formErrors.value = {};
    successMessage.value = '';

    try {
        await axios.post('/api/memos', {
            category_id: form.value.category_id,
            title: form.value.title,
            content: form.value.content,
        });

        successMessage.value = 'メモを登録しました。';

        form.value = {
            category_id: '',
            title: '',
            content: '',
        };

        await fetchMemos();
    } catch (error) {
        console.error(error);

        if (error.response?.status === 422) {
            formErrors.value = error.response.data.errors;
        } else if (error.response?.status === 401) {
            errorMessage.value = 'ログインが必要です。';
        } else {
            errorMessage.value = 'メモの登録に失敗しました。';
        }
    } finally {
        isSubmitting.value = false;
    };
    }

    const deleteMemo = async (memo) => {
        const confirmed = window.confirm(
            `「${memo.title}」を削除しますか？`
        );

        if (!confirmed) {
            return;
        }

        deletingMemoId.value = memo.id;
        successMessage.value = '';
        errorMessage.value = '';

        try {
            await axios.delete(`/api/memos/${memo.id}`);

            if (editingMemoId.value === memo.id) {
                editingMemoId.value = null;

                form.value = {
                    category_id: '',
                    title: '',
                    content: '',
                };

                formErrors.value = {};
            }

            successMessage.value = 'メモを削除しました。';

            await fetchMemos();  
        } catch (error) {
            console.error(error);

            if (error.response?.status === 401) {
                errorMessage.value = 'ログインが必要です。';
            } else if (error.response?.status === 404) {
                errorMessage.value = '削除対象のメモが見つかりません。';
            } else {
                errorMessage.value = 'メモの削除に失敗しました。';
            }
        } finally {
            deletingMemoId.value = null;
        }
};

onMounted(() => {
    fetchMemos();
    fetchCategories();
});

</script>

<template>
<MemoForm
    :categories="categories"
    :form="form"
    :form-errors="formErrors"
    :is-submitting="isSubmitting"
    :is-editing="editingMemoId !== null"
    :success-message="successMessage"
    @update:form="updateForm"
    @submit="submitForm"
    @cancel="cancelEdit"
/>

    <section class="memo-list">
        <div class="memo-list-header">
                        <div>
                <h2>Vue.js メモ一覧</h2>
                <p>Laravel APIから取得したメモです。</p>
            </div>

            <button
                type="button"
                class="reload-button"
                :disabled="isLoading"
                @click="fetchMemos"
            >
                {{ isLoading ? '読み込み中...' : '再読み込み' }}
            </button>
        </div>
        <MemoFilter
            v-model:search-keyword="searchKeyword"
            v-model:selected-category-id="selectedCategoryId"
            :categories="categories"
            :total-count="memos.length"
            :filtered-count="filteredMemos.length"
            @clear="clearFilters"
        />

        <p v-if="isLoading" class="loading-message">
            メモを読み込んでいます...
        </p>

        <p v-else-if="errorMessage" class="error-message">
            {{ errorMessage }}
        </p>

        <p
            v-else-if="filteredMemos.length === 0"
            class="empty-message"
        >
            検索条件に一致するメモはありません。
        </p>
        <div v-else class="memo-grid">
            <MemoCard
                v-for="memo in filteredMemos"
                :key="memo.id"
                :memo="memo"
                :is-deleting="deletingMemoId === memo.id"
                @edit="startEdit(memo)"
                @delete="deleteMemo(memo)"
            />
        </div>
    </section>
</template>

<style scoped>
.memo-list {
    max-width: 900px;
    margin: 30px auto;
    padding: 24px;
    color: #2c3e50;
}

.memo-list-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    margin-bottom: 24px;
}

.memo-list-header h2 {
    margin: 0 0 6px;
}

.memo-list-header p {
    margin: 0;
    color: #667085;
}

.reload-button {
    padding: 10px 16px;
    border: none;
    border-radius: 6px;
    background-color: #42b883;
    color: white;
    cursor: pointer;
}

.reload-button:disabled {
    cursor: not-allowed;
    opacity: 0.6;
}

.memo-grid {
    display: grid;
    gap: 16px;
}

.loading-message {
    color: #8e44ad;
    font-weight: bold;
}

.error-message {
    padding: 12px;
    border-radius: 6px;
    background-color: #fdecea;
    color: #c0392b;
}

.empty-message {
    color: #7f8c8d;
}
</style>