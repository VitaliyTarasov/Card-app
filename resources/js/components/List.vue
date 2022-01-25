<template>
    <div class="bg-gray-200 rounded-sm p-2 mr-2 list">
        <div class="flex justify-between">
        <div class="text-gray-700 pl-2 pb-2 font-bold">{{ list.title }}</div>
        </div>
        <Card v-for="card in list.cards" :key="card.id" :card="card"></Card>
        <CardEditor v-if="editing" @closed="editing=false" :list="list"></CardEditor>
        <AddCard v-else @click="editing=true"></AddCard>
    </div>
</template>

<script>
import Card from './Card';
import AddCard from './AddCard';
import CardEditor from './CardEditor';

export default {
    components: {Card, AddCard, CardEditor},
    props: {
        list: Object
    },
    data() {
        return {
            editing: false,
        }
    }
};
</script>


<style scoped>
.list{
    width: 230px;
    min-width: 230px;
}
</style>