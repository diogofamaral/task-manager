<template>
    <div class="flex items-center justify-center">
        <div class="flex items-center justify-between space-x-0.5">
            <span v-for="i in 5" class="h-2 w-2 rounded-full" :class="{'bg-red-500': i <= grade, 'bg-gray-500/50': i > grade }" />
        </div>
        <span v-if="showLabel && label" class="ml-2 text-xs">{{ label }}</span>
    </div>
</template>

<script>
const priorityMap = new Map([
    ['low', { grade: 1, label: 'Low' }],
    ['moderate', { grade: 3, label: 'Moderate' }],
    ['high', { grade: 5, label: 'High' }],
]);

export default {
    name: 'PriorityBadge',
    props: {
        priority: {
            type: String,
        },
        showLabel: {
            type: Boolean
        }
    },
    computed: {
        label() {
            if (! this.priority) return;

            return priorityMap.get(this.priority)?.label;
        },
        grade() {
            if (! this.priority) return 0;

            return priorityMap.get(this.priority)?.grade;
        },
    },
}
</script>
