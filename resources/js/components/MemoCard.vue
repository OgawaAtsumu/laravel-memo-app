<script setup>
defineProps({
    memo: {
        type: Object,
        required: true,
    },

    isDeleting: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits([
    'edit',
    'delete',
]);
</script>

<template>
    <article class="memo-card">
        <p class="memo-category">
            {{ memo.category?.name ?? '未設定' }}
        </p>

        <h3>{{ memo.title }}</h3>

        <p class="memo-content">
            {{ memo.content }}
        </p>

        <p class="memo-date">
            作成日：{{ memo.created_at }}
        </p>

        <div class="memo-actions">
            <button
                type="button"
                class="edit-button"
                :disabled="isDeleting"
                @click="emit('edit')"
            >
                編集
            </button>

            <button
                type="button"
                class="delete-button"
                :disabled="isDeleting"
                @click="emit('delete')"
            >
                {{ isDeleting ? '削除中...' : '削除' }}
            </button>
        </div>
    </article>
</template>

<style scoped>
.memo-card {
    padding: 20px;
    border: 1px solid #dbe3e8;
    border-radius: 8px;
    background-color: white;
}

.memo-card h3 {
    margin: 10px 0;
}

.memo-category {
    display: inline-block;
    margin: 0;
    padding: 5px 10px;
    border-radius: 12px;
    background-color: #eaf2fb;
    color: #2980b9;
    font-size: 13px;
    font-weight: bold;
}

.memo-content {
    white-space: pre-wrap;
}

.memo-date {
    margin-bottom: 0;
    color: #777;
    font-size: 13px;
}

.memo-actions {
    display: flex;
    gap: 10px;
    margin-top: 15px;
}

.edit-button,
.delete-button {
    padding: 8px 14px;
    border: none;
    border-radius: 6px;
    color: white;
    font-size: 14px;
    cursor: pointer;
}

.edit-button {
    background-color: #3498db;
}

.edit-button:hover:not(:disabled) {
    background-color: #2980b9;
}

.delete-button {
    background-color: #e74c3c;
}

.delete-button:hover:not(:disabled) {
    background-color: #c0392b;
}

.edit-button:disabled,
.delete-button:disabled {
    cursor: not-allowed;
    opacity: 0.6;
}
</style>