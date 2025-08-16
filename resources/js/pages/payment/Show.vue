<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import { watch } from 'vue';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Pagos del cliente',
        href: '/PagoCliente',
    },
];

interface Payment {
    paymens_date: string;
    amount_paid: number;
    notes: string;
}

interface Customer {
    id: number;
    customer_name: string;
    cellNumber: string;
    address_name: string;
}

interface Props {
    customer: Customer;
    total_amount: number;
    payments: Payment[];
    start_date:string |null;
    end_date:string|null;
}

const props = defineProps<Props>();

const startDate = ref(props.start_date ??'');
const endDate = ref(props.end_date ??  '');

watch([startDate, endDate], ([start, end]) => {
    router.get(route('payment.show',props.customer.id), {

        start_date: start,
        end_date: end
    });
}, { 
    preserveState: true,
    replace:true, 
} as any);


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
            <div class="flex flex-col sm:flex-row sm:items-center sm:gap-4 gap-2 mt-6 mb-4">
                <!-- Fecha de inicio -->
                 <label for="start_date" class="text-sm text-gray-600 mb-1">Fecha de inicio</label>
                <input
                    id="start_date"
                    v-model="startDate"
                    type="date"
                    class="w-full sm:w-48 h-10 px-3 py-2 border border-gray-300 rounded"
                />

                <!-- Fecha de fin -->
                 <label for="end_date" class="text-sm text-gray-600 mb-1">Fecha de fin</label>
                <input
                    id="end_date"
                    v-model="endDate"
                    type="date"
                    class="w-full sm:w-48 h-10 px-3 py-2 border border-gray-300 rounded"
                />
            </div>

            <table class="hidden md:table mt-3 w-full text-sn text-left rtl:text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 ">Numero</th>
                        <th scope="col" class="px-6 py-3">Fecha de Pago</th>
                        <th scope="col" class="px-6 py-3">Monto</th>
                        <th scope="col" class="px-6 py-3">Nota</th>
                        <th scope="col" class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody >
                <tr v-for="(payment,index) in payments.slice().reverse()"  class="odd:bg-white odd:dark:bg-gray-900 even:dark:bg-gray-800 ">
                    <td class="px-6 py-2 font-medium text-gray-900 dark:text-white" >{{ index+1 }}</td>
                    <td class="px-6 py-2 text-gray-600 dark:text-gray-300" >{{ payment.paymens_date }}</td>
                    <td class="px-6 py-2 text-gray-600 dark:text-gray-300" >{{ payment.amount_paid}}</td>
                    <td class="px-6 py-2 text-gray-600 dark:text-gray-300" >{{ payment.notes }}</td>
                    <td class="px-6 py-2">

                    </td>
                </tr>
                </tbody>
            </table>
            </div>
            <div class="md:hidden space-y-4 mt-4">
                <div v-for="(payment,index) in payments" :key="index"
                     class="flex items-start gap-4 p-4 mb-4 border rounded-xl shadow-sm bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700">
                    
                <div class="flex items-center justify-center w-10 h-10 rounded-full" :class=" 'bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-300'">
                    <span>💸</span>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-center mb-1">
                        <p class="font-semibold text-sm text-gray-800 dark:text-gray-100">
                            {{ payment.amount_paid }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ payment.paymens_date }}
                        </p>
                    </div>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-1">
                            {{ payment.notes }}
                        </p>
                    </div>
                </div>                

            </div>
    </AppLayout>
</template>