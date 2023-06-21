<template>
    <div
        class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset"
        :class="colorClasses"
    >
        {{ label }}
    </div>
</template>

<script>
const pending = {
    bgColor: 'bg-amber-100',
    textColor: 'text-amber-900/50',
    ringColor: 'ring-amber-600/20',
    label: 'Pending',
};

const in_progress = {
    bgColor: 'bg-indigo-100',
    textColor: 'text-indigo-700',
    ringColor: 'ring-indigo-600/20',
    label: 'In progress',
};

const completed = {
    bgColor: 'bg-green-50',
    textColor: 'text-green-700',
    ringColor: 'ring-green-600/20',
    label: 'Completed',
};

const statusMap = new Map([
    ['pending', pending],
    ['in_progress', in_progress],
    ['completed', completed],
]);

const getStatus = (status) => {
    return statusMap.get(status) ?? {};
};

export default {
    name: 'StatusBadge',
    props: {
        status: {
            type: String,
            required: true,
        },
    },
    computed: {
        statusInfo() {
            return getStatus(this.status);
        },
        colorClasses() {
            return Object.values(this.statusInfo).reduce((a, v) => ({ ...a, [v]: true }), {});
        },
        label() {
            return this.statusInfo?.label;
        },
    },
}
</script>
