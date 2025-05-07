<template>
    <Navbar />
    <main class="container mx-auto px-4" role="main">
        <h1 class="text-center text-3xl md:text-5xl p-4" @click="Welcome" role="heading" aria-level="1">
            Lista de Categories
        </h1>
        <div class="text-center text-lg md:text-xl p-4">
            <button 
                @click="CreateCategories" 
                class="w-full md:w-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                aria-label="Crear nueva categoría"
            >
                Crear Categorias
            </button>
        </div>

        <div class="search-container text-center" role="search">
            <label for="category-search" class="sr-only">Buscar categorías</label>
            <input 
                id="category-search"
                type="text" 
                v-model="search" 
                placeholder="Buscar por nombre..." 
                class="w-full md:w-1/2 px-4 py-2 border rounded-lg shadow-sm"
                aria-label="Buscar categorías por nombre"
            />
        </div>

        <!-- Tabla Responsive -->
        <div class="overflow-x-auto p-4" role="region" aria-label="Lista de categorías">
            <table class="w-full border min-w-[600px]" role="grid">
                <thead>
                    <tr class="bg-gray-400 text-left">
                        <th scope="col" class="p-2 border border-black">Name</th>
                        <th scope="col" class="p-2 border border-black">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="category in filteredCategories" :key="category.id" role="row">
                        <td class="p-2 border border-black" role="cell">{{ category.name }}</td>
                        <td class="p-2 border border-black" role="cell">
                            <div class="flex gap-2">
                                <Link 
                                    :href="route('categories.edit', category.id)" 
                                    class="text-blue-500 hover:underline"
                                    aria-label="Editar categoría"
                                >
                                    Editar
                                </Link>
                                <button 
                                    @click="DeleteCategories(category.id)" 
                                    class="text-red-500 hover:underline"
                                    aria-label="Eliminar categoría"
                                >
                                    Eliminar
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
    <Footer />
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';

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

// function DeleteCategories(id) {
//   router.delete(route('categories.destroy', id), {
//     preserveScroll: true,
//     onSuccess: () => {
//         zapato.value = category.value.filter(category => category.id !== id);
//     }
//   });
// }


function Welcome(){
    router.visit('/');
}

function CreateCategories(){
    router.visit('categories/create');
}
</script>