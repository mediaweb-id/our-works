<script setup>
import { useBuildQuery } from '@/Composables/useBuildQuery.js';
import AppLayout from '@/layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
const props = defineProps({
    ourworks: Object,
    title: String,
    request: Object,
    is_admin: Boolean,
    trash: Boolean,
});
const params = ref({ ...props.request, search_title: '' });
const filter = () => {
    const endpoint = ref(useBuildQuery(route('ourwork.index'), params.value));
    router.get(endpoint.value);
};
const sortBy = (field) => {
    params.value.sort = params.value.sort === 'desc' ? 'asc' : 'desc';
    params.value.sort_by = field;
    filter();
};
</script>
<template>
    <Head :title="title" />
    <AppLayout>
        <div class="mt-4 flex flex-wrap">
            <div class="mb-12 w-full px-4">
                <div class="relative mb-6 flex w-full min-w-0 flex-col break-words">
                    <div class="mb-0 rounded-t border-0 px-3 py-4">
                        <div class="flex flex-wrap items-center">
                            <div class="relative flex">
                                <div class="flex items-center">
                                    <h3 class="text-lg font-bold">
                                        {{ title }}
                                    </h3>
                                    <div class="relative ml-10 flex max-w-[300px] items-center">
                                        <TextInput
                                            type="text"
                                            class="mt-1 block w-full !py-1"
                                            v-model="params.search_title"
                                            @change="filter"
                                            placeholder="Search by title..."
                                        />
                                        <i class="fa fa-search absolute top-3 right-2 text-gray-400"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="fixed right-3 bottom-3 ml-auto flex flex-col gap-3 lg:relative lg:right-0 lg:bottom-0 lg:block">
                                <SecondaryLink
                                    :href="route('ourwork.create')"
                                    class="flex size-10 items-center justify-center gap-2 !rounded-full lg:size-auto lg:!rounded-none lg:!rounded-l-md lg:px-3 lg:py-2"
                                >
                                    <i class="fa fa-pencil"></i>
                                    <span class="hidden lg:block">Create New</span>
                                </SecondaryLink>
                                <SecondaryLink
                                    :href="route('ourwork.index', { trash: '1' })"
                                    class="flex size-10 items-center justify-center gap-2 !rounded-full bg-red-500 lg:size-auto lg:!rounded-none lg:!rounded-r-md lg:px-3 lg:py-2"
                                >
                                    <i class="fa fa-trash-can"></i>
                                    <span class="hidden lg:block">Trash</span>
                                </SecondaryLink>
                            </div>
                        </div>
                    </div>
                    <div class="block w-full overflow-x-auto">
                        <table class="w-full border-collapse items-center bg-transparent">
                            <thead>
                                <tr class="hidden lg:table-row">
                                    <Th
                                        >Title
                                        <button class="ml-2 hover:text-primary" @click="sortBy('title')">
                                            <i class="fa fa-sort"></i>
                                        </button>
                                    </Th>
                                    <Th
                                        >Status
                                        <button class="ml-2 hover:text-primary" @click="sortBy('status')">
                                            <i class="fa fa-sort"></i>
                                        </button>
                                    </Th>
                                    <Th
                                        >Published Date
                                        <button class="ml-2 hover:text-primary" @click="sortBy('published_at')">
                                            <i class="fa fa-sort"></i>
                                        </button>
                                    </Th>
                                    <Th></Th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(ourwork, index) in ourworks.data"
                                    :key="index"
                                    class="relative block cursor-pointer border-t py-3 lg:table-row lg:border-0 lg:py-0"
                                >
                                    <Td>
                                        <strong class="block lg:hidden">Title</strong>
                                        <span>{{ ourwork.title }}</span>
                                    </Td>
                                    <Td>
                                        <strong class="block lg:hidden">Status</strong>
                                        <Badge class="bg-blue-200 !px-2 !py-1 !text-xs" :class="{ 'bg-amber-300': ourwork.status == 'Draft' }">{{
                                            ourwork.status
                                        }}</Badge>
                                    </Td>
                                    <Td>
                                        <strong class="block lg:hidden">Published Date</strong>
                                        <span>{{ ourwork.published_at ?? '-' }}</span>
                                    </Td>
                                    <Td>
                                        <div v-if="trash">
                                            <SecondaryLink
                                                class="rounded-none rounded-l-md bg-green-500 px-3 py-2"
                                                :href="route('ourwork.restore', { ourwork: ourwork })"
                                                method="post"
                                                as="button"
                                            >
                                                <i class="fas fa-rotate-right"></i>
                                            </SecondaryLink>
                                            <SecondaryLink
                                                class="rounded-none rounded-r-md bg-red-500 px-3 py-2"
                                                :href="route('ourwork.forceDelete', { ourwork: ourwork })"
                                                method="post"
                                                as="button"
                                            >
                                                <i class="fas fa-trash-can"></i>
                                            </SecondaryLink>
                                        </div>
                                        <div v-else>
                                            <SecondaryLink
                                                class="rounded-none rounded-l-md bg-indigo-500 px-3 py-2"
                                                :href="route('ourwork.edit', { ourwork: ourwork })"
                                            >
                                                <i class="fas fa-pencil"></i>
                                            </SecondaryLink>
                                            <SecondaryLink
                                                class="rounded-none rounded-r-md bg-red-500 px-3 py-2"
                                                :href="route('ourwork.delete', { ourwork: ourwork })"
                                                method="post"
                                                as="button"
                                            >
                                                <i class="fas fa-trash-can"></i>
                                            </SecondaryLink>
                                        </div>
                                    </Td>
                                </tr>
                            </tbody>
                        </table>
                        <pagination class="mt-6" :links="ourworks.meta.links" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
