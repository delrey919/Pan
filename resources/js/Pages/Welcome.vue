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
    <div class="text-center text-xl p-4">
        <button @click="CreateCategories" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
            Crear Categorias
        </button>
    </div>

    <!-- Carrusel de Imágenes Estáticas -->
    <div class="w-full max-w-4xl mx-auto mt-10">
        <div class="relative overflow-hidden rounded-xl shadow-lg">
            <img
                :src="getImageUrl(images[currentIndex])"
                :alt="imageNames[currentIndex]"
                class="w-full h-64 object-cover transition-all duration-500"
            />
            <div class="absolute bottom-0 w-full bg-black bg-opacity-50 text-white p-4">
                <div class="text-center text-lg font-semibold">
                    {{ imageNames[currentIndex] }}
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
                v-for="(_, index) in images"
                :key="index"
                @click="goToImage(index)"
                class="w-3 h-3 rounded-full cursor-pointer transition-all duration-300"
                :class="{ 'bg-gray-800': index === currentIndex, 'bg-gray-400': index !== currentIndex }"
            />
        </div>
    </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';
import Navbar from '@/Components/Navbar.vue';

const currentIndex = ref(0);
const autoplayInterval = ref(null);

// Array de nombres de imágenes en la carpeta public/images
const images = [
    'zapato1.jpeg',
    'zapato2.jpg',
    'zapato3.jpg',
];

// Nombres descriptivos para cada imagen
const imageNames = [
    'Zapatos Deportivos',
    'Zapatos Casuales',
    'Zapatos Formales',
];

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
    currentIndex.value = (currentIndex.value + 1) % images.length;
};

const prevImage = () => {
    currentIndex.value = (currentIndex.value - 1 + images.length) % images.length;
};

const goToImage = (index) => {
    currentIndex.value = index;
};

const getImageUrl = (path) => `/images/${path}`;

onMounted(() => {
    autoplayInterval.value = setInterval(nextImage, 3000);
});

onUnmounted(() => {
    if (autoplayInterval.value) {
        clearInterval(autoplayInterval.value);
    }
});
</script>