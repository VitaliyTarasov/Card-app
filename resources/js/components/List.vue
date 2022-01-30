<template>
    <div class="bg-gray-200 rounded-sm p-2 mr-2 list">
        <div class="flex justify-between">
        <div class="text-gray-700 pl-2 pb-2 font-bold">{{ list.title }}</div>
        </div>
        <Card v-for="card in list.cards" :key="card.id" :card="card" @deleted="$emit('card-deleted', {...$event, listId: list.id})" @updated="$emit('card-updated', {...$event, listId: list.id})"></Card>
        <CardEditorAdd v-if="editing" @closed="editing=false" :list="list" @added="$emit('card-added', {...$event, listId: list.id})"></CardEditorAdd>
        <AddCard v-if="!editing && canAddCard" @click="editing=true"></AddCard>
    </div>
</template>

<script>
import Card from './Card';
import AddCard from './AddCard';
import CardEditorAdd from './CardEditorAdd';
import { mapState } from 'vuex';

export default {
    components: {Card, AddCard, CardEditorAdd},
    props: {
        list: Object
    },
    data() {
        return {
            editing: false,
        }
    },
    computed: mapState({
        canAddCard(state) {
            return this.list.board.user.id == state.user.id;
        }
    })
};
</script>


<style scoped>

</style>