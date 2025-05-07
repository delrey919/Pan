<template>
    <Navbar />
    <div class="container mx-auto px-4">
        <div class="text-center text-3xl md:text-5xl p-4" @click="Welcome">
            Lista de Categories
        </div>
        <div class="text-center text-lg md:text-xl p-4">
            <button @click="CreateCategories" class="w-full md:w-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Crear Categorias
            </button>
        </div>

        <div class="search-container text-center">
            <input 
                type="text" 
                v-model="search" 
                placeholder="Buscar por nombre..." 
                class="w-full md:w-1/2 px-4 py-2 border rounded-lg shadow-sm"
            />
        </div>

        <!-- Tabla Responsive -->
        <div class="overflow-x-auto p-4">
            <table class="w-full border min-w-[600px]">
                <tbody>
                    <tr class="bg-gray-400 text-left">
                        <th class="p-2 border border-black">Name</th>
                        <th class="p-2 border border-black">Acciones</th>
                    </tr>
                    <tr v-for="category in filteredCategories" :key="category.id">
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
    </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Navbar from '@/Components/Navbar.vue';

const search = ref('');

const props = defineProps({
    categories: Array,
});

const filteredCategories = computed(() =>
    props.categories.filter(category =>
        category.name.toLowerCase().includes(search.value.toLowerCase())
    )
);

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