<script setup>

</script>
<template>
    <table class="w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
        <thead class="bg-gray-100 dark:bg-gray-700">
            <slot name="thead"></slot>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
            <slot></slot>
        </tbody>
    </table>
</template>
