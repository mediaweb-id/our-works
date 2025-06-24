<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import InputTextArray from '../../components/InputTextArray.vue';

let props = defineProps({
    ourwork: Object,
    method: String,
    title: String,
    is_admin: Boolean,
});

const form = ref(useForm(props.ourwork));

const submit = () => {
    if (props.method == 'store') {
        form.value.post(route('ourwork.store', form.value.id), {
            preserveScroll: false,
            onFinish: () => console.log('ok'),
            onSuccess: (res) => {
                form.value.reset();
            },
        });
    }
    if (props.method == 'update') {
        form.value.patch(route('ourwork.update', { ourwork: props.ourwork }), {
            preserveScroll: false,
            onFinish: () => console.log('ok'),
            onSuccess: (res) => {
                form.value = useForm(res.props.ourwork);
            },
        });
    }
};

const tab = ref('content');
const changeTab = (newtab) => {
    tab.value = newtab;
};
</script>

<template>
    <Head :title="title" />
    <AppLayout>
        <div>
            <form class="mt-4 flex flex-wrap" @submit.prevent="default">
                <div class="w-full lg:w-8/12">
                    <div class="relative mb-5 flex w-full min-w-0 flex-col px-5 break-words">
                        <div class="block w-full overflow-x-auto">
                            <div class="mb-5 rounded-t">
                                <div class="border-b border-gray-200 text-center text-sm font-medium">
                                    <ul class="-mb-px flex flex-wrap">
                                        <li class="mr-2">
                                            <a
                                                @click="changeTab('content')"
                                                class="inline-block cursor-pointer rounded-t-lg border-b-2 border-transparent p-4 font-bold"
                                                :class="{
                                                    'active !border-blue-600 text-blue-600 dark:border-blue-500 dark:text-blue-500': tab == 'content',
                                                }"
                                                aria-current="article"
                                                >Content</a
                                            >
                                        </li>
                                        <li class="mr-2">
                                            <a
                                                @click="changeTab('gallery')"
                                                class="inline-block cursor-pointer rounded-t-lg border-b-2 border-transparent p-4 font-bold"
                                                :class="{
                                                    'active !border-blue-600 text-blue-600 dark:border-blue-500 dark:text-blue-500': tab == 'gallery',
                                                }"
                                                >Gallery</a
                                            >
                                        </li>
                                        <li class="mr-2">
                                            <a
                                                @click="changeTab('tools')"
                                                class="inline-block cursor-pointer rounded-t-lg border-b-2 border-transparent p-4 font-bold"
                                                :class="{
                                                    'active !border-blue-600 text-blue-600 dark:border-blue-500 dark:text-blue-500': tab == 'tools',
                                                }"
                                                >Tools</a
                                            >
                                        </li>
                                        <li class="mr-2">
                                            <a
                                                @click="changeTab('credits')"
                                                class="inline-block cursor-pointer rounded-t-lg border-b-2 border-transparent p-4 font-bold"
                                                :class="{
                                                    'active !border-blue-600 text-blue-600 dark:border-blue-500 dark:text-blue-500': tab == 'credits',
                                                }"
                                                >Credits</a
                                            >
                                        </li>
                                        <li class="mr-2">
                                            <a
                                                @click="changeTab('seo')"
                                                class="inline-block cursor-pointer rounded-t-lg border-b-2 border-transparent p-4 font-bold"
                                                :class="{
                                                    'active !border-blue-600 text-blue-600 dark:border-blue-500 dark:text-blue-500': tab == 'seo',
                                                }"
                                                >SEO</a
                                            >
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="block w-full overflow-x-auto lg:px-4" :class="{ hidden: tab != 'content' }">
                                <div class="block">
                                    <InputLabel for="title" value="Title" />
                                    <TextInput type="text" class="mt-1 block w-full" v-model="form.title" />
                                    <InputError class="mt-2" :message="form.errors.title" />
                                </div>
                                <div class="mt-4 block">
                                    <InputLabel for="slug" value="Slug" />
                                    <InputSlug type="text" class="mt-1 block w-full" :source="form.title" v-model="form.slug" />
                                    <InputError class="mt-2" :message="form.errors.slug" />
                                </div>
                                <div class="mt-4 block">
                                    <InputLabel :for="form.summary" value="Summary" />
                                    <TextAreaInput class="mt-1 block w-full" v-model="form.summary" />
                                </div>
                                <div class="mt-4 block">
                                    <InputLabel for="description" value="Description" />
                                    <tiny-editor placeholder="Description" v-model="form.description"></tiny-editor>
                                    <InputError class="mt-2" :message="form.errors.description" />
                                </div>
                            </div>
                            <div class="block w-full lg:px-4" :class="{ hidden: tab != 'credits' }">
                                <InputTextArray v-model="form.credits"></InputTextArray>
                            </div>
                            <div class="block w-full lg:px-4" :class="{ hidden: tab != 'tools' }">
                                <InputTextArray v-model="form.tools"></InputTextArray>
                            </div>
                            <div class="block w-full lg:px-4" :class="{ hidden: tab != 'gallery' }">
                                <InputGallery v-model="form.galleries" @onsave="submit"></InputGallery>
                            </div>
                            <div class="block w-full overflow-x-auto lg:px-4" :class="{ hidden: tab != 'seo' }">
                                <div class="block">
                                    <InputLabel :for="form.meta.title" value="Meta Title" />
                                    <TextInput type="text" class="mt-1 block w-full" v-model="form.meta.title" />
                                </div>

                                <div class="mt-4 block">
                                    <InputLabel :for="form.meta.description" value="Meta Description" />
                                    <TextAreaInput class="mt-1 block w-full" v-model="form.meta.description" />
                                </div>

                                <div class="mt-4 block">
                                    <InputLabel :for="form.meta.image" value="Meta Image" />
                                    <acit-jazz-upload
                                        class="mt-1 block w-full"
                                        title="meta"
                                        folder="meta"
                                        :limit="1"
                                        filetype="image/*"
                                        name="meta"
                                        v-model="form.meta.image"
                                    >
                                    </acit-jazz-upload>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full lg:w-4/12">
                    <div class="break-wordsw-full relative flex min-w-0 flex-col px-5">
                        <div class="mt-4 block">
                            <InputLabel for="Project Date" value="Project Date" />
                            <TextInput type="datetime-local" v-model="form.date" format="dd/MM/yyyy hh:mm" placeholder="Select Project Date" />
                            <InputError class="mt-2" :message="form.errors.date" />
                        </div>
                        <div class="mt-4 block">
                            <InputLabel for="published_at" value="Published Date" />
                            <TextInput
                                type="datetime-local"
                                v-model="form.published_at"
                                format="dd/MM/yyyy hh:mm"
                                placeholder="Select Published Date"
                            />
                            <InputError class="mt-2" :message="form.errors.published_at" />
                        </div>
                        <div class="mt-4 block">
                            <InputLabel for="status" value="Status" />
                            <InputSelect
                                v-model="form.status"
                                :options="[
                                    { id: 'Draft', title: 'Draft' },
                                    { id: 'Published', title: 'Published' },
                                ]"
                                store="id"
                                label="title"
                                :is_string="true"
                                placeholder="Status"
                            />
                            <InputError class="mt-2" :message="form.errors.status" />
                        </div>
                        <div class="mt-4 block">
                            <InputLabel :for="form.image" value="Image" />
                            <acit-jazz-upload
                                class="mt-1 block w-full"
                                title="image"
                                folder="ourwork"
                                :limit="1"
                                filetype="image/*"
                                name="image"
                                v-model="form.image"
                            >
                            </acit-jazz-upload>
                        </div>
                    </div>
                </div>
                <div class="mt-5 mb-10 w-full px-5">
                    <PrimaryButton @click="submit" class="block w-full cursor-pointer justify-center rounded-md px-3 py-3 text-center">
                        Save
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
