<template>
    <transition name="appear">
        <div v-on-clickaway="close" 
        v-if="show" 
        class="dropdown absolute bg-gray-100 rounded-sm mt-2 text-sm text-gray-600 border-gray-200 shadow w-64 overflow-y-auto z-100 p-2">
            <slot></slot>
        </div>
    </transition>
</template>

<script>
import { directive as onClickaway } from "vue-clickaway";

export default {
    props: {
        show: Boolean()
    },
    directives: { onClickaway },
    methods: {
        close() {
            this.$emit("closed");
        }
    }
}
</script>

<style scoped>
.dropdown {
    max-height: 90%;
}
</style>