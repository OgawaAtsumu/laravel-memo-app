<script setup>
defineProps({
    categories: {
        type: Array,
        required: true,
    },

    searchKeyword: {
        type: String,
        required: true,
    },

    selectedCategoryId: {
        type: [String, Number],
        required: true,
    },

    totalCount: {
        type: Number,
        required: true,
    },

    filteredCount: {
        type: Number,
        required: true,
    },
});

const emit = defineEmits([
    'update:searchKeyword',
    'update:selectedCategoryId',
    'clear',
]);
</script>

<template>
    <div>
        <div class="filter-area">
            <div class="filter-group keyword-filter">
                <label for="search-keyword">
                    キーワード
                </label>

                <input
                    id="search-keyword"
                    :value="searchKeyword"
                    type="search"
                    placeholder="タイトル・内容を検索"
                    @input="
                        emit(
                            'update:searchKeyword',
                            $event.target.value
                        )
                    "
                >
            </div>

            <div class="filter-group">
                <label for="search-category">
                    カテゴリ
                </label>

                <select
                    id="search-category"
                    :value="selectedCategoryId"
                    @change="
                        emit(
                            'update:selectedCategoryId',
                            $event.target.value
                        )
                    "
                >
                    <option value="">
                        すべてのカテゴリ
                    </option>

                    <option
                        v-for="category in categories"
                        :key="category.id"
                        :value="category.id"
                    >
                        {{ category.name }}
                    </option>
                </select>
            </div>

            <button
                type="button"
                class="clear-filter-button"
                :disabled="
                    !searchKeyword &&
                    !selectedCategoryId
                "
                @click="emit('clear')"
            >
                検索条件をクリア
            </button>
        </div>

        <p class="filter-count">
            全{{ totalCount }}件中、
            {{ filteredCount }}件を表示
        </p>
    </div>
</template>

<style scoped>
.filter-area {
    display: flex;
    align-items: flex-end;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 12px;
    padding: 16px;
    border: 1px solid #dbe3e8;
    border-radius: 8px;
    background-color: #f8fafb;
}

.filter-group {
    min-width: 180px;
}

.keyword-filter {
    flex: 1;
    min-width: 240px;
}

.filter-group label {
    display: block;
    margin-bottom: 7px;
    color: #34495e;
    font-weight: bold;
}

.filter-group input,
.filter-group select {
    width: 100%;
    padding: 10px;
    box-sizing: border-box;
    border: 1px solid #aeb6bf;
    border-radius: 6px;
    background-color: white;
    font-size: 15px;
}

.clear-filter-button {
    padding: 10px 16px;
    border: none;
    border-radius: 6px;
    background-color: #7f8c8d;
    color: white;
    cursor: pointer;
}

.clear-filter-button:hover:not(:disabled) {
    background-color: #626f70;
}

.clear-filter-button:disabled {
    cursor: not-allowed;
    opacity: 0.5;
}

.filter-count {
    margin: 0 0 18px;
    color: #667085;
    font-size: 14px;
}
</style>