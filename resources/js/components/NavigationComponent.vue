<template>
    <div class="menu-buttons">
        <button @click="goToBattle">⚔️ 戦闘</button>
        <button @click="goToPeople">🧑‍🤝‍🧑 人物</button>
        <button @click="goToHome">🏠 ホーム</button>
    </div>
</template>

<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

const goToBattle = () => {
    router.push('/mogawar/public/tactics')
}

const goToPeople = () => {
    router.push('/mogawar/public/people')
}

const goToHome = () => {
    router.push('/mogawar/public/')
}
</script>

<style scoped>
.menu-buttons {
    display: flex;
    justify-content: center;
    margin-top: 24px;
    margin-bottom: 16px;
}

.menu-buttons button {
    margin-right: 12px;
    padding: 8px 16px;
    font-size: 16px;
    background-color: #3498db;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.menu-buttons button:hover {
    background-color: #2980b9;
}
</style>
