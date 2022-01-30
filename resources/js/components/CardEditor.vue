<template>
    <div>
        <textarea 
        :value="value" 
        class="shadow-card rounded-md py-1 px-2 outline-none w-full text-gray-700 text-sm bg-white h-16 resize-none" 
        placeholder="Enter text for this card" 
        ref="card" 
        @keyup.esc="closed" 
        @keyup.enter="saved"
        @input="$emit('input', $event.target.value)">
        </textarea>
        <div class="flex">
            <button @click="saved" class="rounded-sm py-1 px-2 bg-indigo-600 text-white cursor-pointer hover:bg-indigo-400 outline-none">{{ label }}</button>
            <button @click="closed" class="rounded-md py-1 ml-1 px-2 cursor-pointer outline-none hover:bg-gray-400 text-gray-600">Cancel</button>
        </div>
    </div>
</template>

<script>

export default {
    props: ["value", "label"],
    methods: {
        closed() {
            this.$emit("closed");
        },
        saved() {
            this.$emit("saved");
        }
    }
}
</script>

