<template>
    <Navbar />
    <div class="min-h-screen flex flex-col">
        <main class="container mx-auto px-4 flex-grow" role="main">
            <h1 class="text-xl md:text-2xl font-bold mb-4 mt-6" role="heading" aria-level="1">Editar Categoría</h1>
            <div class="bg-white p-4 border rounded shadow mb-8">
                <form @submit.prevent="submit" class="max-w-2xl mx-auto" role="form" aria-label="Formulario de edición de categoría">
                    <div class="mb-3">
                        <label for="name" class="block mb-1 font-medium">Nombre de la categoría:</label>
                        <input 
                            type="text" 
                            id="name" 
                            v-model="form.name" 
                            class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                            required
                            aria-required="true"
                            aria-label="Nombre de la categoría"
                        />
                    </div>

                    <div class="flex flex-col md:flex-row justify-between mt-4 space-y-2 md:space-y-0 md:space-x-4">
                        <Link 
                            :href="route('categories.index')" 
                            class="w-full md:w-auto text-center bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded transition duration-200"
                            role="button"
                            aria-label="Cancelar edición de categoría"
                        >
                            Cancelar
                        </Link>
                        <button 
                            type="submit" 
                            class="w-full md:w-auto bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded transition duration-200"
                            aria-label="Guardar cambios"
                        >
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </main>
        <Footer />
    </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';

const props = defineProps({
    category: Object,
});

const form = useForm({
    name: props.category.name,
});

function submit() {
    form.put(route('categories.update', props.category.id));
}
</script>