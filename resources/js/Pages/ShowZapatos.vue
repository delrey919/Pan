<template>
    <div class="text-xl p-4 text-center">
        Show de {{ zapatos.name }}
    </div>
    <div class="p-8 text-center text-black ">
        <table class="w-full">
            <tbody>
                <tr class="bg-gray-400 text-left">
                    <th class="p-2 border border-black">ID</th>
                    <th class="p-2 border border-black">name</th>
                    <th class="p-2 border border-black">description</th>
                    <th class="p-2 border border-black">number</th>
                    <th class="p-2 border border-black">Categoría</th>
                    <th class="p-2 border border-black">Foto</th>
                </tr>

                <tr class="border-t">
                    <td class="p-2 border border-black">{{ zapatos.id }}</td>
                    <td class="p-2 border border-black">{{ zapatos.name }}</td>
                    <td class="p-2 border border-black">{{ zapatos.description }}</td>
                    <td class="p-2 border border-black">{{ zapatos.number }}</td>
                    <td class="p-2 border border-black">
                        {{ zapatos.category?.name || 'Sin categoría' }}
                    </td>
                    <td class="p-2 border border-black">
                        <img
                            v-if="zapatos.photo"
                            :src="getImageUrl(zapatos.photo)"
                            alt="foto zapato"
                            class="w-32 h-32 object-cover rounded"
                        />
                        <span v-else>No hay imagen</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" class="p-2 text-center"></td>
                </tr>
            </tbody>

        </table>
    </div>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    zapatos: Object,
});

// Helper para convertir ruta de foto en URL pública
const getImageUrl = path => `/storage/${path}`
</script>