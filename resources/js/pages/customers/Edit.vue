<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head,Link,useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Editar Cliente',
        href: '/customers',
    },
];

const props = defineProps<{
    customer: {
        id: number;
        name: string;
        cellNumber:string;
        id_address:number
    };
    addresses:{
        id:number;
        name:string;
    }[];
}>();

const form = useForm({
    name: props.customer.name,
    cellNumber:props.customer.cellNumber,
    id_address:props.customer.id_address
});

</script>

<template>
    <Head title="Addresses Create" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="overflow-x-auto p-3">
            <Link 
                :href="route('customers.index')"
                class="cursor-pointer px-3 py-2 mb-4 text-xs font-medium text-white bg-green-700 border-r-4 rounded border-green-800">
                Atras
            </Link>
        
            <form @submit.prevent="form.put(route('customers.update',customer.id))" class="space-y-6 mt-4 max-w-md mx-auto">
                <div class="grid gap-2">
                    <label for="name" class="text-sm leading-none font-medium select-none peer-disabled:cursor-pointer">
                        Nombre:
                    </label>
                    <input
                        id="name"
                        name="name"
                        v-model="form.name"
                        class="mt-1 block w-full px-3 py-2 text-sm border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter your name"/>
                    <p v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</p>
                </div>
                <div class="grid gap-2">
                    <label for="name" class="text-sm leading-none font-medium select-none peer-disabled:cursor-pointer">
                        Numero de celular:
                    </label>
                    <input
                        id="cellNumber"
                        name="cellNumber"
                        v-model="form.cellNumber"
                        minlength="9"
                        class="mt-1 block w-full px-3 py-2 text-sm border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter your name"/>
                    <p v-if="form.errors.cellNumber" class="text-red-500 text-sm mt-1">{{ form.errors.cellNumber }}</p>
                </div>
                <div class="grid gap-2">
                    <label for="name" class="text-sm leading-none font-medium select-none peer-disabled:cursor-pointer">
                        Direccion:
                    </label>
                    <select
                        id="name"
                        name="name"
                        v-model="form.id_address"
                        class="mt-1 block w-full px-3 py-2 text-sm border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="" disabled selected>Selecciona una dirección</option>
                        <option 
                            v-for="address in addresses" 
                            :key="address.id" 
                            :value="address.id"
                        >
                            {{ address.name }}
                        </option>
                    </select>
                    <p v-if="form.errors.id_address" class="text-red-500 text-sm mt-1">{{ form.errors.id_address }}</p>
                </div>
                <button
                    type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-green-200">
                    Actualizar
                </button>
            </form>
        </div>
    </AppLayout>
</template>