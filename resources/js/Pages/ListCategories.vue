<template>
    <div class="text-center text-5xl p-4" @click="Welcome">
        Lista de categories
    </div>
    <div class="text-center text-xl p-4">
        <button @click="CreateCategories" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
            Crear Categorias
        </button>
    </div>
    <div class="p-8">

        <table class="w-full border ">
            <tbody >
                <tr class="bg-gray-400 text-left">
                    <th class="p-2 border border-black">Name</th>
                    <th class="p-2 border border-black">Acciones</th>
                </tr>
                <tr v-for="category in categories" :key="categories.id">
                    <td class="p-2 border border-black">{{ category.name }}</td>
                    <td class="p-2 border border-black">
                        <div>
                            <Link :href="route('categories.edit', category.id)" class="text-blue-500"> Editar </Link>
                            <button @click="DeleteCategories(category.id)" class="text-red-500">Eliminar </button>

                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
    categories: Array,
});

function DeleteCategories(id){
    router.delete(route('categories.destroy', id))
}
function Welcome(){
    router.visit('/');
}

function CreateCategories(){
    router.visit('categories/create');
}

</script>