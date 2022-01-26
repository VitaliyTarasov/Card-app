<template>
    <div class="bg-white sm:bg-gray-100 h-full flex justify-center">
        <div class="flex flex-col container items-center mt-2 sm:mt-10 ">
            <div class="text-3xl text-blue-600 font-bold mb-10">
                <span>Card App</span>
            </div>
            <div class="w-full sm:shadow-xl sm:bg-white sm:py-10 sm:px-12">
                <div class="w-full text-2xl text-center text-gray-600 font-bold mb-8">Log in</div>
                <form @submit.prevent="authenticate">
                    <div class="w-full mb-5">
                        <input type="text" v-model="email" class="rounded-sm px-4 py-2 outline-none focus:outline-none border-gray-400 bg-gray-100 border-solid border-2 w-full text-sm"
                        placeholder="Enter email">
                    </div>
                    <div class="w-full mb-5">
                        <input type="password" v-model="password" class="rounded-sm px-4 py-2 outline-none focus:outline-none border-gray-400 bg-gray-100 border-solid border-2 w-full text-sm"
                        placeholder="Enter password">
                    </div>
                    <div class="w-full mb-6">
                        <button type="submit" class="rounded-sm px-4 py-2 text-sm bg-green-600 font-bold outline-none focus:outline-none hover:bg-opacity-75 w-full text-white disabled:opacity-25">Login</button>
                    </div>
                </form>
                <div class="bg-gray-300 h-px w-full mb-6"></div>

                <div class="text-center text-sm">
                    <router-link :to="{name: 'register'}" class="text-blue-600 hover:underline">Sign up</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Login from './graphql/Login.gql';

export default {
    data() {
        return {
            email: null,
            password: null
        };
    },
    methods: {
        authenticate() {
            this.$apollo.mutate({
                mutation: Login,
                variables: {
                    email: this.email,
                    password: this.password
                }
            });
        }
    }
}
</script>



<style scoped>
.container {
    width: 300px;
    max-width: 300px;
}
@media(min-width: 640px) {
    .container {
        width: 400px;
        min-width: 400px;
    }
}
</style>