<script setup>
    defineProps({
        technology: {
            type: String,
            required: true,
        },
    });
    const emit = defineEmits(['remove']);
</script>

<template>
    <li class="technology-item">
        <span>{{ technology }}</span>

        <button
            type="button"
            class="remove-button"
            @click="emit('remove')"
        >
            削除
        </button>
    </li>
</template>

<style scoped>
.technology-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    margin-bottom: 8px;
    padding: 10px 12px;
    background-color: white;
    border: 1px solid #d5dbdb;
    border-radius: 6px;
}

.remove-button {
    padding: 6px 12px;
    border: none;
    border-radius: 5px;
    background-color: #e74c3c;
    color: white;
    font-size: 14px;
    cursor: pointer;
}

.remove-button:hover {
    background-color: #c0392b;
}
</style>