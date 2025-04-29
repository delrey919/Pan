<template>
    <div class="container mx-auto p-4">
        <h1 class="text-xl font-bold mb-4">Editar zapatos</h1>

        <div class="bg-white p-4 border rounded">
            <form @submit.prevent="submit">
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

                <div class="flex justify-between mt-4">
                    <Link :href="route('zapatos.index')" class="bg-gray-300 px-3 py-1 rounded">
                    Cancelar
                    </Link>
                    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">
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

const props = defineProps({
    zapatos: Object,
});

const form = useForm({
    name: '',
    description: '',
    number: '',
    _method: 'put',
});

onMounted(() => {
    if (props.zapatos) {
        form.name = props.zapatos.name;
        form.description = props.zapatos.description;
        form.number = props.zapatos.number;
    }
});

function submit() {
    form.post(route('zapatos.update', props.zapatos.id));
}
</script>