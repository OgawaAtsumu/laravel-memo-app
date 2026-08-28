<script setup>
const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },

    form: {
        type: Object,
        required: true,
    },

    formErrors: {
        type: Object,
        required: true,
    },

    isSubmitting: {
        type: Boolean,
        default: false,
    },

    isEditing: {
        type: Boolean,
        default: false,
    },

    successMessage: {
        type: String,
        default: '',
    },
});

const emit = defineEmits([
    'update:form',
    'submit',
    'cancel',
]);

const updateField = (field, value) => {
    emit('update:form', {
        ...props.form,
        [field]:value,
    });
};
</script>
<template>
    <section class="memo-form-section">
        <h2>
            {{ isEditing ? 'メモ編集' : 'メモ新規登録' }}
        </h2>

        <p
            v-if="successMessage"
            class="success-message"
        >
            {{ successMessage }}
        </p>

        <form @submit.prevent="emit('submit')">
            <div class="form-group">
                <label for="category_id">
                    カテゴリ
                </label>

                <select
                    id="category_id"
                    :value="form.category_id"
                    @change="
                        updateField(
                            'category_id',
                            $event.target.value
                        )
                    "
                >
                    <option value="">
                        カテゴリを選択してください
                    </option>

                    <option
                        v-for="category in categories"
                        :key="category.id"
                        :value="category.id"
                    >
                        {{ category.name }}
                    </option>
                </select>

                <p
                    v-if="formErrors.category_id"
                    class="field-error"
                >
                    {{ formErrors.category_id[0] }}
                </p>
            </div>

            <div class="form-group">
                <label for="memo-title">
                    タイトル
                </label>

                <input
                    id="memo-title"
                    :value="form.title"
                    type="text"
                    @input="
                        updateField(
                            'title',
                            $event.target.value
                        )
                    "
                >

                <p
                    v-if="formErrors.title"
                    class="field-error"
                >
                    {{ formErrors.title[0] }}
                </p>
            </div>

            <div class="form-group">
                <label for="memo-content">
                    内容
                </label>

                <textarea
                    id="memo-content"
                    :value="form.content"
                    @input="
                        updateField(
                            'content',
                            $event.target.value
                        )
                    "
                ></textarea>

                <p
                    v-if="formErrors.content"
                    class="field-error"
                >
                    {{ formErrors.content[0] }}
                </p>
            </div>

            <div class="form-buttons">
                <button
                    type="submit"
                    class="submit-button"
                    :disabled="isSubmitting"
                >
                    <template v-if="isSubmitting">
                        {{ isEditing ? '更新中...' : '登録中...' }}
                    </template>

                    <template v-else>
                        {{ isEditing ? '更新する' : '登録する' }}
                    </template>
                </button>

                <button
                    v-if="isEditing"
                    type="button"
                    class="cancel-button"
                    :disabled="isSubmitting"
                    @click="emit('cancel')"
                >
                    キャンセル
                </button>
            </div>
        </form>
    </section>
</template>
<style scoped>
.memo-form-section {
    max-width: 900px;
    margin: 30px auto;
    padding: 24px;
    border: 1px solid #dbe3e8;
    border-radius: 8px;
    background-color: white;
    color: #2c3e50;
}

.memo-form-section h2 {
    margin-top: 0;
}

.form-group {
    margin-bottom: 18px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 10px;
    box-sizing: border-box;
    border: 1px solid #aeb6bf;
    border-radius: 6px;
    font-size: 16px;
}

.form-group textarea {
    min-height: 120px;
    resize: vertical;
}

.form-buttons {
    display: flex;
    align-items: center;
    gap: 10px;
}

.submit-button,
.cancel-button {
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    color: white;
    font-size: 15px;
    cursor: pointer;
}

.submit-button {
    background-color: #2ecc71;
}

.submit-button:hover:not(:disabled) {
    background-color: #27ae60;
}

.cancel-button {
    background-color: #95a5a6;
}

.cancel-button:hover:not(:disabled) {
    background-color: #7f8c8d;
}

.submit-button:disabled,
.cancel-button:disabled {
    cursor: not-allowed;
    opacity: 0.6;
}

.success-message {
    padding: 12px;
    border-radius: 6px;
    background-color: #eafaf1;
    color: #27864f;
}

.field-error {
    margin: 6px 0 0;
    color: #c0392b;
    font-size: 14px;
}
</style>