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
                </tr>

                <tr class="border-t">
                    <td class="p-2 border border-black">{{ zapatos.id }}</td>
                    <td class="p-2 border border-black">{{ zapatos.name }}</td>
                    <td class="p-2 border border-black">{{ zapatos.description }}</td>
                    <td class="p-2 border border-black">{{ zapatos.number }}</td>

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

</script>