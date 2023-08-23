<script setup>
    import TableData from '@/Components/Common/Table.vue'
    import {Link} from '@inertiajs/vue3'

    defineProps({
        data: Object,
        fields: Array,
    })

</script>
<template>
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block w-full align-middle">
                <div class="overflow-hidden shadow">
                    <TableData :data="data.data">
                        <template #thead>
                            <tr class="text-left font-bold">
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 pl-4">Nº</th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400" v-for="(field, key) in fields" :key="key">{{ field }}</th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 text-right">Acciones</th>
                            </tr>
                        </template>
                        <tr v-for="(row, key) in data.data" :key="row.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                            <td class="border-t pl-4">
                                <div class="pr-1 py-4 flex items-center focus:text-indigo-500">
                                    {{ data.from + key }}
                                </div>
                            </td>
                            <slot :row="row"></slot>
                        </tr>
                    </TableData>
                </div>
            </div>
        </div>
    </div>

    <div class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center mb-4 sm:mb-0" v-if="data.links.length > 3">
            <template v-for="(link, key) in data.links" :key="key">
                <div v-if="link.url === null" class="text-gray-400 inline-flex justify-center p-1 text-gray-500 rounded hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white px-4 py-2" :class="{ 'ml-auto': link.label === 'Next' }" v-html="link.label"></div>

                <Link v-else :href="link.url" v-html="link.label" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white px-4 py-2">
                </Link>
            </template>
        </div>
        <div class="flex items-center mb-4 sm:mb-0" v-else></div>
        <div class="flex items-center space-x-3">
            <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                <span class="font-semibold text-gray-900 dark:text-white">
                    {{ data.from }} - {{ data.to }}
                </span>
                de
                <span class="font-semibold text-gray-900 dark:text-white">{{ data.total }}</span>
            </span>
        </div>
    </div>
</template>
