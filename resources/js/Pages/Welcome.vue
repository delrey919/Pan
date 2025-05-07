<template>
    <div class="text-center text-5xl p-4" @click="Welcome">
        Lista de Zapatos
    </div>
    <div class="text-center text-xl p-4">
        <button @click="CreateZapatos" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
            Crear Zapatos
        </button>
    </div>
    <div class="text-center text-xl p-4">
        <button @click="CreateCategories" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
            Crear Categorias
        </button>
    </div>

    <!-- Carrusel de Zapatos -->
    <div v-if="props.zapatos.length > 0" class="w-full max-w-4xl mx-auto mt-10">
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
    <div v-else class="w-full max-w-4xl mx-auto mt-10 text-center text-gray-600">
        No hay zapatos disponibles
    </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    zapatos: {
        type: Array,
        default: () => [],
    },
});

const currentIndex = ref(0);
const autoplayInterval = ref(null);

function DeleteZapatos(id){
    router.delete(route('zapatos.destroy', id))
}
function Welcome(){
    router.visit('/');
}

function CreateZapatos(){
    router.visit('zapatos/create');
}
function CreateCategories(){
    router.visit('categories/create');
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