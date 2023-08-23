<script setup>
    import { onMounted } from 'vue'
    import { Head } from '@inertiajs/vue3';
    import NavBar from  '@/Layouts/Partials/NavBar.vue'

    import { initFlowbite } from 'flowbite'

    const props = defineProps({
        title: {
            type: String,
            default: 'Notas'
        },
    })

    onMounted(() => {
        initFlowbite();
    })

</script>

<template>
    <Head :title="title" />
    <NavBar />

    <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">

        <div id="main-content" class="relative w-full h-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">
            <main class="pb-10">
                <slot />
            </main>
        </div>
    </div>
</template>
