<template>
    <nav class="mt-8 flex items-center justify-between text-sm text-gray-700" aria-label="Pagination">
        <div class="hidden sm:block">
            <p class="text-sm text-gray-700">
                Showing
                <span class="font-medium">{{ meta.from }}</span>
                to
                <span class="font-medium">{{ meta.to }}</span>
                of
                <span class="font-medium">{{ meta.total }}</span>
                results
            </p>
        </div>
        <div v-if="meta.last_page > 1" class="flex flex-1 justify-between sm:justify-end items-center space-x-2">
            <a
                v-if="meta.current_page > 1"
                href="#"
                class="rounded-md bg-white px-3 py-2 text-sm text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-visible:outline-offset-0"
                @click="$emit('previous')"
            >
                Previous
            </a>
            <span>Page {{ meta.current_page }} of {{ meta.last_page }}</span>
            <a
                v-if="meta.last_page > meta.current_page"
                href="#"
                class="rounded-md bg-white px-3 py-2 text-sm text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-visible:outline-offset-0"
                @click="$emit('next')"
            >
                Next
            </a>
        </div>
    </nav>
</template>

<script>
export default {
    name: 'Pagination',
    props: {
        meta: {
            type: Object,
            required: true,
        },
    },
}
</script>
