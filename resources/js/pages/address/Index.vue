<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Direcciones',
        href: '/addresses',
    },
];

defineProps<{
    addresses: {
        id: number;
        name: string;
    }[];
}>();



function deleteUser(id: number) {
    if(confirm('¿Está seguro de que desea eliminar esta dirección?')) {
        router.delete(route('addresses.destroy',id));
    } else {
        console.log('Eliminación cancelada');

    }
}

</script>

<template>
    <Head title="Address" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="overflow-x-auto p-3">
            <Link 
                :href="route('addresses.create')"
                class="cursor-pointer px-3 py-2 mb-4 text-xs font-medium text-white bg-green-700 border-r-4 rounded border-green-800">
                Nuevo
            </Link>

            <table class="mt-3 w-full text-sn text-left rtl:text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Numero</th>
                        <th scope="col" class="px-6 py-3">Nombre</th>
                        <th scope="col" class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody >
                <tr v-for="(address,index) in addresses" class="odd:bg-white odd:dark:bg-gray-900 even:dark:bg-gray-800 ">
                    <td class="px-6 py-2 font-medium text-gray-900 dark:text-white" >{{ index+1 }}</td>
                    <td class="px-6 py-2 text-gray-600 dark:text-gray-300" >{{ address.name }}</td>
                    <td class="px-6 py-2">
                        <Link
                            :href="route('addresses.edit', address.id)"
                            class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded">
                            Editar
                        </Link>
                        <button
                             @click="deleteUser(address.id)"
                            class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-red-700  rounded ml-2">
                            Eliminar
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>