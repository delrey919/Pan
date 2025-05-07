<template>
    <div class="text-center text-5xl p-4" @click="Welcome">
        Lista de Zapatos
    </div>
    <div class="text-center text-xl p-4">
        <button @click="CreateZapatos" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
            Crear Zapatos
        </button>
    </div>
    <div class="search-container text-center">
        <input 
          type="text" 
          v-model="search" 
          placeholder="Buscar por nombre o categoría..." 
          class="px-4 py-2 border rounded-lg shadow-sm "
        />
      </div>
    <div class="p-8">

        <table class="w-full border ">
            <tbody >
                <tr class="bg-gray-400 text-left">
                    <th class="p-2 border border-black">Name</th>
                    <th class="p-2 border border-black">Description</th>
                    <th class="p-2 border border-black">Number</th>
                    <th class="p-2 border border-black">Categoria</th>
                    <th class="p-2 border border-black">Foto</th>
                    <th class="p-2 border border-black">Acciones</th>
                </tr>
                <tr v-for="zapato in filteredEvents" :key="zapato.id">
                    <td class="p-2 border border-black">{{ zapato.name }}</td>
                    <td class="p-2 border border-black">{{ zapato.description }}</td>
                    <td class="p-2 border border-black">{{ zapato.number }}</td>
                    <td class="p-2 border border-black">{{ zapato.category?.name || 'No Sale' }}</td>
                    <td class="p-2 border border-black">
                        <img
                            v-if="zapato.photo"
                            :src="`/storage/${zapato.photo}`"
                            alt="foto zapato"
                            class="w-16 h-16 object-cover rounded"
                        />
                        <span v-else>No</span>
                    </td>
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
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, defineProps, computed } from 'vue';
import axios from 'axios';

const props = defineProps({
    zapatos: Array,
    
});

const search = ref('')

function DeleteZapatos(id){
    router.delete(route('zapatos.destroy', id))
}
function Welcome(){
    router.visit('/');
}

function CreateZapatos(){
    router.visit('zapatos/create');
}

const filteredEvents = computed(() =>
  props.zapatos.filter(event =>
    event.name.toLowerCase().includes(search.value.toLowerCase()) ||
    (event.category && event.category.name &&
      event.category.name.toLowerCase().includes(search.value.toLowerCase()))
  )
);

</script>