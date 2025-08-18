<template>
    <div class="home-container">
        <WorldComponent />
    </div>
    <NavigationComponent />
</template>

<script setup>
import WorldComponent from './WorldComponent.vue'
import NavigationComponent from './NavigationComponent.vue'
</script>

<style scoped>
.home-container {
    margin-top: 32px;
    /* 中央寄せ */
    display: flex;
    flex-direction: column;
    align-items: center;
}
</style>
