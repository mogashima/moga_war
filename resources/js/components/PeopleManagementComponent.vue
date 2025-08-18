<template>
  <div class="people-container">
    <table class="people-table">
      <thead>
        <tr>
          <th>名前</th>
          <th>レベル</th>
          <th>職業</th>
          <th>ランク</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="person in people" :key="person.id" @click="openModal(person)">
          <td>{{ person.name }}</td>
          <td>{{ person.lv }}</td>
          <td>{{ person.job }}</td>
          <td>{{ person.rank }}</td>
        </tr>
      </tbody>
    </table>

    <!-- モーダル -->
    <div class="modal" v-if="selectedPerson">
      <div class="modal-content">
        <button class="modal-close-button" @click="closeModal">×</button>

        <div class="modal-section">
          <span class="person-name">{{ selectedPerson.name }}</span>
          <span class="person-lv">レベル : {{ selectedPerson.lv }}</span>
          <span class="person-rank">ランク : {{ selectedPerson.rank }}</span>
        </div>

        <div class="modal-section">
          <span class="person-job">職業 : {{ selectedPerson.job }}</span>
          <span class="person-hp">HP : {{ selectedPerson.hp }}</span>
          <span class="person-mp">MP : {{ selectedPerson.mp }}</span>
        </div>

        <div class="modal-section">
          <span class="person-strength">攻撃力 : {{ selectedPerson.strength }}</span>
          <span class="person-defense">防御力 : {{ selectedPerson.defense }}</span>
          <span class="person-intelligence">知力 : {{ selectedPerson.intelligence }}</span>
        </div>

        <div class="modal-section">
          <span class="person-resist">耐性 : {{ selectedPerson.resist }}</span>
          <span class="person-agility">素早さ : {{ selectedPerson.agility }}</span>
        </div>

        <!-- スキル表示切替 -->
        <div class="modal-section">
          <span class="person-skill">スキル</span>

          <div v-if="!isAddingSkill">
            <ul>
              <li v-for="skill in selectedPerson.skills" :key="skill.code">
                {{ skill.name }} - {{ skill.description }}
                <button class="delete-btn" @click="removeSkill(skill.id)">削除</button>
              </li>
            </ul>
            <button class="skill-add-button" @click="isAddingSkill = true">スキル追加</button>
          </div>

          <div v-else>
            <ul>
              <li v-for="skill in allSkills" :key="skill.code">
                {{ skill.name }} - {{ skill.description }}
                <button class="add-btn" @click="addSkill(skill.id)">追加</button>
              </li>
            </ul>
            <button class="back-button" @click="isAddingSkill = false">戻る</button>
          </div>
        </div>
      </div>
    </div>

    <NavigationComponent />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import NavigationComponent from './NavigationComponent.vue'

const people = ref([])
const selectedPerson = ref(null)
const isAddingSkill = ref(false)
const allSkills = ref([])

const fetchPeople = async () => {
  try {
    const res = await axios.get('/mogawar/public/api/people')
    people.value = res.data
  } catch (err) {
    console.error('取得エラー:', err)
  }
}

const fetchAllSkills = async () => {
  try {
    const res = await axios.get('/mogawar/public/api/skills')
    allSkills.value = res.data
  } catch (e) {
    console.error('スキル一覧取得エラー:', e)
  }
}

const openModal = async (person) => {
  selectedPerson.value = person
  isAddingSkill.value = false
  await fetchAllSkills()
}

const closeModal = () => {
  selectedPerson.value = null
  isAddingSkill.value = false
}

const removeSkill = async (skillId) => {
  try {
    await axios.delete(`/mogawar/public/api/people/${selectedPerson.value.id}/skills/${skillId}`)
    selectedPerson.value.skills = selectedPerson.value.skills.filter(s => s.id !== skillId)
  } catch (e) {
    console.error('スキル削除失敗:', e)
  }
}

const addSkill = async (skillId) => {
  try {
    await axios.post(`/mogawar/public/api/people/${selectedPerson.value.id}/skills`, {
      skill_id: skillId
    })

    const addedSkill = allSkills.value.find(s => s.id === skillId)
    if (addedSkill) {
      selectedPerson.value.skills.push(addedSkill)
    }
    isAddingSkill.value = false
  } catch (e) {
    console.error('スキル追加失敗:', e)
  }
}

onMounted(() => {
  fetchPeople()
})
</script>

<style scoped>
.people-container {
  max-width: 900px;
  margin: 0 auto;
  padding: 20px;
}

.people-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
}

.people-table th {
  background-color: #ddd;
  color: #333;
  padding: 10px;
  text-align: left;
}

.people-table td {
  border: 1px solid #ccc;
  padding: 10px;
}

.people-table tbody tr:hover {
  background-color: #e9e9e9;
  cursor: pointer;
}

/* モーダル */
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background-color: white;
  border-radius: 8px;
  padding: 24px;
  width: 700px;
  max-width: 90%;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
  position: relative;
}

.modal-close-button {
  position: absolute;
  top: 10px;
  right: 15px;
  background: transparent;
  border: none;
  font-size: 24px;
  cursor: pointer;
}

.modal-section {
  margin-bottom: 12px;
}

.modal-section span {
  display: inline-block;
  width: 12em;
  margin-bottom: 4px;
  font-size: 1.1em;
}

.delete-btn,
.add-btn {
  margin-left: 8px;
  padding: 2px 8px;
  color: white;
  border: none;
  border-radius: 4px;
  font-size: 0.8em;
  cursor: pointer;
}

.skill-add-button {
  color: white;
  padding: 8px 12px;
  border: none;
  border-radius: 6px;
  text-align: left;
  font-size: 14px;
  cursor: pointer;
  transition: background-color 0.2s;
  float: right;
}

.delete-btn {
  background-color: #e74c3c;
}

.delete-btn:hover {
  background-color: #c0392b;
}

.add-btn,
.skill-add-button {
  background-color: #2ecc71;
}

.add-btn:hover,
.skill-add-button:hover {
  background-color: #27ae60;
}

.back-button {
  background-color: #95a5a6;
  color: white;
  padding: 6px 12px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
}

.modal-section li {
  font-size: 1.1em;
  margin-top: 3px;
  margin-bottom: 3px;
}
</style>
