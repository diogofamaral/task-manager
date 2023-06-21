<template>
    <Modal show @close="$emit('close')">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Create a task
            </h2>

            <div class="mt-6">
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    ref="nameInput"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                />

                <InputError v-for="error in errors.name" :message="error" class="mt-2" />
            </div>

            <div class="mt-6">
                <InputLabel for="description" value="Description" />

                <TextAreaInput
                    id="description"
                    ref="descriptionInput"
                    v-model="form.description"
                    type="text"
                    class="mt-1 block w-full"
                />

                <InputError v-for="error in errors.description" :message="error" class="mt-2" />
            </div>

            <div class="mt-6">
                <InputLabel for="priority" value="Priority" />

                <SelectInput
                    id="priority"
                    ref="priorityInput"
                    v-model="form.priority"
                    :options="priorityOptions"
                    class="mt-1 block w-full"
                />

                <InputError v-for="error in errors.priority" :message="error" class="mt-2" />
            </div>

            <div class="mt-6">
                <InputLabel for="deadline" value="Deadline" />

                <TextInput
                    id="deadline"
                    ref="deadlineInput"
                    v-model="form.deadline_at"
                    type="date"
                    class="mt-1 block w-full"
                />

                <InputError v-for="error in errors.deadline_at" :message="error" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-between">
                <SecondaryButton @click="$emit('close')">
                    Cancel
                </SecondaryButton>

                <PrimaryButton
                    class="ml-3"
                    :class="{ 'opacity-25': processing }"
                    :disabled="processing"
                    @click="$emit('submit', payload)"
                >
                    Submit
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>

<script>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextAreaInput from '@/Components/TextAreaInput.vue';
import TextInput from '@/Components/TextInput.vue';

export default {
    name: 'TaskForm',
    components: { InputError, InputLabel, Modal, PrimaryButton, SecondaryButton, SelectInput, TextAreaInput, TextInput },
    props: {
        task: {
            Type: Object,
            validator({ id, name, description, status }) {
                const data = [id, name, description, status];

                return data.filter(Boolean).length = data.length;
            },
        },
        errors: {
            type: Object,
            default: () => ({ name: '', description: '' })
        },
        processing: {
            type: Boolean,
        },
    },
    data: () => ({
        form: {
            description: '',
            name: '',
            priority: null,
            deadline_at: null,
        },
        priorityOptions: [
            { value: 'low', label: 'Low' },
            { value: 'moderate', label: 'Moderate' },
            { value: 'high', label: 'High' },
        ],
    }),
    computed: {
        payload() {
            return Object.entries(this.form)
                .filter(([_, v]) => v != null)
                .reduce((acc, [k, v]) => ({ ...acc, [k]: v }), {});
        },
    },
    created() {
        if (this.task) {
            this.fillForm();
        }
    },
    methods: {
        fillForm() {
           this.form.name = this.task.name;
           this.form.description = this.task.description;
           this.task.priority && (this.form.priority = this.task.priority);
           this.task.deadline_at && (this.form.deadline_at = this.task.deadline_at);
        }
    },
}
</script>
