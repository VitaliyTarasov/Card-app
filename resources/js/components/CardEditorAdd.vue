<template>
    <CardEditor v-model="title" @closed="closed" @saved="addCard" label="Add Card"></CardEditor>
</template>

<script>
import CardAdd from "./../graphql/CardAdd.gql";
import BoardQuery from "./../graphql/Board.gql";
import CardEditor from "./CardEditor";
import { EVENT_CARD_ADDED } from "./../constants";
import { mapState } from "vuex";

export default {
    components: {CardEditor},
    props: {
        list: Object
    },
    data() {
        return {
            title: null
        };
    },
    computed: mapState({
        userId: state => state.userId
    }),
    // mounted() {
    //     this.$refs.card.focus();
    // },
    methods: {
        addCard() {
            const self = this;
            this.$apollo.mutate({
                mutation: CardAdd,
                variables: {
                    title: this.title,
                    listId: this.list.id,
                    order: this.list.cards.length + 1,
                    userId: this.userId 
                },
                update(store, {data: {cardAdd} }) {
                    self.$emit("added", {
                        store,
                        data: cardAdd,
                        type: EVENT_CARD_ADDED
                    });
                    self.closed();
                }
            });
        },
        closed() {
            this.$emit("closed");
        }
    }
}
</script>