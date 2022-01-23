<template>
    <div class="flex flex-col items-stretch">
        <div class="header text-white flex justify-between items-center mb-2 bg-purple-600">
            <div class="ml-2 w-1/3">x</div>
            <div class="text-lg opacity-50 cursor-pointer hover:opacity-80" >Card-App</div>
            <div class="mr-2 w-1/3 flex justify-end">x</div>
        </div>
        <div class="h-full flex flex-1 flex-col items-stretch">
            <div class="mx-5 mb-2 text-white font-bold text-lg">Title</div>
            <div class="flex flex-1 items-start overflow-x-auto mx-2">
                <div class="bg-gray-200 rounded-sm p-2 mr-2 list">
                    <div class="flex justify-between">
                        <div class="text-gray-700 pl-2 pb-2 font-bold">List Title</div>
                    </div>
                    <div class="card bg-white rounded-sm p-2 cursor-pointer text-sm hover:bg-gray-50 mb-2">fdf</div>
                    <div class="card bg-white rounded-sm p-2 cursor-pointer text-sm hover:bg-gray-50 mb-2">fdf</div>
                    <div class="card bg-white rounded-sm p-2 cursor-pointer text-sm hover:bg-gray-50 mb-2">fdf</div>
                    <div class=" text-gray-600 rounded-sm p-2 cursor-pointer hover:bg-gray-400 hover:text-gray-700 text-sm">Add new card</div>
                </div>
            </div>
      </div>
    </div>
</template>

<script>

</script>

<style scoped>
.header {
    height: 50px;
}

.list{
    width: 200px;
}

.card {
    box-shadow: 0 1px 0 rgba(9, 30, 66, 0.25);
}
</style>