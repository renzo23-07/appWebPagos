<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import { Phone,MapPin } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Clientes',
        href: '/customers',
    },
];

defineProps<{
    customers: {
        id: number;
        customer_name: string;
        cellNumber:string;
        address_name:string
    }[];
}>();



function deleteCustomer(id: number) {
    if(confirm('¿Está seguro de que desea inhabilitar este cliente?')) {
        router.delete(route('customers.destroy',id));
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
                :href="route('customers.create')"
                class="cursor-pointer px-3 py-2 mb-4 text-xs font-medium text-white bg-green-700 border-r-4 rounded border-green-800">
                Nuevo
            </Link>
            <div>
                <input
                type="text"
                placeholder="Buscar por nombre"
                class="mb-4 w-70 h-8 mt-6 px-4 py-2 border border-gray-300 rounded "
            />
            </div>
            

            <table class="hidden md:table mt-3 w-full text-sn text-left rtl:text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 ">Numero</th>
                        <th scope="col" class="px-6 py-3">Nombre</th>
                        <th scope="col" class="px-6 py-3">N° Celular</th>
                        <th scope="col" class="px-6 py-3">Dirección</th>
                        <th scope="col" class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody >
                <tr v-for="(customer,index) in customers"  class="odd:bg-white odd:dark:bg-gray-900 even:dark:bg-gray-800 ">
                    <td class="px-6 py-2 font-medium text-gray-900 dark:text-white" >{{ index+1 }}</td>
                    <td class="px-6 py-2 text-gray-600 dark:text-gray-300" >{{ customer.customer_name }}</td>
                    <td class="px-6 py-2 text-gray-600 dark:text-gray-300" >{{ customer.cellNumber }}</td>
                    <td class="px-6 py-2 text-gray-600 dark:text-gray-300" >{{ customer.address_name }}</td>
                    <td class="px-6 py-2">
                        <Link
                            :href="route('customers.edit', customer.id)"
                            class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded">
                            Editar
                        </Link>
                        <button
                             @click="deleteCustomer(customer.id)"
                            class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-red-700  rounded ml-2">
                            Eliminar
                        </button>
                        <Link
                            :href="route('transactions.show',customer.id)"
                            class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded ml-2">
                            Ir
                        </Link>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="md:hidden space-y-4 mt-4">
                <div v-for="customer in customers" className="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                    <div className="p-5">
                        <div className="flex items-start justify-between mb-3">
                            <div className="flex-1">
                                <div className="flex items-center gap-2 mb-2">
                                    <h3 className="font-bold text-lg text-gray-900">
                                        {{ customer.customer_name }}
                                    </h3>
                                </div>
                                <div className="space-y-2 text-sm text-gray-600">
                                    <p className="flex items-start gap-2">
                                        <MapPin className="w-4 h-4 mt-0.5 flex-shrink-0" />
                                        <span className="leading-tight">{{ customer.address_name }}</span>
                                    </p>
                                    <p className="flex items-center gap-2">
                                        <Phone className="w-4 h-4 flex-shrink-0" />
                                        {{ customer.cellNumber }}
                                    </p>
                                </div>
                                <div class="my-3 flex justify-between items-center">
                                    <div>
                                        <Link
                                        :href="route('customers.edit', customer.id)"
                                        class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded">
                                        Editar
                                        </Link>
                                        <button
                                            @click="deleteCustomer(customer.id)"
                                            class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-red-700  rounded ml-2">
                                            Eliminar
                                        </button>
                                    </div>
                                    
                                    <Link
                                        :href="route('transactions.show', customer.id)"
                                        class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded ml-2">
                                        Ir
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>