<template>
    <Head title="Task's details" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Task's details</h2>
        </template>

        <section class="max-w-7xl mx-auto sm:px-6 lg:px-4 py-4 my-4">
            <TaskDetails v-if="task" :task="task" @mark-as-complete="markAsComplete" @set-as-pending="setAsPending" />
        </section>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { fetchTask, editTask } from '@/Http/requests';
import TaskDetails from '@/Pages/Task/Partials/TaskDetails.vue';

export default {
    name: 'View',
    components: { AuthenticatedLayout, Head, TaskDetails },
    props: {
        id: Number,
        required: true,
    },
    data: () => ({
        task: null,
        processing: false,
    }),
    created() {
        this.getTask();
    },
    methods: {
        async getTask() {
            try {
                this.processing = true;

                const { data } = await fetchTask(this.$props.id);

                this.task = data.data;
            } catch (/** @type {DecoratedError} */ error) {
                if (error.isForbidden()) {
                    this.$notify({ group: 'notifications', title: 'Failure', text: error.message, type: 'failure'}, 5000);
                }
            } finally {
                this.processing = false;
            }
        },
        async markAsComplete() {
           try {
               this.processing = true;

               const { data } = await editTask(this.task.id, { status: 'completed' });

               this.task = data.data;

               this.$notify({ group: 'notifications', title: 'Success', text: 'Task successfully updated!', type: 'success'}, 5000);
           } catch (/** @type {DecoratedError} */ error) {
               this.$notify({ group: 'notifications', title: 'Failure', text: error.message, type: 'failure'}, 5000);
           } finally {
               this.processing = false;
           }
        },
        async setAsPending() {
            try {
                this.processing = true;

                const { data } = await editTask(this.task.id, { status: 'pending' });

                this.task = data.data;

                this.$notify({ group: 'notifications', title: 'Success', text: 'Task successfully updated!', type: 'success'}, 5000);
            } catch (/** @type {DecoratedError} */ error) {
                this.$notify({ group: 'notifications', title: 'Failure', text: error.message, type: 'failure'}, 5000);
            } finally {
                this.processing = false;
            }
        },
    },
}
</script>
