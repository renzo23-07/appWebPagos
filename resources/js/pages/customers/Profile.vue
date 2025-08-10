<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import { Trash } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Perfil de Cliente',
        href: '/profile',
    },
];

defineProps<{
    customer: {
        id:string;
        name:string;
        cellNumber:string;
    };
    total_amount:string;
    customerTransaction:{
        action:string;
        type:string;
        date:string;
        amount:string;
        total_debt:string;
    }[];
}>();


</script>

<template>
    <Head title="Perfil" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="overflow-x-auto p-3">
            <Link 
                :href="route('customers.index')"
                class="cursor-pointer px-3 py-2 mb-4 text-xs font-medium text-white bg-green-700 border-r-4 rounded border-green-800">
                Atras
            </Link>
        </div>
        <div class="overflow-x-auto p-3">
            <h2>Nombre: {{ customer.name }}</h2>
            <h2>Numero de Celular: {{ customer.cellNumber }}</h2>
            <h2 class="font-bold">Tiene una deuda de: {{ total_amount }} </h2>

            <div class="my-6">
                <h2 class="font-bold">Historial de cuenta</h2>
            </div>
            <div class="flex justify-end">
                <Link :href="route('createCreditSales',customer.id)"
                class="cursor-pointer px-3 py-2 mb-4 text-xs font-medium text-white bg-red-700 rounded">Agregar Pedido
                </Link>
                <Link :href="route('payment.create', customer.id)"
                class="cursor-pointer px-3 py-2 mb-4 text-xs font-medium text-white bg-blue-700 rounded  ml-2">Agregar Pago</Link>
                <Link :href="route('creditSale.show',customer.id)"
                class="cursor-pointer px-3 py-2 mb-4 text-xs font-medium text-white bg-green-700 border-r-4 rounded border-green-800 ml-2" >Historial de Pedidos</Link>
                <Link :href="route('payment.show',customer.id)" 
                class="cursor-pointer px-3 py-2 mb-4 text-xs font-medium text-white bg-green-700 border-r-4 rounded border-green-800 ml-2" >Historial de Pagos</Link>
            </div>
            <table class=" hidden md:table mt-3 w-full text-sn text-left rtl:text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 ">#</th>
                        <th scope="col" class="px-6 py-3">Accion</th>
                        <th scope="col" class="px-6 py-3">Tipo</th>
                        <th scope="col" class="px-6 py-3">Fecha</th>
                        <th scope="col" class="px-6 py-3">Costo/Pago</th>
                        <th scope="col" class="px-6 py-3">Deuda</th>
                    </tr>
                </thead>
                <tbody >
                <tr v-for="(transaction,index) in customerTransaction.slice().reverse()" :key="customer.id" class="odd:bg-white odd:dark:bg-gray-900 even:dark:bg-gray-800 ">
                    <td class="px-6 py-2 font-medium text-gray-900 dark:text-white" >{{ index+1 }}</td>
                    <td class="px-6 py-2 text-gray-600 dark:text-gray-300" >{{ transaction.action }}</td>
                    <td class="px-6 py-2 text-gray-600 dark:text-gray-300" >{{ transaction.type }}</td>
                    <td class="px-6 py-2 text-gray-600 dark:text-gray-300" >{{ transaction.date }}</td>
                    <td class="px-11 py-2" :class="transaction.type === 'pago' ? 'text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-300'" >{{ transaction.amount }}</td>
                    <td class="px-6 py-2 text-gray-600 dark:text-gray-300" >{{ transaction.total_debt }}</td>
                </tr>
                </tbody>
            </table>
            <div class="md:hidden space-y-4 mt-4">
                <div v-for="(transaction, index) in customerTransaction.slice().reverse()"
                :key="index" class="flex items-start gap-4 p-4 mb-4 border rounded-xl shadow-sm bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700">
  
                <div class="flex items-center justify-center w-10 h-10 rounded-full" :class="transaction.type === 'pago' ? 'bg-red-100 text-red-600 dark:bg-red-900 dark:text-red-300' : 'bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-300'">
                    <span v-if="transaction.type === 'pago'">💸</span>
                    <span v-else>🛒</span>
                </div>

                <div class="flex-1">
                    <div class="flex justify-between items-center mb-1">
                        <p class="font-semibold text-sm text-gray-800 dark:text-gray-100">
                            {{ transaction.action }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ transaction.date }}
                        </p>
                    </div>

                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-1">
                    <strong>Tipo:</strong> {{ transaction.type }}
                    </p>

                    <p
                    class="text-sm font-medium"
                    :class="transaction.type === 'pago' ? 'text-red-600 dark:text-red-400' : 'text-blue-600 dark:text-blue-400'"
                    >
                    <strong>{{ transaction.type === 'pago' ? 'Pago' : 'Costo' }}:</strong> S/ {{ transaction.amount }}
                    </p>

                    <p class="text-sm text-gray-600 dark:text-gray-300">
                    <strong>Deuda restante:</strong> S/ {{ transaction.total_debt }}
                    </p>
                </div>
                </div>

                </div>
        </div>
    </AppLayout>
</template>