<template>
    <div>
        <div class="flex justify-between px-2 md:px-0 ">
            <div>
                <Link
                    :href="route('dashboard')"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700
                        tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                    method="get"
                    as="button"
                    type="button"
                >
                    Back
                </Link>
            </div>
            <div class="flex items-center space-x-4">
                <PrimaryButton
                    v-if="['completed', 'in_progress'].includes(task.status)"
                    :class="{ 'opacity-25': processing }"
                    :disabled="processing"
                    @click="$emit('set-as-pending')"
                >
                    Set as pending
                </PrimaryButton>

                <PrimaryButton
                    v-if="['pending', 'in_progress'].includes(task.status)"
                    :class="{ 'opacity-25': processing }"
                    :disabled="processing"
                    @click="$emit('mark-as-complete')"
                >
                    Mark as complete
                </PrimaryButton>
            </div>
        </div>

        <div class="mt-4 lg:col-start-3 lg:row-end-1">
            <h2 class="sr-only">Details</h2>
            <div class="rounded-lg bg-gray-50 shadow-sm ring-1 ring-gray-900/5">
                <dl class="flex flex-wrap">
                    <div class="flex-auto pl-6 pt-6">
                        <dt class="text-md font-semibold leading-6 break-words pr-4 text-gray-900">{{ task.name }}</dt>
                        <dd class="mt-1 text-sm break-words pr-4 text-gray-900">{{ task.description }}</dd>
                    </div>
                    <div class="flex-none self-end px-6 pt-4">
                        <dt class="sr-only">Status</dt>
                        <dd>
                            <StatusBadge :status="task.status" />
                        </dd>
                    </div>
                    <div class="mt-6 flex w-full justify-between gap-x-4 border-t border-gray-900/5 px-6 pt-6">
                        <dt class="flex-none">
                            <span class="text-sm font-semibold">Deadline</span>
                        </dt>
                        <dd>
                            <div class="text-sm leading-6 text-gray-500">
                                <span v-if="deadline">{{ deadline }}</span>
                                <span v-else>--</span>
                            </div>
                        </dd>
                    </div>
                    <div class="flex w-full justify-between gap-x-4 px-6 pt-4">
                        <dt class="flex-none">
                            <span class="text-sm font-semibold">Completed at</span>
                        </dt>
                        <dd>
                            <div class="text-sm leading-6 text-gray-500">
                                <span v-if="completedAt">{{ completedAt }}</span>
                                <span v-else>--</span>
                            </div>
                        </dd>
                    </div>
                    <div class="mt-4 flex w-full justify-between gap-x-4 px-6 pb-6">
                        <dt class="flex-none">
                            <span class="text-sm font-semibold">Priority</span>
                        </dt>
                        <dd>
                            <PriorityBadge :priority="task.priority" show-label />
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</template>

<script>
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import PriorityBadge from '@/Components/PriorityBadge.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import StatusBadge from '@/Components/StatusBadge.vue';
import { Link } from '@inertiajs/vue3';

export default {
    name: 'TaskDetails',
    components: { Link, Modal, PrimaryButton, PriorityBadge, SecondaryButton, StatusBadge },
    props: {
        task: {
            Type: Object,
            validator({ id, name, description, status }) {
                const data = [id, name, description, status];

                return data.filter(Boolean).length = data.length;
            },
        },
        processing: {
            type: Boolean
        }
    },
    computed: {
        deadline() {
            if (! this.task.deadline_at) {
                return null;
            }

            return dayjs(this.task.deadline_at).format('MMMM D, YYYY');
        },
        completedAt() {
            if (! this.task.completed_at) {
                return null;
            }

            return dayjs(this.task.completed_at).format('MMMM D, YYYY');
        },
    },
}
</script>
