<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue'
    import DrawerComponent from "@/Components/Common/Drawer.vue";
    import {onMounted, ref, toRefs, watch} from "vue";
    import {Head, useForm, router} from "@inertiajs/vue3";
    import {pickBy, throttle} from "lodash";
    import {Drawer} from "flowbite"

    const props = defineProps({
        title: String,
        filters: Object,
        titleDrawer: String,
        module: {
            required: true,
            type: String,
        },
        showDrawer: {
            type: Boolean,
            default: false
        },
        showAlert: {
            type: Boolean,
            default: false
        },
        drawerConfirm: {
            type: Boolean,
            default: false
        },
        drawerBtnAbsolute: {
            type: Boolean,
            default: true
        },
    })

    const { module, filters } = toRefs(props)

    const emit = defineEmits(['onSubmit', 'setShowDraw', 'setDrawerConfirm', 'onConfirm'])

    const setShowDraw = (val) => {
        emit('setShowDraw', val)
    }

    const form = ref({
        search: '',
    })

    watch(form,
        throttle(() => {
            let query = pickBy(form.value)

            let queryRoute = route(module.value, Object.keys(query).length ? query : {});

            router.get(queryRoute, {}, {
                preserveState: true,
                preserveScroll: true
            });

        }, 200), {
            deep: true
        }
    )

    onMounted(() => {
        if(filters.value.search) {
            form.value.search = filters.value.search
        }
    })
</script>

<template>
    <AppLayout>
        <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
            <div class="w-full mb-1">
                <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                    <div class="flex items-center mb-4 sm:mb-0">
                        <form class="sm:pr-3">
                            <label for="products-search" class="sr-only">Buscar</label>
                            <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                                <input type="search" v-model="form.search" id="products-search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Buscar...">
                            </div>
                        </form>
                    </div>

                    <button
                        id="createProductButton"
                        @click.prevent="setShowDraw(true)"
                        class="text-white bg-blue-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800"
                        type="button"
                        >
                        Nuevo
                    </button>
                </div>

                <DrawerComponent
                    :showDrawer="showDrawer"
                    :showAlert="showAlert"
                    :drawerConfirm="drawerConfirm"
                    :drawerBtnAbsolute="drawerBtnAbsolute"
                    @setShowDraw="setShowDraw"
                    @setDrawerConfirm="emit('setDrawerConfirm')"
                    @onSubmit="emit('onSubmit')"
                    @onConfirm="emit('onConfirm')"
                >
                    <template #title>{{ titleDrawer }}</template>
                    <slot name="body-drawer"></slot>
                </DrawerComponent>
            </div>
        </div>
        <slot></slot>
    </AppLayout>
</template>
