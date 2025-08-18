<template>
    <div class="battle-container">
        <!-- 拠点名 -->
        <div class="location-names">
            <div class="location-name">{{ location1?.name || '拠点1' }}</div>
            <div class="vs-text">VS</div>
            <div class="location-name">{{ location2?.name || '拠点2' }}</div>
        </div>

        <!-- 人物一覧 -->
        <div class="location-info">
            <div class="location-block">
                <ul>
                    <li v-for="person in location1?.people || []" :key="person.id">
                        <span class="person-name">{{ person.name }}</span>
                        <span class="person-hp">HP: {{ person.hp }} / {{ person.maxHp }}</span>
                        <span class="person-mp">MP: {{ person.mp }}</span>
                    </li>
                </ul>
            </div>
            <div class="location-block">
                <ul>
                    <li v-for="person in location2?.people || []" :key="person.id">
                        <span class="person-name">{{ person.name }}</span>
                        <span class="person-hp">HP: {{ person.hp }} / {{ person.maxHp }}</span>
                        <span class="person-mp">MP: {{ person.mp }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- ターンボタン -->
        <button class="turn-button" :disabled="battleOver" @click="nextTurn">
            ターン進行
        </button>

        <!-- 勝敗 -->
        <p v-if="winner" class="winner-message">{{ winner }} の勝利！</p>

        <!-- 戦闘ログ -->
        <LogComponent :logs="logs" />
    </div>

    <NavigationComponent />
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'
import NavigationComponent from './NavigationComponent.vue'
import LogComponent from './LogComponent.vue'

const route = useRoute()
const locationId1 = route.params.location1
const locationId2 = route.params.location2

const location1 = ref(null)
const location2 = ref(null)
const logs = ref([])
const winner = ref(null)
const turn = ref(0)

const fetchLocationDetail = async (id) => {
    const res = await axios.get(`/mogawar/public/api/locations/${id}`)
    return res.data
}

onMounted(async () => {
    location1.value = await fetchLocationDetail(locationId1)
    location2.value = await fetchLocationDetail(locationId2)

    // 各人物に maxHp を追加（初期化）
    for (const p of location1.value.people) {
        p.maxHp = p.hp
    }
    for (const p of location2.value.people) {
        p.maxHp = p.hp
    }
})

const battleOver = computed(() => winner.value !== null)

const nextTurn = () => {
    if (battleOver.value) return

    turn.value++
    logs.value.push(`${turn.value}ターン目開始！`)

    const attackers = [...location1.value.people, ...location2.value.people]
        .filter(p => p.hp > 0)
        .sort((a, b) => {
            if (a.agility === b.agility) return Math.random() - 0.5
            return b.agility - a.agility
        })

    for (const attacker of attackers) {
        const skills = attacker.skills || []
        if (skills.length === 0) continue

        const skill = skills[Math.floor(Math.random() * skills.length)]
        const targets = getSkillTargets(attacker, skill)

        if (targets.length === 0) continue

        for (const target of targets) {
            const result = performSkill(attacker, target, skill)
            logs.value.push(result)
        }
    }

    const allDead1 = location1.value.people.every(p => p.hp <= 0)
    const allDead2 = location2.value.people.every(p => p.hp <= 0)

    if (allDead1 && allDead2) {
        winner.value = '引き分け'
        logs.value.push('全滅！引き分けです。')
    } else if (allDead1) {
        winner.value = location2.value.name
        logs.value.push(`${location2.value.name} の勝利！`)
    } else if (allDead2) {
        winner.value = location1.value.name
        logs.value.push(`${location1.value.name} の勝利！`)
    }
}

const performSkill = (attacker, target, skill) => {
    let value = 0
    let actionText = ''

    // MPチェック
    if (attacker.mp < skill.cost) {
        return `${attacker.name} はMPが足りずに ${skill.name} が使えなかった`
    }

    switch (skill.formula_type) {
        case 1: // 攻撃（攻撃力 - 防御力の一部）
            if (skill.type === 'physical') {
                value = attacker.strength - target.defense / 2
            } else {
                value = attacker.intelligence - target.resist / 2
            }
            value = Math.max(1, Math.floor(value))
            target.hp = Math.max(0, target.hp - value)
            actionText = `${attacker.name} は ${skill.name} を使って ${target.name} に ${value} のダメージ！`
            break

        case 2: // 固定威力攻撃（powerのみ）
            value = Math.max(1, Math.floor(skill.power))
            target.hp = Math.max(0, target.hp - value)
            actionText = `${attacker.name} は ${skill.name} を使って ${target.name} に ${value} の固定ダメージ！`
            break

        case 3: // 回復（power使用）
            value = Math.max(1, Math.floor(skill.power))
            if (value + target.hp > target.maxHp) {
                value = target.maxHp - target.hp
            }
            target.hp = target.hp + value
            actionText = `${attacker.name} は ${skill.name} で ${target.name} のHPを ${value} 回復した！`
            break

        default: // デフォルト（固定10）
            value = 10
            target.hp = Math.max(0, target.hp - value)
            actionText = `${attacker.name} は ${skill.name} を使って ${target.name} に ${value} のダメージ！`
    }

    // MPを消費
    attacker.mp -= skill.cost
    return actionText
}

const getSkillTargets = (attacker, skill) => {
    const isLocation1 = attacker.location_code === location1.value.code

    const enemies = isLocation1 ? location2.value.people : location1.value.people
    const allies = isLocation1 ? location1.value.people : location2.value.people

    switch (skill.target) {
        case 'enemy':
            return enemies.filter(p => p.hp > 0).length > 0
                ? [randomElement(enemies.filter(p => p.hp > 0))]
                : []
        case 'ally':
            return allies.filter(p => p.hp > 0).length > 0
                ? [randomElement(allies.filter(p => p.hp > 0))]
                : []
        case 'self':
            return [attacker]
        case 'all_enemies':
            return enemies.filter(p => p.hp > 0)
        case 'all_allies':
            return allies.filter(p => p.hp > 0)
        default:
            return []
    }
}

// ランダムに1つ選ぶユーティリティ
const randomElement = (arr) => arr[Math.floor(Math.random() * arr.length)]
</script>

<style scoped>
.battle-container {
    max-width: 800px;
    margin: 32px auto;
    padding: 24px;
    background-color: #fefefe;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.location-names {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.location-name {
    font-size: 20px;
    font-weight: bold;
    width: 40%;
    text-align: center;
}

.vs-text {
    font-size: 18px;
    font-weight: bold;
}

.location-info {
    display: flex;
    justify-content: space-between;
    margin-bottom: 16px;
}

.location-block {
    width: 45%;
    background: #f4f4f4;
    padding: 12px;
    border-radius: 8px;
}

.turn-button {
    display: block;
    width: 100%;
    padding: 12px;
    font-size: 16px;
    background-color: #3498db;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    margin-bottom: 12px;
}

.turn-button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}

.winner-message {
    text-align: center;
    font-size: 18px;
    font-weight: bold;
    color: #e74c3c;
}

.person-name {
    width: 6em;
    display: inline-block;
}

.person-hp {
    width: 8em;
    display: inline-block;
}

.person-mp {
    width: 5em;
    display: inline-block;
}
</style>
