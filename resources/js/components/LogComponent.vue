<template>
    <div class="log-container" ref="logContainer">
        <h3>戦闘ログ</h3>
        <ul>
            <li v-for="(log, index) in logs" :key="index">{{ log }}</li>
        </ul>
    </div>
</template>

<script setup>
import { ref, watch, nextTick } from 'vue'

const props = defineProps({
    logs: {
        type: Array,
        required: true,
    },
})

const logContainer = ref(null)

// logs 配列の長さが変わったらスクロールを最下部へ
watch(() => props.logs.length, async () => {
    await nextTick()
    if (logContainer.value) {
        logContainer.value.scrollTop = logContainer.value.scrollHeight
    }
})
</script>

<style scoped>
.log-container {
    max-height: 400px;
    overflow-y: auto;
    background: #fafafa;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 12px;
}

.log-container ul {
    padding-left: 16px;
    margin: 0;
}
</style>
