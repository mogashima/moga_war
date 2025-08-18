<template>
    <div>
        <table class="people-table" v-if="people && people.length">
            <thead>
                <tr>
                    <th></th>
                    <th>名前</th>
                    <th>Lv</th>
                    <th>HP</th>
                    <th>MP</th>
                    <th>力</th>
                    <th>知力</th>
                    <th>防御</th>
                    <th>耐性</th>
                    <th>素早さ</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="person in people" :key="person.id" @click="selectPerson(person.id)"
                    :class="{ selected: selectedPersonId === person.id }" style="cursor: pointer">
                    <td>
                        <input type="radio" :value="person.id" :checked="selectedPersonId === person.id"
                            @change="selectPerson(person.id)" />
                    </td>
                    <td>{{ person.name }}</td>
                    <td>{{ person.lv }}</td>
                    <td>{{ person.hp }}</td>
                    <td>{{ person.mp }}</td>
                    <td>{{ person.strength }}</td>
                    <td>{{ person.intelligence }}</td>
                    <td>{{ person.defense }}</td>
                    <td>{{ person.resist }}</td>
                    <td>{{ person.agility }}</td>
                </tr>
            </tbody>
        </table>
        <p v-else>この拠点には人物がいません。</p>
    </div>
</template>

<script setup>

const props = defineProps({
    people: Array,
    selectedPersonId: [String, Number, null]
})

const emit = defineEmits(['update:selectedPersonId'])

const selectPerson = (personId) => {
    emit('update:selectedPersonId', personId)
}
</script>

<style scoped>
.people-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}

.people-table th,
.people-table td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: center;
}

.people-table th {
    background-color: #f0f0f0;
}

.selected {
    background-color: #d0ebff;
}
</style>
