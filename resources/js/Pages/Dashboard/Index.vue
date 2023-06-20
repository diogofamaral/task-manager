<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <section class="max-w-7xl mx-auto sm:px-6 lg:px-4 py-4 my-4">
            <TaskList
                :meta="meta"
                :tasks="tasks"
                @add="openForm"
                @delete="handleDelete"
                @edit="handleEdit"
                @next="meta.current_page++"
                @previous="meta.current_page--"
                @take-on="handleTakeOn"
            />
        </section>
    </AuthenticatedLayout>

    <TaskForm
        v-if="showForm"
        :task="editingTask"
        :errors="formErrors"
        @close="closeForm"
        @submit="saveTask"
    />
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import TaskForm from '@/Pages/Dashboard/Partials/TaskForm.vue';
import TaskList from '@/Pages/Dashboard/Partials/TaskList.vue';
import { createTask, deleteTask, fetchTask, fetchTasks, editTask } from '@/Http/requests';

export default {
    components: { AuthenticatedLayout, Head, TaskForm, TaskList, },
    data: () => ({
        showForm: false,
        featuredTask: null,
        editingTask: null,
        tasks: [],
        formErrors: {},
        meta: {
            from: 0,
            to: 0,
            current_page: 1,
            last_page: 1,
            total: 0,
        },
    }),
    computed: {
        currentPage() {
            return this.meta.current_page;
        },
    },
    watch: {
       currentPage() {
           this.listTasks();
       },
    },
    async created() {
        await this.listTasks();
    },
    methods: {
        async listTasks() {
            const { data } = await fetchTasks({ page: this.meta.current_page });

            this.meta = data.meta;
            this.tasks = data.data;
        },
        async saveTask(payload) {
            try {
                if (this.editingTask) {
                    await editTask(this.editingTask.id, payload);
                } else {
                    await createTask(payload);
                }

                this.closeForm();
                this.$notify({ group: 'notifications', title: 'Success', text: 'Task successfully saved!', type: 'success'}, 5000);

                await this.listTasks();
            } catch (/** @type {DecoratedError} */ error) {
                if (error.isForbidden()) {
                    this.closeForm();
                    this.$notify({ group: 'notifications', title: 'Failure', text: error.message, type: 'failure'}, 5000);
                }

                if (error.isUnprocessableEntity()) {
                    this.formErrors = error.errors;
                }
            }
        },
        async handleDelete(id) {
            try {
                await deleteTask(id);

                this.$notify({ group: 'notifications', title: 'Success', text: 'Task successfully deleted!', type: 'success'}, 5000);

                await this.listTasks();
            } catch (/** @type {DecoratedError} */ error) {
                if (error.isForbidden()) {
                    this.$notify({ group: 'notifications', title: 'Failure', text: error.message, type: 'failure'}, 5000);
                }
            }
        },
        async handleEdit(id) {
            try {
                const { data } = await fetchTask(id);

                this.editingTask = data.data;

                this.openForm();
            } catch (/** @type {DecoratedError} */ error) {
                if (error.isForbidden()) {
                    this.$notify({ group: 'notifications', title: 'Failure', text: error.message, type: 'failure'}, 5000);
                }
            }
        },
        async handleTakeOn(id) {
            try {
                await editTask(id, { status: 'in_progress' });

                this.$notify({ group: 'notifications', title: 'Success', text: 'Task successfully updated!', type: 'success'}, 5000);

                await this.listTasks();
            } catch (/** @type {DecoratedError} */ error) {
                this.$notify({ group: 'notifications', title: 'Failure', text: error.message, type: 'failure'}, 5000);
            }
        },
        openForm() {
            this.showForm = true;
        },
        closeForm() {
            this.showForm = false;
            this.editingTask = null;
            this.formErrors = {};
        },
    },
};
</script>
