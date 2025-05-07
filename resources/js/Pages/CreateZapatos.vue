<template>
    <Navbar />
    <div class="container mx-auto px-4">
        <h1 class="text-xl md:text-2xl font-bold mb-4">Crear Zapatos</h1>
        <div class="bg-white p-4 border rounded">
            <form @submit.prevent="submit" enctype="multipart/form-data" class="max-w-2xl mx-auto">
                <div class="mb-3">
                    <label for="name" class="block mb-1">name:</label>
                    <input type="text" id="name" v-model="form.name" class="w-full border p-2 rounded" required />
                </div>

                <div class="mb-3">
                    <label for="description" class="block mb-1">Description:</label>
                    <input type="text" id="description" v-model="form.description" rows="3"
                        class="w-full border p-2 rounded" required></input>
                </div>
                <div class="mb-3">
                    <label for="number" class="block mb-1">number:</label>
                    <input type="text" id="number" v-model="form.number" rows="3" class="w-full border p-2 rounded"
                        required></input>
                </div>
                <div class="mb-3">
                    <label for="category" class="block mb-1">Categoria:</label>
                    <select id="category_id" v-model="form.category_id" required>
                        <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name
                            }}</option>
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
    categories: Array,
});

const previewImage = ref(null);

const form = useForm({
    name: '',
    description: '',
    number: '',
    category_id: '',
    photo: null,
});

const handleImageChange = (event) => {
    const file = event.target.files[0];
    form.photo = file;
    
    if (file) {
        previewImage.value = URL.createObjectURL(file);
    }
};

function submit() {
    form.post(route('zapatos.store'));
}
</script>