<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import { Phone,MapPin } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Pedidos del cliente',
        href: '/PedidoCliente',
    },
];

defineProps<{
    customer: {
        id: number;
        customer_name: string;
        cellNumber:string;
        address_name:string
    };
    total_amount:number;
    credit_sales:{
        credit_sale_id:string;
        product:string;
        description:string;
        quantity:number;
        unit_price:number;
        subtotal:number;
        sales_date:string;
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
                :href="route('transactions.show',customer.id)"
                class="cursor-pointer px-3 py-2 mb-4 text-xs font-medium text-white bg-green-700 border-r-4 rounded border-green-800">
                Atras
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
                        <th scope="col" class="px-6 py-3">Producto</th>
                        <th scope="col" class="px-6 py-3">Descripcion</th>
                        <th scope="col" class="px-6 py-3">Fecha</th>
                        <th scope="col" class="px-6 py-3">Cantidad</th>
                        <th scope="col" class="px-6 py-3">Precio unitario</th>
                        <th scope="col" class="px-6 py-3">Precio total</th>
                        <th scope="col" class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody >
                <tr v-for="(credit_sale,index) in credit_sales.slice().reverse()"  class="odd:bg-white odd:dark:bg-gray-900 even:dark:bg-gray-800 ">
                    <td class="px-6 py-2 font-medium text-gray-900 dark:text-white" >{{ index+1 }}</td>
                    <td class="px-6 py-2 text-gray-600 dark:text-gray-300" >{{ credit_sale.product }}</td>
                    <td class="px-6 py-2 text-gray-600 dark:text-gray-300" >{{ credit_sale.description}}</td>
                    <td class="px-6 py-2 text-gray-600 dark:text-gray-300" >{{ credit_sale.sales_date }}</td>
                    <td class="px-6 py-2 text-gray-600 dark:text-gray-300" >{{ credit_sale.quantity }}</td>
                    <td class="px-6 py-2 text-gray-600 dark:text-gray-300" >{{ credit_sale.unit_price }}</td>
                    <td class="px-6 py-2 text-gray-600 dark:text-gray-300" >{{ credit_sale.subtotal}}</td>
                    <td class="px-6 py-2">

                    </td>
                </tr>
                </tbody>
            </table>
            <div class="md:hidden space-y-4 mt-4">
                <div v-for="(credit_sale,index) in credit_sales.slice().reverse()" :key="credit_sale.credit_sale_id"
                class="flex items-start gap-4 p-4 mb-4 border rounded-xl shadow-sm bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-center w-10 h-10 rounded-full" :class=" 'bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-300'">
                    <span>🛒</span>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-center mb-1">
                        <p class="font-semibold text-sm text-gray-800 dark:text-gray-100">
                            {{ credit_sale.product }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ credit_sale.sales_date }}
                        </p>
                    </div>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-1">
                            {{ credit_sale.description }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                        <strong>Cantidad:</strong> {{ credit_sale.quantity }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                        <strong>Precio Unitario:</strong> S/. {{ credit_sale.unit_price }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                        <strong>Costo total:</strong> S/. {{ credit_sale.subtotal }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>