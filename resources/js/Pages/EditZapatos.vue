<template>
    <Navbar />
    <div class="container mx-auto px-4">
        <h1 class="text-xl md:text-2xl font-bold mb-4">Editar Zapatos</h1>
        <div class="bg-white p-4 border rounded">
            <form @submit.prevent="submit" enctype="multipart/form-data" class="max-w-2xl mx-auto">
                <div class="mb-3">
                    <label for="name" class="block mb-1">name:</label>
                    <input type="text" id="name" v-model="form.name" class="w-full border p-2 rounded" required />
                </div>

                <div class="mb-3">
                    <label for="description" class="block mb-1">description:</label>
                    <input type="text" id="description" v-model="form.description" class="w-full border p-2 rounded" required />
                </div>  

                <div class="mb-3">
                    <label for="number" class="block mb-1">number:</label>
                    <input type="text" id="number" v-model="form.number" class="w-full border p-2 rounded" required />
                </div> 

                <div class="mb-3">
                    <label for="categories" class="block mb-1">categories:</label>
                    <select id="category" v-model="form.category_id" required>
                        <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                    </select>
                </div>   

                <div class="mb-3">
                    <label for="photo" class="block mb-1">Foto:</label>
                    <input
                        type="file"
                        id="photo"
                        accept="image/*"
                        @input="handleImageChange"
                        class="w-full border p-2 rounded"
                    />
                    <div class="p-2 text-left">
                        <img v-if="previewImage" class="w-20" :src="previewImage" :alt="form.name">
                        <img v-else-if="zapatos.photo" class="w-20" :src="`/storage/${zapatos.photo}`" :alt="zapatos.name">
                    </div>
                </div>

                <div class="flex flex-col md:flex-row justify-between mt-4 space-y-2 md:space-y-0">
                    <Link :href="route('zapatos.index')" class="w-full md:w-auto text-center bg-gray-300 px-3 py-1 rounded">
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
    zapatos: Object,
    categories: Array,
});

const previewImage = ref(null);

const form = useForm({
    name: '',
    description: '',
    number: '',
    category_id: '',
    photo: null,
    _method: 'put',
});

const handleImageChange = (event) => {
    const file = event.target.files[0];
    form.photo = file;
    
    if (file) {
        previewImage.value = URL.createObjectURL(file);
    }
};

onMounted(() => {
    if (props.zapatos) {
        form.name = props.zapatos.name;
        form.description = props.zapatos.description;
        form.number = props.zapatos.number;
        form.category_id = props.zapatos.category_id;
    }
});

function submit() {
    form.post(route('zapatos.update', props.zapatos.id));
}
</script>

