<template>
    <div v-if="errors.length" class="p-2  text-red-600 rounded-sm text-center">
        <div v-for="(error, index) in errors" :key="index">{{ error.message }}</div>
    </div>
</template>

<script>

export default {
    props: {
        errors: {
            type: Array,
            default: [],
        }
    }
}
</script>
