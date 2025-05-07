<template>
    <Navbar />
    <div class="text-center text-5xl p-4" @click="Welcome">
        Lista de Zapatos
    </div>
    <div class="text-center text-xl p-4">
        <button @click="CreateZapatos" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
            Crear Zapatos
        </button>
    </div>

    <div class="search-container text-center mt-8">
        <input 
          type="text" 
          v-model="search" 
          placeholder="Buscar por nombre o categoría..." 
          class="px-4 py-2 border rounded-lg shadow-sm"
        />
    </div>
    <div class="p-8">
        <table class="w-full border">
            <tbody>
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
    <!-- Carrusel de Zapatos -->
    <div v-if="props.zapatos.length > 0" class="w-full max-w-4xl mx-auto mt-10 mb-16">
        <div class="relative overflow-hidden rounded-xl shadow-lg">
            <img
                :src="getImageUrl(props.zapatos[currentIndex].photo)"
                :alt="props.zapatos[currentIndex].name"
                class="w-full h-64 object-cover transition-all duration-500"
            />
            <div class="absolute bottom-0 w-full bg-black bg-opacity-50 text-white p-4">
                <div class="text-center text-lg font-semibold">
                    {{ props.zapatos[currentIndex].name }} – {{ props.zapatos[currentIndex].category?.name || 'Sin categoría' }}
                </div>
            </div>
            <button @click="prevImage"
                class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white px-3 py-1 rounded-full hover:bg-opacity-75">
                ‹
            </button>
            <button @click="nextImage"
                class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white px-3 py-1 rounded-full hover:bg-opacity-75">
                ›
            </button>
        </div>
        <div class="flex justify-center mt-4 space-x-2">
            <span
                v-for="(zapato, index) in props.zapatos"
                :key="zapato.id"
                @click="goToImage(index)"
                class="w-3 h-3 rounded-full cursor-pointer transition-all duration-300"
                :class="{ 'bg-gray-800': index === currentIndex, 'bg-gray-400': index !== currentIndex }"
            />
        </div>
    </div>
    <div v-else class="w-full max-w-4xl mx-auto mt-10 mb-16 text-center text-gray-600">
        No hay zapatos disponibles
    </div>

</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, defineProps, computed, onMounted, onUnmounted } from 'vue';
import axios from 'axios';
import Navbar from '@/Components/Navbar.vue';

const props = defineProps({
    zapatos: Array,
});

const search = ref('');
const currentIndex = ref(0);
const autoplayInterval = ref(null);

function DeleteZapatos(id) {
  router.delete(route('zapatos.destroy', id), {
    preserveScroll: true,
    onSuccess: () => {
        zapato.value = zapato.value.filter(zapato => zapato.id !== id);
    }
  });
}

function Welcome(){
    router.visit('/');
}

function CreateZapatos(){
    router.visit('zapatos/create');
}

const nextImage = () => {
    if (props.zapatos.length > 0) {
        currentIndex.value = (currentIndex.value + 1) % props.zapatos.length;
    }
};

const prevImage = () => {
    if (props.zapatos.length > 0) {
        currentIndex.value =
            (currentIndex.value - 1 + props.zapatos.length) %
            props.zapatos.length;
    }
};

const goToImage = (index) => {
    if (props.zapatos.length > 0) {
        currentIndex.value = index;
    }
};

const getImageUrl = (path) => `/storage/${path}`;

const filteredEvents = computed(() =>
  props.zapatos.filter(event =>
    event.name.toLowerCase().includes(search.value.toLowerCase()) ||
    (event.category && event.category.name &&
      event.category.name.toLowerCase().includes(search.value.toLowerCase()))
  )
);

onMounted(() => {
  if (props.zapatos.length > 0) {
    autoplayInterval.value = setInterval(nextImage, 3000);
  }
});

onUnmounted(() => {
  if (autoplayInterval.value) {
    clearInterval(autoplayInterval.value);
  }
});
</script>