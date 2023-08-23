<script setup>
    import Layout from '@/Layouts/LayoutInterna.vue'
    import DataList from '@/Components/DataList.vue'
    import {ref, watch} from "vue";
    import {router, useForm} from "@inertiajs/vue3";
    import {pickBy, throttle} from "lodash";

    // console.log('page => ', page)

    defineProps({
        notas: Object,
        errors: Object,
        filters: Object,
    })

    const fields = ref([
        'titulo',
        'contenido',
        'fecha'
    ])

    const showDrawer = ref(false)
    const drawerConfirm = ref(false)

    const form = useForm({
        id: null,
        titulo: '',
        contenido: ''
    })

    const onSubmit = () => {
        form.post(route('nota.store'), {
            onSuccess: () => {
                form.reset()
            }
        });
    }

    const onConfirm = () => {
        form.delete(route('nota.delete', form.id), {
            onSuccess: () => {
                form.reset()
            }
        });
    }

    const setShowDraw = (val) => {
        if(!val) {
            form.reset()
        }
        showDrawer.value = val
    }

    const setDrawerConfirm = (val) => {
        if(!val) {
            router.visit('/')
            form.reset()
        }
        drawerConfirm.value = val
    }

    const showUpdateRow = (row) => {
        showDrawer.value = true
        form.id = row.id
        form.titulo = row.titulo
        form.contenido = row.contenido
    }

    const confirmDeleteRow = (row) => {
        showDrawer.value = true
        drawerConfirm.value = true
        form.id = row.id
        form.titulo = row.titulo
    }
</script>

<template>
    <Layout
        title="Notas"
        titleDrawer="Nota"
        :showDrawer="showDrawer"
        :drawerConfirm="drawerConfirm"
        :filters="filters"
        module="nota"
        @setShowDraw="setShowDraw"
        @setDrawerConfirm="setDrawerConfirm"
        @onSubmit="onSubmit"
        @onConfirm="onConfirm">
        <DataList :data="notas" :fields="fields">
            <template v-slot="slotProps">
                <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ slotProps.row.titulo }}
                </td>

                <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ slotProps.row.contenido }}
                </td>

                <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ slotProps.row.created_at }}
                </td>

                <td class="border-t text-right pr-4">
                    <button
                        type="button"
                        id="updateProductButton"
                        @click.prevent="showUpdateRow(slotProps.row)"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 mr-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                    </button>

                    <button
                        type="button"
                        @click.prevent="confirmDeleteRow(slotProps.row)"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    </button>
                </td>
            </template>
        </DataList>

        <template #body-drawer>
            <div v-if="drawerConfirm">
                <svg class="w-10 h-10 mt-8 mb-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h3 class="mb-6 text-lg text-gray-500 dark:text-gray-400">¿Está seguro de que desea eliminar esta nota <strong>{{ form.titulo }}</strong>?</h3>
            </div>

            <form v-else @submit.prevent="onSubmit" class="mb-4">
                <div class="space-y-4">
                    <div>
                        <label for="titulo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Título</label>
                        <input
                            type="text"
                            v-model="form.titulo"
                            id="titulo"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Título la nota"
                        >
                        <div v-if="errors.titulo" class="text-red-500 text-sm">{{ errors.titulo }}</div>
                    </div>

                    <div>
                        <label for="contenido" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contenido</label>
                        <textarea
                            v-model="form.contenido"
                            id="contenido"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Contenido de la nota"
                        ></textarea>
                        <div v-if="errors.contenido" class="text-red-500 text-sm">{{ errors.contenido }}</div>
                    </div>
                </div>
            </form>
        </template>
    </Layout>
</template>
