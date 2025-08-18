<template>
    <div class="tactics-container">
        <h2>戦術マップ</h2>

        <p>攻撃元の拠点を選択：</p>
        <select v-model="fromLocationId">
            <option disabled value="">-- 拠点を選択 --</option>
            <option v-for="loc in locations" :key="loc.id" :value="loc.id">
                {{ loc.name }}（{{ loc.faction?.name || '無所属' }}）
            </option>
        </select>

        <p>攻撃対象の拠点を選択：</p>
        <select v-model="toLocationId">
            <option disabled value="">-- 拠点を選択 --</option>
            <option v-for="loc in targetableLocations" :key="loc.id" :value="loc.id">
                {{ loc.name }}（{{ loc.faction?.name || '無所属' }}）
            </option>
        </select>

        <button class="attack-button" :disabled="!fromLocationId || !toLocationId" @click="startBattle">
            攻撃開始
        </button>
    </div>

    <NavigationComponent />
</template>

<script setup>
import NavigationComponent from './NavigationComponent.vue'
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const router = useRouter()

const locations = ref([])
const fromLocationId = ref('')
const toLocationId = ref('')

onMounted(async () => {
    const res = await axios.get('/mogawar/public/api/locations')
    locations.value = res.data
})

const targetableLocations = computed(() => {
    if (!fromLocationId.value) return []

    const from = locations.value.find(l => l.id === fromLocationId.value)
    if (!from || !from.faction_code) return []

    // 隣接拠点のコードを取得（to_locationベース）
    const neighborCodes = (from.neighbors || []).map(n => n.to_location?.code).filter(Boolean)

    // 隣接かつ勢力が異なる拠点のみ返す
    return locations.value.filter(
        l => l.id !== from.id && neighborCodes.includes(l.code) && l.faction_code !== from.faction_code
    )
})

const startBattle = () => {
    router.push({
        name: 'Battle',
        params: {
            location1: fromLocationId.value,
            location2: toLocationId.value
        }
    })
}
</script>

<style scoped>
.tactics-container {
    max-width: 500px;
    margin: 32px auto;
    background: #f9f9f9;
    padding: 24px;
    border-radius: 8px;
    box-shadow: 0 0 6px rgba(0, 0, 0, 0.1);
}

select {
    width: 100%;
    margin-bottom: 16px;
    padding: 8px;
    border-radius: 6px;
    border: 1px solid #ccc;
}

.attack-button {
    width: 100%;
    background-color: #e74c3c;
    color: white;
    font-weight: bold;
    padding: 12px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.attack-button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}
</style>
