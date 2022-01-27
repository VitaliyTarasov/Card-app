import Vue from 'vue';
import Vuex from 'vuex';
import apollo from './apollo.config';
import Me from './graphql/Me.gql';

Vue.use(Vuex);

const store = {
    state: {
        isLoggedIn: false,
        user: {
            id: null,
            name: null,
            email: null
        }
    },
    mutations: {
        setLoggedIn(state, cstate) {
            state.isLoggedIn = Boolean(cstate);
        },
        setUser(state, cstate) {
            state.user = cstate;
        }
    },
    actions: {
        async setLoggedIn({commit}, cstate) {
            const isLoggedIn = Boolean(cstate);
            window.localStorage.setItem("isLoggedIn", isLoggedIn);
            commit("setLoggedIn", isLoggedIn);
        },
        async logout({ commit, dispatch }) {
            commit("setUser", {
                id: null,
                name: null,
                email: null,
            });
            dispatch("setLoggedIn", false);
        },
        async fetchUser({ commit, dispatch }) {
            const result = await apollo.defaultClient.query({
                query: Me,
                fetchPolicy: "no-cache"
            });
            const user = result.data?.me;

            if (user) {
                commit("setUser", user);
                dispatch("setLoggedIn", true);
            } else {
                dispatch("logout");
            }
        }
    },
};

export default new Vuex.Store(store);