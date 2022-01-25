<template>
    <div>
        <textarea 
        name="" 
        class="shadow-card rounded-md py-1 px-2 outline-none w-full text-gray-700 text-sm bg-white h-16 resize-none" 
        placeholder="Enter text for this card..." 
        ref="card" 
        @keyup.esc="closed" 
        @keyup.enter="addCard"
        v-model="title">
        </textarea>
        <div class="flex">
            <button @click="addCard" class="rounded-sm py-1 px-2 bg-indigo-600 text-white cursor-pointer hover:bg-indigo-400 outline-none">Add Card</button>
            <button @click="closed" class="rounded-md py-1 ml-1 px-2 cursor-pointer outline-none hover:bg-gray-400 text-gray-600">Cancel</button>
        </div>
    </div>
</template>

<script>
import CardAdd from "./../graphql/CardAdd.gql";
import BoardQuery from "./../graphql/Board.gql";

export default {
    props: {
        list: Object
    },
    data() {
        return {
            title: null
        };
    },
    mounted() {
        this.$refs.card.focus();
    },
    methods: {
        addCard() {
            const self = this;
            this.$apollo.mutate({
                mutation: CardAdd,
                variables: {
                    title: this.title,
                    listId: this.list.id,
                    order: this.list.cards.length + 1
                },
                update(store, {data: {cardAdd} }) {
                    const data = store.readQuery({
                        query: BoardQuery,
                        variables: {
                            id: Number(self.list.board_id)
                        }
                    });
                    data.board.lists.find(list => list.id == self.list.id).cards.push(cardAdd);
                    store.writeQuery({ query: BoardQuery, data});
                }
            });
            this.closed();
        },
        closed() {
            this.$emit("closed");
        }
    }
}
</script>

