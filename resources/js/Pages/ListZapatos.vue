<template>
    <div class="text-center text-5xl p-4" @click="Welcome">
        Lista de Zapatos
    </div>
    <div class="text-center text-xl p-4">
        <button @click="CreateZapatos" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
            Crear Zapatos
        </button>
    </div>
    <div class="p-8">

        <table class="w-full border ">
            <tbody >
                <tr class="bg-gray-400 text-left">
                    <th class="p-2 border border-black">Name</th>
                    <th class="p-2 border border-black">Description</th>
                    <th class="p-2 border border-black">Number</th>
                    <th class="p-2 border border-black">Acciones</th>
                </tr>
                <tr v-for="zapato in zapatos" :key="zapatos.id">
                    <td class="p-2 border border-black">{{ zapato.name }}</td>
                    <td class="p-2 border border-black">{{ zapato.description }}</td>
                    <td class="p-2 border border-black">{{ zapato.number }}</td>
                    <td class="p-2 border border-black">
                        <div>
                            <Link :href="route('zapatos.show', zapato.id)" class="text-green-500"> Ver </Link>
                        <Link :href="route('zapatos.edit', zapato.id)" class="text-blue-500"> Editar </Link>
                        <button @click="DeleteZapatos(zapato.id)" class="text-red-500">Eliminar </button>

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
    zapatos: Array,
});

function DeleteZapatos(id){
    router.delete(route('zapatos.destroy', id))
}
function Welcome(){
    router.visit('/');
}

function CreateZapatos(){
    router.visit('zapatos/create');
}

</script>