<template>
  <div class="map-container">
    <!-- ✅ メッセージ表示 -->
    <div v-if="message" :class="['flash-message', messageStatusClass]">
      {{ message }}
    </div>

    <!-- 拠点表示 -->
    <div v-for="location in locations" :key="location.id" class="location-marker" :style="getMarkerStyle(location)"
      @click="fetchLocationDetail(location.id)">
      ●
      <span class="tooltip">{{ location.name }}</span>
    </div>

    <!-- 拠点詳細 -->
    <LocationComponent v-if="selectedLocation" :location="selectedLocation" @close="selectedLocation = null"
      @moveCompleted="handleMoveCompleted" />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import LocationComponent from './LocationComponent.vue'

const locations = ref([])
const selectedLocation = ref(null)
const message = ref('') // ✅ メッセージ用ステート
const messageStatusClass = ref('flash-success') // ✅ 成功・失敗ステータス

// 初期ロードで拠点一覧取得
onMounted(async () => {
  const response = await axios.get('/mogawar/public/api/locations')
  locations.value = response.data
})

// 拠点マーカーのスタイル
const getMarkerStyle = (location) => ({
  left: `${location.pos_x * 50}px`,
  top: `${location.pos_y * 50}px`,
  color: location.faction?.color || '#000000'
})

// 拠点の詳細データ取得
const fetchLocationDetail = async (id) => {
  try {
    const response = await axios.get(`/mogawar/public/api/locations/${id}`)
    selectedLocation.value = response.data
  } catch (error) {
    console.error('ロケーション詳細取得エラー:', error)
    alert('詳細情報の取得に失敗しました。')
  }
}

// LocationComponentからの移動完了イベントを受ける
const handleMoveCompleted = (msg, status) => {
  // メッセージをセットして画面に表示
  message.value = msg
  messageStatusClass.value = "flash-" + status
  setTimeout(() => {
    message.value = ''
  }, 3000)
}

</script>

<style scoped>
.map-container {
  position: relative;
  width: 500px;
  height: 400px;
  border: 2px solid #ccc;
  background-color: #f8f8f8;
}

.location-marker {
  position: absolute;
  transform: translate(-50%, -50%);
  font-size: 24px;
  cursor: pointer;
}

.tooltip {
  position: absolute;
  top: -20px;
  left: 50%;
  transform: translateX(-50%);
  background: #333;
  color: white;
  padding: 2px 6px;
  font-size: 12px;
  border-radius: 4px;
  white-space: nowrap;
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.3s;
}

.location-marker:hover .tooltip {
  opacity: 1;
}

/* ✅ フラッシュメッセージ用スタイル */
/* ✅ フラッシュメッセージ 共通 */
.flash-message {
  width: 500px;
  position: absolute;
  top: 10px;
  left: 50%;
  transform: translateX(-50%);
  padding: 8px 16px;
  border-radius: 4px;
  z-index: 2000;
  font-size: 14px;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
}

/* ✅ 成功時（緑） */
.flash-success {
  background-color: #dff0d8;
  color: #3c763d;
}

/* ✅ 失敗時（赤） */
.flash-error {
  background-color: #f2dede;
  color: #a94442;
}
</style>
