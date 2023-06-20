<template>
    <div>
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">Tasks</h1>
                <p class="mt-2 text-sm text-gray-700">A list of all the tasks in your account including their name, description and status.</p>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <button
                    type="button"
                    class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm
                        hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    @click="$emit('add')"
                >
                    New task
                </button>
            </div>
        </div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300 table-auto">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Description</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 text-center">Status</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 text-center">Priority</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-if="tasks.length" class="divide-y divide-gray-200 bg-white">
                                <tr v-for="task in tasks" class="cursor-pointer" :key="`task-line-${task.id}`">
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                        {{ task.name }}
                                    </td>
                                    <td class="break-words py-4 pl-4 pr-3 text-sm text-gray-900 sm:pl-6">
                                        {{ task.description }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-center">
                                        <StatusBadge :status="task.status" />
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-center">
                                        <PriorityBadge :priority="task.priority" />
                                    </td>
                                    <td class="whitespace-nowrap py-4 px-3 sm:pr-6 text-right align-middle space-x-2">
                                        <SecondaryButton
                                            v-if="task.status === 'pending'"
                                            type="button"
                                            class="px-1.5 py-1.5"
                                            @click.stop="$emit('take-on', task.id)"
                                        >
                                            Take on
                                        </SecondaryButton>
                                        <Link
                                            :href="`/tasks/${task.id}`"
                                            class="inline-flex items-center px-4 py-1.5 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700
                                                tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                                            method="get"
                                            as="button"
                                            type="button"
                                        >
                                            View
                                        </Link>
                                        <SecondaryButton
                                            type="button"
                                            class="px-1.5 py-1.5"
                                            @click.stop="$emit('edit', task.id)"
                                        >
                                            Edit
                                        </SecondaryButton>
                                        <DangerButton
                                            type="button"
                                            class="px-1.5 py-1.5"
                                            @click.stop="$emit('delete', task.id)"
                                        >
                                            Delete
                                        </DangerButton>

                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else class="divide-y divide-gray-200 bg-white">
                                <tr>
                                    <td colspan="4" class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-center">No tasks yet</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <Pagination :meta="meta" @previous="$emit('previous')" @next="$emit('next')" />
    </div>
</template>

<script>
import DangerButton from '@/Components/DangerButton.vue';
import { Link } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
import StatusBadge from '@/Components/StatusBadge.vue';
import PriorityBadge from '@/Components/PriorityBadge.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

export default {
    name: 'TaskList',
    components: { DangerButton, Link, Pagination, PriorityBadge, SecondaryButton, StatusBadge },
    props: {
        meta: {
            type: Object,
            validator({ from, to, current_page, last_page, total }) {
                const data = [
                    from,
                    to,
                    current_page,
                    last_page,
                    total,
                ];

                return data.filter(metadata => Number.isInteger(metadata)).length === data.length;
            }
        },
        tasks: {
            type: Array,
            default: () => ([])
        },
    },
}
</script>
