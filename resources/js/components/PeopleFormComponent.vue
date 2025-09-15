<template>
    <div class="form-container">
        <h2>プレイヤー追加</h2>
        <form @submit.prevent="savePerson">
            <div class="form-group">
                <label for="name">名前</label>
                <input type="text" v-model="form.name" id="name" required />
            </div>

            <div class="form-group">
                <label for="job">職業</label>
                <select v-model="form.job_code" id="job" required>
                    <option value="">選択してください</option>
                    <option v-for="job in jobs" :key="job.code" :value="job.code">
                        {{ job.name }}
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label for="rank">ランク</label>
                <input type="number" v-model="form.rank" id="rank" min="1" required />
            </div>

            <div class="form-group">
                <label for="location">拠点</label>
                <select v-model="form.location_code" id="location" required>
                    <option value="">選択してください</option>
                    <option v-for="loc in locations" :key="loc.code" :value="loc.code">
                        {{ loc.name }}
                    </option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="save-btn">保存</button>
                <button type="button" class="cancel-btn" @click="$emit('cancel')">キャンセル</button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from '@/plugins/axios'

const emit = defineEmits(['saved', 'cancel'])

const form = ref({
    name: '',
    job_code: '',
    rank: 1,
})

const jobs = ref([])
const locations = ref([])

const fetchJobs = async () => {
    try {
        const res = await axios.get('api/jobs')

        // key => value 形式を配列に変換
        jobs.value = Object.entries(res.data).map(([key, value]) => ({
            code: key,     // Enum の key
            name: value  // 表示名
        }))
    } catch (err) {
        console.error('職業取得失敗:', err)
    }
}

// 拠点取得
const fetchLocations = async () => {
    try {
        const res = await axios.get('api/locations')
        locations.value = res.data.map(loc => ({
            code: loc.code,
            name: loc.name
        }))
    } catch (err) {
        console.error('拠点取得失敗:', err)
    }
}

const savePerson = async () => {
    try {
        await axios.post('api/people', form.value)
        emit('saved') // 保存完了を親に通知
    } catch (err) {
        console.error('プレイヤー追加失敗:', err)
    }
}

onMounted(() => {
    fetchJobs()
    fetchLocations()
})
</script>

<style scoped>
.form-container {
    padding: 20px;
}

.form-group {
    margin-bottom: 12px;
}

label {
    display: block;
    margin-bottom: 6px;
}

input,
select {
    width: 100%;
    padding: 6px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.form-actions {
    margin-top: 16px;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.save-btn {
    background-color: #2ecc71;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
}

.save-btn:hover {
    background-color: #27ae60;
}

.cancel-btn {
    background-color: #95a5a6;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
}

.cancel-btn:hover {
    background-color: #7f8c8d;
}
</style>
