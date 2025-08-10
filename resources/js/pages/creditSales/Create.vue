<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head,Link,useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Nuevo pedido',
        href: '/creditSales',
    },
];

const Props = defineProps<{
    customer_id:string
}>();

const form = useForm({
    customer_id:Props.customer_id,
    product: '',
    description:'',
    unit_price:'',
    quantity:'',
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
        
            <form @submit.prevent="form.post(route('creditSalesStore'))" class="space-y-6 mt-4 max-w-md mx-auto">
                <div class="grid gap-2">
                    <label for="name" class="text-sm leading-none font-medium select-none peer-disabled:cursor-pointer">
                        Nombre de pedido:
                    </label>
                    <input
                        id="name"
                        name="name"
                        v-model="form.product"
                        class="mt-1 block w-full px-3 py-2 text-sm border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Ingrese su nombre completo"/>
                    <p v-if="form.errors.product" class="text-red-500 text-sm mt-1">{{ form.errors.product }}</p>
                </div>
                <div class="grid gap-2">
                    <label for="name" class="text-sm leading-none font-medium select-none peer-disabled:cursor-pointer">
                        Descripcion
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        v-model="form.description"
                        rows="4"
                        class="mt-1 block w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Ingrese la descripción del producto (opcional)">
                    </textarea>
                    <p v-if="form.errors.description" class="text-red-500 text-sm mt-1">{{ form.errors.description }}</p>
                </div>
                <div class="grid gap-2">
                    <label for="name" class="text-sm leading-none font-medium select-none peer-disabled:cursor-pointer">
                        Cantidad
                    </label>
                    <input
                        id="name"
                        name="name"
                        v-model="form.quantity"
                        class="mt-1 block w-full px-3 py-2 text-sm border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Ingrese su nombre completo"/>
                    <p v-if="form.errors.quantity" class="text-red-500 text-sm mt-1">{{ form.errors.quantity }}</p>
                </div>
                <div class="grid gap-2">
                    <label for="name" class="text-sm leading-none font-medium select-none peer-disabled:cursor-pointer">
                        Costo
                    </label>
                    <input
                        id="name"
                        name="name"
                        v-model="form.unit_price"
                        class="mt-1 block w-full px-3 py-2 text-sm border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Ingrese su numero de celular"/>
                    <p v-if="form.errors.unit_price" class="text-red-500 text-sm mt-1">{{ form.errors.unit_price }}</p>
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