<template>
    <div class="h-full flex flex-col items-stretch" :class="bgColor">
        <div class="header text-white flex justify-between items-center mb-2">
            <div class="ml-2 w-1/3">
                <UserBoardsDropdown v-if="isLoggedIn"></UserBoardsDropdown>
            </div>
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
                <ListAddEditor :board="board.id" @added="updateQueryCache($event)"></ListAddEditor>
            </div>
        </div>
    </div>
</template>



<script>
import List from './components/List';
import ListAddEditor from './components/ListAddEditor';
import BoardQuery from './graphql/Board.gql';
import DropdownMenu from './components/DropdownMenu';
import UserBoardsDropdown from './components/UserBoardsDropdown';
import Logout from './graphql/Logout.gql';
import { EVENT_CARD_ADDED } from './constants';
import { EVENT_CARD_DELETED } from './constants';
import { EVENT_CARD_UPDATED } from './constants';
import { EVENT_LIST_ADDED } from './constants';
import { mapState } from 'vuex';
import { colorMap400 } from './utils';

export default {
    components: { List, UserBoardsDropdown, ListAddEditor },
    computed: {
        ...mapState({
            isLoggedIn: "isLoggedIn",
            name: state => state.user.name,
        }),
        bgColor () {
            return {
                "bg-gray-400": this.$apollo.loading,
                [colorMap400[this.board?.color]]: true
            }
        }
    },
    apollo: {
        board: {
            query: BoardQuery,
            variables() {
                return {
                    id: Number(this.$route.params.id)
                }
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
                case EVENT_LIST_ADDED:
                    data.board.lists.push(event.data);
                    break;
                    
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

            
            event.store.writeQuery({ query: BoardQuery, data, variables: {
                id: Number(this.board.id)
            }});
        }
    }
};
</script>

<style scoped>
.header {
    height: 50px;
    background-color: rgba(0,0,0,0.3);
}
</style>