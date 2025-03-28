<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Textarea } from '@/components/ui/textarea'
import { Button } from '@/components/ui/button';

import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import type { BreadcrumbItem } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Create Post',
        href: '/posts'
    }
];

const form = useForm({
    title: '',
    description: '',
    image: null
});

const submit = () => {
    form.post(route('posts.store'), {
        onFinish: () => form.reset('title', 'description', 'image')
    });
};
</script>

<template>


    <Head title="Create Post" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="grid w-full gap-3 pt-5 mt-4 justify-center">
            <form @submit.prevent="submit" class="flex flex-col gap-6">
                <div class="grid gap-6">
                    <div class="grid gap-2">
                        <Label for="title pt-4">Title</Label>
                        <Input
                            id="title"
                            type="text"
                            required
                            autofocus
                            :tabindex="1"
                            autocomplete="title"
                            v-model="form.title"
                            placeholder="Title"
                        />
                        <InputError :message="form.errors.title" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="description">Description</Label>
                        <Textarea
                            id="description"
                            type="text"
                            required
                            :tabindex="2"
                            autocomplete="description"
                            v-model="form.description"
                            placeholder="Description"
                        />
                        <InputError :message="form.errors.description" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="image">Image</Label>
                        <Input id="image" type="file" v-model="form.image" />
                        <InputError :message="form.errors.image" />
                    </div>


                    <Button type="submit" class="mt-4 w-full" variant="destructive" :tabindex="4" :disabled="form.processing">
                        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                        Log in
                    </Button>
                </div>


            </form>
        </div>
    </AppLayout>
</template>
