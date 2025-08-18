<template>
    <div class="move-container">
        <p>人物: {{ selectedPerson?.name || '未選択' }}</p>
        <p>移動先の拠点を選択してください</p>

        <ul class="location-list">
            <li v-for="loc in locations" :key="loc.id" @click="selectLocation(loc)"
                :class="{ selected: selectedLocation?.id === loc.id }">
                {{ loc.name }}
            </li>
        </ul>

        <button class="move-confirm-button" :disabled="!selectedLocation" @click="confirmMove">
            この拠点に移動する
        </button>

        <button class="back-button" @click="emit('cancelMove')">一覧に戻る</button>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const props = defineProps({
    location: Object,       // 現在の拠点
    selectedPerson: Object, // 選択された人物
    factionCode: String     // 勢力コード
})

const emit = defineEmits(['cancelMove', 'moveCompleted'])

const locations = ref([])
const selectedLocation = ref(null)

const fetchLocations = async (factionCode) => {
    try {
        const res = await axios.get(`/mogawar/public/api/locations/${factionCode}/candidates`)
        locations.value = res.data
    } catch (error) {
        console.error('拠点候補取得エラー:', error)
        alert('拠点一覧の取得に失敗しました。')
    }
}

defineExpose({ fetchLocations })

const selectLocation = (loc) => {
    selectedLocation.value = loc
}

const confirmMove = async () => {
    try {
        await axios.put(`/mogawar/public/api/people/${props.selectedPerson.id}/move`, {
            destination_code: selectedLocation.value.code
        })
        emit('moveCompleted', `${props.selectedPerson.name} さんは ${selectedLocation.value.name} に移動しました。`, 'success')
    } catch (error) {
        console.error('移動エラー:', error)
        emit('moveCompleted', "移動に失敗しました", 'error')
    }
}
</script>

<style scoped>
.move-container {
    padding: 10px;
}

.location-list {
    list-style: none;
    padding: 0;
}

.location-list li {
    padding: 8px 12px;
    border: 1px solid #ccc;
    margin-bottom: 6px;
    cursor: pointer;
    border-radius: 4px;
    user-select: none;
}

.location-list li.selected {
    background-color: #3498db;
    color: white;
    font-weight: bold;
}

.move-confirm-button {
    background-color: #27ae60;
    color: white;
    padding: 8px 16px;
    margin-top: 12px;
    margin-right: 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}

.move-confirm-button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}

.back-button {
    background-color: #888;
    color: white;
    padding: 8px 16px;
    margin-top: 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}
</style>
