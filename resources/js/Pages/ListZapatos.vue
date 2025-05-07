<template>
    <Navbar />
    <main class="container mx-auto px-4" role="main">
        <h1 class="text-center text-3xl md:text-5xl p-4" @click="Welcome" role="heading" aria-level="1">
            Lista de Zapatos
        </h1>
        <div class="text-center text-lg md:text-xl p-4">
            <button 
                @click="CreateZapatos" 
                class="w-full md:w-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                aria-label="Crear nuevo zapato"
            >
                Crear Zapatos
            </button>
        </div>

        <div class="search-container text-center mt-8" role="search">
            <label for="zapato-search" class="sr-only">Buscar zapatos</label>
            <input 
                id="zapato-search"
                type="text" 
                v-model="search" 
                placeholder="Buscar por nombre o categoría..." 
                class="w-full md:w-1/2 px-4 py-2 border rounded-lg shadow-sm"
                aria-label="Buscar zapatos por nombre o categoría"
            />
        </div>

        <!-- Tabla Responsive -->
        <div class="overflow-x-auto p-4" role="region" aria-label="Lista de zapatos">
            <table class="w-full border min-w-[800px]" role="grid">
                <thead>
                    <tr class="bg-gray-400 text-left">
                        <th scope="col" class="p-2 border border-black">Name</th>
                        <th scope="col" class="p-2 border border-black">Description</th>
                        <th scope="col" class="p-2 border border-black">Number</th>
                        <th scope="col" class="p-2 border border-black">Categoria</th>
                        <th scope="col" class="p-2 border border-black">Foto</th>
                        <th scope="col" class="p-2 border border-black">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="zapato in filteredEvents" :key="zapato.id" role="row">
                        <td class="p-2 border border-black" role="cell">{{ zapato.name }}</td>
                        <td class="p-2 border border-black" role="cell">{{ zapato.description }}</td>
                        <td class="p-2 border border-black" role="cell">{{ zapato.number }}</td>
                        <td class="p-2 border border-black" role="cell">{{ zapato.category?.name || 'No Sale' }}</td>
                        <td class="p-2 border border-black" role="cell">
                            <img
                                v-if="zapato.photo"
                                :src="`/storage/${zapato.photo}`"
                                :alt="`Foto de ${zapato.name}`"
                                class="w-16 h-16 object-cover rounded"
                            />
                            <span v-else>No hay imagen</span>
                        </td>
                        <td class="p-2 border border-black" role="cell">
                            <div class="flex gap-2">
                                <Link 
                                    :href="route('zapatos.show', zapato.id)" 
                                    class="text-green-500 hover:underline"
                                    aria-label="Ver detalles del zapato"
                                >
                                    Ver
                                </Link>
                                <Link 
                                    :href="route('zapatos.edit', zapato.id)" 
                                    class="text-blue-500 hover:underline"
                                    aria-label="Editar zapato"
                                >
                                    Editar
                                </Link>
                                <button 
                                    @click="DeleteZapatos(zapato.id)" 
                                    class="text-red-500 hover:underline"
                                    aria-label="Eliminar zapato"
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
    <Footer />
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, defineProps, computed, onMounted, onUnmounted } from 'vue';
import axios from 'axios';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';

const props = defineProps({
    zapatos: Array,
});

const search = ref('');
const currentIndex = ref(0);
const autoplayInterval = ref(null);

// function DeleteZapatos(id){
//     router.delete(route('zapatos.destroy', id))
// }

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