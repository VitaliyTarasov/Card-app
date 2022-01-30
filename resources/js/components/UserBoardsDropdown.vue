<template>
    <div>
        <button class="header-btn" @click="showBoards = !showBoards">Boards</button>
        <DropdownMenu :show="showBoards" @closed="showBoards = false">
            <div class="text-gray-600 text-sm font-semibold text-center mb-1">BOARDS</div>
            <router-link :to="{name: 'board', params: {id: board.id}}"  
            v-for="board in userBoards" 
            :key="board.id" 
            :class="[`bg-${board.color}-100`]" 
            class="rounded-sm opacity-100 text-gray-700 font-bold cursor-pointer flex mb-1"
            @click.native="showBoards = false"
            >
                <div :class="[`bg-${board.color}-100`]" class="p-3 text-sm hover:opacity-70">{{ board.title }}</div>
            </router-link>
            <div class="rounded-sm hover:bg-gray-200 p-2 cursor-pointer mt-2" @click="showModal = true">Create new board</div>
            <BoardAddModal :show="showModal" @closed="showModal = false"></BoardAddModal>
        </DropdownMenu>
    </div>
</template>

<script>
import DropdownMenu from './DropdownMenu';
import UserBoards from './../graphql/UserBoards.gql';
import Modal from './Modal';
import BoardAddModal from './BoardAddModal';
import { mapState } from 'vuex';
import { colorMap100 } from "./../utils";
import { directive as onClickaway } from "vue-clickaway";

export default {
    components: { DropdownMenu, BoardAddModal, Modal},
    props: {
        show: Boolean,
    },
    directives: { onClickaway },
    apollo: {
        userBoards: {
            query: UserBoards,
            variables() {
                return {
                    userId: this.userId
                };
            },
            skip() {
                return !this.userId;
            }
        }
    },
    data() {
        return {
            showBoards: false,
            showModal: false,
        };
    },
    computed: {
        ...mapState({
            userId: state => state.user.id
        }),
        colorMap100: () => colorMap100
    },
    methods: {
        close() {
            this.showModal = false
        }
    }
}
</script>