<template>
    <Navbar />
    <div class="container mx-auto px-4">
        <div class="text-center text-3xl md:text-5xl p-4" @click="Welcome">
            Lista de Zapatos
        </div>
        <div class="text-center text-lg md:text-xl p-4 space-y-2 md:space-y-0 md:space-x-4">
            <button @click="CreateZapatos" class="w-full md:w-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Crear Zapatos
            </button>
            <button @click="CreateCategories" class="w-full md:w-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Crear Categorias
            </button>
        </div>

        <!-- Carrusel de Imágenes -->
        <div class="w-full max-w-4xl mx-auto mt-10">
            <div class="relative overflow-hidden rounded-xl shadow-lg">
                <img
                    :src="getImageUrl(images[currentImageIndex])"
                    :alt="imageNames[currentImageIndex]"
                    class="w-full h-48 md:h-64 object-cover transition-all duration-500"
                />
                <div class="absolute bottom-0 w-full bg-black bg-opacity-50 text-white p-4">
                    <div class="text-center text-lg font-semibold">
                        {{ imageNames[currentImageIndex] }}
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
                    :class="{ 'bg-gray-800': index === currentImageIndex, 'bg-gray-400': index !== currentImageIndex }"
                />
            </div>
        </div>

        <!-- Carrusel de Texto
        <div class="w-full max-w-4xl mx-auto mt-10 mb-16">
            <div class="relative overflow-hidden rounded-xl shadow-lg bg-gradient-to-r from-blue-500 to-purple-600 p-8">
                <div class="relative h-32">
                    <transition-group 
                        name="slide" 
                        tag="div" 
                        class="absolute w-full"
                    >
                        <div 
                            v-for="(zapato, index) in zapatos" 
                            :key="zapato.id"
                            v-show="currentTextIndex === index"
                            class="text-center text-white"
                        >
                            <h2 class="text-2xl md:text-3xl font-bold mb-4">{{ zapato.name }}</h2>
                            <p class="text-lg md:text-xl">{{ zapato.description }}</p>
                            <p class="text-md mt-2">Categoría: {{ zapato.category?.name || 'Sin categoría' }}</p>
                            <p class="text-md">Número: {{ zapato.number }}</p>
                        </div>
                    </transition-group>
                </div>
                
                Controles del carrusel de texto
                <div class="flex justify-center mt-6 space-x-4">
                    <button @click="prevText"
                        class="bg-white bg-opacity-20 text-white px-4 py-2 rounded-full hover:bg-opacity-30 transition-all">
                        Anterior
                    </button>
                    <button @click="nextText"
                        class="bg-white bg-opacity-20 text-white px-4 py-2 rounded-full hover:bg-opacity-30 transition-all">
                        Siguiente
                    </button>
                </div> 

                Indicadores del carrusel de texto
                <div class="flex justify-center mt-4 space-x-2">
                    <span
                        v-for="(_, index) in zapatos"
                        :key="index"
                        @click="goToText(index)"
                        class="w-3 h-3 rounded-full cursor-pointer transition-all duration-300"
                        :class="{ 'bg-white': index === currentTextIndex, 'bg-white bg-opacity-50': index !== currentTextIndex }"
                    />
                </div> 
            </div> 
        </div> -->
    </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';
import Navbar from '@/Components/Navbar.vue';

const currentImageIndex = ref(0);
const currentTextIndex = ref(0);
const imageAutoplayInterval = ref(null);
const textAutoplayInterval = ref(null);

// Props para recibir los datos de las tablas
const props = defineProps({
    zapatos: {
        type: Array,
        required: true
    }
});

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

// Funciones para el carrusel de imágenes
const nextImage = () => {
    currentImageIndex.value = (currentImageIndex.value + 1) % images.length;
};

const prevImage = () => {
    currentImageIndex.value = (currentImageIndex.value - 1 + images.length) % images.length;
};

const goToImage = (index) => {
    currentImageIndex.value = index;
};

// Funciones para el carrusel de texto
const nextText = () => {
    currentTextIndex.value = (currentTextIndex.value + 1) % props.zapatos.length;
};

const prevText = () => {
    currentTextIndex.value = (currentTextIndex.value - 1 + props.zapatos.length) % props.zapatos.length;
};

const goToText = (index) => {
    currentTextIndex.value = index;
};

const getImageUrl = (path) => `/images/${path}`;

onMounted(() => {
    // Autoplay para el carrusel de imágenes
    imageAutoplayInterval.value = setInterval(nextImage, 3000);
    // Autoplay para el carrusel de texto
    textAutoplayInterval.value = setInterval(nextText, 5000);
});

onUnmounted(() => {
    if (imageAutoplayInterval.value) {
        clearInterval(imageAutoplayInterval.value);
    }
    if (textAutoplayInterval.value) {
        clearInterval(textAutoplayInterval.value);
    }
});
</script>

<style scoped>
.slide-enter-active,
.slide-leave-active {
    transition: all 0.5s ease;
}

.slide-enter-from {
    opacity: 0;
    transform: translateX(100%);
}

.slide-leave-to {
    opacity: 0;
    transform: translateX(-100%);
}

.slide-enter-to,
.slide-leave-from {
    opacity: 1;
    transform: translateX(0);
}
</style>