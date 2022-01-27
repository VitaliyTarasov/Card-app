<template>
    <div class="h-full flex flex-col items-stretch bg-purple-500">
        <div class="header text-white flex justify-between items-center mb-2 bg-purple-400">
            <div class="ml-2 w-1/3">x</div>
            <div class="text-lg opacity-50 cursor-pointer hover:opacity-80" >Card-App</div>
            <div class="mr-2 w-1/3 flex justify-end">
                <div v-if="isLoggedIn" class="flex items-center">
                    <div class="mr-2">{{ name }}</div>
                    <button class="header-btn" @click="logout">Logout</button>
                </div>
                <div v-else>
                    <button class="header-btn" @click="$router.push({name: 'login'})">Sign in</button>
                    <button class="header-btn" @click="$router.push({name: 'register'})">Sign up</button>    
                </div> 
            </div>
        </div>
        <div class="flex flex-1 flex-col items-stretch">
            <div class="mx-5 mb-2 text-white font-bold text-lg">
                <span v-if="$apollo.queries.board.loading">...</span>
                <span v-else>{{ board.title }}</span>
            </div>
            <div class="flex flex-1 items-start overflow-x-auto mx-2" v-if="board">
                <List :list="list" v-for="list in board.lists" :key="list.id" 
                @card-deleted="updateQueryCache($event)" 
                @card-added="updateQueryCache($event)"
                @card-updated="updateQueryCache($event)"></List>
            </div>
      </div>
    </div>
</template>



<script>
import List from './components/List';
import BoardQuery from './graphql/Board.gql';
import Logout from './graphql/Logout.gql';
import { EVENT_CARD_ADDED } from './constants';
import { EVENT_CARD_DELETED } from './constants';
import { EVENT_CARD_UPDATED } from './constants';
import { mapState } from 'vuex';

export default {
    components: {List},
    computed: mapState({
        isLoggedIn: "isLoggedIn",
        name: state => state.user.name,
    }),
    apollo: {
        board: {
            query: BoardQuery,
            variables: {
                id: 1
            }
        }
    },
    methods : {
        async logout () {
            const response = await this.$apollo.mutate({
                mutation: Logout
            });
            if (response.data?.logout.id) {
                this.$store.dispatch("logout");
            }
        },
        updateQueryCache(event) {
            const data = event.store.readQuery({
            query: BoardQuery,
            variables: {
                id: Number(this.board.id)
            }
            });

            switch (event.type) {
                case EVENT_CARD_ADDED:
                    data.board.lists.find(list => list.id == event.listId).cards.push(event.data);
                    break;

                case EVENT_CARD_DELETED:
                    data.board.lists.find(list => list.id == event.listId).cards 
                    = data.board.lists.find(list => list.id == event.listId).cards.filter(card => card.id != event.data.id);
                    break;
                
                case EVENT_CARD_UPDATED:
                    data.board.lists.find(list => list.id == event.listId).cards.filter(card => card.id == event.data.id).title = event.data.title;
                    break;
            }

            
            event.store.writeQuery({ query: BoardQuery, data});
        }
    }
};
</script>

<style scoped>
.header {
    height: 50px;
}
</style>