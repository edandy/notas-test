<template>
    <div
        ref="drawerDefault"
        class="fixed top-0 right-0 z-40 w-full h-screen max-w-xs p-4 overflow-y-auto transition-transform translate-x-full bg-white dark:bg-gray-800"
        tabindex="-1" aria-labelledby="drawer-label" aria-hidden="true">
        <h5 id="drawer-label" class="inline-flex items-center mb-6 text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">
            <slot name="title"></slot>
        </h5>
        <button
            type="button"
            @click.prevent="close"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            <span class="sr-only">Close menu</span>
        </button>

        <div v-if="$page.props.flash.message" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div class="ml-3 text-sm font-medium" v-html="$page.props.flash.message">
            </div>
        </div>

        <slot v-else></slot>

        <div v-if="!$page.props.flash.message && drawerConfirm" class="flex justify-start pb-4">
            <button
                type="submit"
                @click.prevent="emit('onConfirm')"
                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2.5 text-center mr-2 dark:focus:ring-red-900">
                Confirmar
            </button>

            <button
                type="button"
                @click.prevent="close"
                class="text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 border border-gray-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2.5 text-center dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                <svg aria-hidden="true" class="w-5 h-5 -ml-1 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                Cancelar
            </button>

        </div>

        <div v-if="!$page.props.flash.message && !drawerConfirm" class="bottom-0 left-0 flex justify-center w-full pb-4 space-x-4" :class="drawerBtnAbsolute ? 'md:px-4 md:absolute' : 'md:relative'">
            <button
                type="submit"
                @click.prevent="emit('onSubmit')"
                class="text-white w-full justify-center bg-blue-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                >
                Guardar
            </button>
            <button
                type="button"
                @click.prevent="close"
                class="inline-flex w-full justify-center text-gray-500 items-center bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                <svg aria-hidden="true" class="w-5 h-5 -ml-1 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                Cancelar
            </button>
        </div>
    </div>
</template>

<script setup>
import {Drawer} from 'flowbite';
import {onMounted, ref, toRefs, watch} from "vue";

const drawerDefault = ref('drawerDefault');
    const draw = ref(null)

    const props = defineProps({
        showDrawer: {
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
        }
    })

    const { showDrawer, drawerConfirm } = toRefs(props)

    const emit = defineEmits(['setShowDraw', 'setDrawerConfirm', 'onSubmit', 'onConfirm'])

    const options = {
        placement: 'right',
        backdrop: true,
        bodyScrolling: false,
        edge: false,
        edgeOffset: '',
        backdropClasses: 'bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-30',
        onHide: () => {
            emit('setShowDraw', false)
            emit('setDrawerConfirm', false)
        },
    };

    onMounted(() => {
        draw.value = new Drawer(drawerDefault.value, options);
    })
    const open = () => {
        draw.value.show();
    }

    const close = () => {
        draw.value.hide();
    }

    watch(showDrawer, (val) => {
        if(val) {
            open()
        } else {
            close()
        }
    })
</script>
