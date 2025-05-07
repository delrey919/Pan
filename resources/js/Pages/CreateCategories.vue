<template>
    <Navbar />
    <div class="container mx-auto px-4">
        <h1 class="text-xl md:text-2xl font-bold mb-4">Crear Categoría</h1>
        <div class="bg-white p-4 border rounded">
            <form @submit.prevent="submit" class="max-w-2xl mx-auto">
                <div class="mb-3">
                    <label for="name" class="block mb-1">name:</label>
                    <input
                        type="text"
                        id="name"
                        v-model="form.name"
                        class="w-full border p-2 rounded"
                        required
                    />
                </div>
                <div class="flex flex-col md:flex-row justify-between mt-4 space-y-2 md:space-y-0">
                    <Link :href="route('categories.index')" class="w-full md:w-auto text-center bg-gray-300 px-3 py-1 rounded">
                        Cancelar
                    </Link>
                    <button type="submit" class="w-full md:w-auto bg-blue-500 text-white px-3 py-1 rounded">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { defineProps, onMounted, ref } from 'vue';
import Navbar from '@/Components/Navbar.vue';

const props = defineProps({
    categories: Array,
});

const form = useForm({
    name: '',    
});

function submit() {
    form.post(route('categories.store'));
}
</script>