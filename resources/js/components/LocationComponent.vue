<template>
    <div class="modal-overlay" @click.self="close">
        <div class="modal">
            <button class="close-button" @click="close">×</button>

            <h2>{{ location.name }}</h2>
            <hr class="modal-line" />
            <!-- 人物一覧 -->
            <PeopleComponent v-if="!isMoving" :people="location.people" :selectedPersonId="selectedPerson?.id || null"
                @update:selectedPersonId="updateSelectedPerson" />

            <!-- 移動モード中の拠点選択画面 -->
            <MoveComponent v-if="isMoving" ref="moveComponent" :location="location" :selectedPerson="selectedPerson"
                :factionCode="location.faction_code" @cancelMove="cancelMove" @moveCompleted="handleMoveCompleted" />

            <!-- 移動ボタン（移動モードでない＆人物がいる＆選択済） -->
            <button v-if="!isMoving && location.people && location.people.length > 0" class="move-button"
                :disabled="!selectedPerson" @click="onMoveClicked">
                拠点を移動する
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, nextTick } from 'vue'
import PeopleComponent from './PeopleComponent.vue'
import MoveComponent from './MoveComponent.vue'

const props = defineProps({
    location: Object
})

const emit = defineEmits(['close', 'moveCompleted'])

const selectedPerson = ref(null)
const isMoving = ref(false)
const moveComponent = ref(null)

const close = () => {
    emit('close')
}

// 人物が選ばれた時の処理
const updateSelectedPerson = (personId) => {
    const person = props.location.people.find(p => p.id === personId)
    selectedPerson.value = person || null
}

// 「移動」ボタン押下
const onMoveClicked = async () => {
    if (!selectedPerson.value) return

    isMoving.value = true
    await nextTick()
    moveComponent.value?.fetchLocations(props.location.code)
}

// 「一覧に戻る」押下
const cancelMove = () => {
    isMoving.value = false
}

// 移動完了時
const handleMoveCompleted = (msg, status) => {
    isMoving.value = false
    selectedPerson.value = null
    emit('close')
    emit('moveCompleted', msg, status)
}
</script>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.modal {
    background: white;
    padding: 20px;
    border-radius: 8px;
    width: 700px;
    max-height: 90vh;
    overflow-y: auto;
    position: relative;
}

.modal-line {
    color: rgb(207, 202, 202);
    margin-top: 5px;
    margin-bottom: 5px;
}

.close-button {
    position: absolute;
    top: 10px;
    right: 15px;
    background: transparent;
    border: none;
    font-size: 24px;
    cursor: pointer;
}

.move-button,
.back-button {
    background-color: #3498db;
    color: white;
    padding: 6px 12px;
    margin-top: 16px;
    margin-bottom: 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}

.move-button:hover,
.back-button:hover {
    background-color: #2980b9;
}

.move-button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}
</style>
