<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head,Link,useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Nuevo Pago',
        href: '/creditSales',
    },
];

const Props = defineProps<{
    customer_id:string
}>();

const form = useForm({
    customer_id:Props.customer_id,
    amount_paid: '',
    note:'',
});

</script>

<template>
    <Head title="Addresses Create" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="overflow-x-auto p-3">
            <Link 
                :href="route('transactions.show',customer_id)"
                class="cursor-pointer px-3 py-2 mb-4 text-xs font-medium text-white bg-green-700 border-r-4 rounded border-green-800">
                Atras
            </Link>
        
            <form @submit.prevent="form.post(route('payment.store'))" class="space-y-6 mt-4 max-w-md mx-auto">
                <div class="grid gap-2">
                    <label for="name" class="text-sm leading-none font-medium select-none peer-disabled:cursor-pointer">
                        Monto a pagar:
                    </label>
                    <input
                        id="amount_paid"
                        name="amount_paid"
                        v-model="form.amount_paid"
                        class="mt-1 block w-full px-3 py-2 text-sm border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Ingrese el monto a pagar del cliente"/>
                    <p v-if="form.errors.amount_paid" class="text-red-500 text-sm mt-1">{{ form.errors.amount_paid }}</p>
                </div>
                <div class="grid gap-2">
                    <label for="name" class="text-sm leading-none font-medium select-none peer-disabled:cursor-pointer">
                        Nota:
                    </label>
                    <textarea
                        id="note"
                        name="note"
                        v-model="form.note"
                        rows="4"
                        class="mt-1 block w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Ingrese alguna nota (opcional)">
                    </textarea>
                    <p v-if="form.errors.note" class="text-red-500 text-sm mt-1">{{ form.errors.note }}</p>
                </div>
                <button
                    type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-green-200">
                    Guardar
                </button>
            </form>
        </div>
    </AppLayout>
</template>