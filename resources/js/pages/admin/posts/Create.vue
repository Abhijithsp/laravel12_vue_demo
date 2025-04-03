<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Textarea } from '@/components/ui/textarea'
import { Button } from '@/components/ui/button';
import { ref } from 'vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { BreadcrumbItem, PostData } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Create Post',
        href: '/posts'
    }
];

const form = useForm<PostData>({
    title: '',
    content: '',
    image: null
});


const imagePreview = ref<string | null>(null);

const handleImageChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];
    if (file) {
        form.image = file;
        imagePreview.value = URL.createObjectURL(file);
    }
};

const submit = () => {
    form.post(route('posts.store'), {
        onSuccess: () => console.log('Post created successfully'),
        onError: (errors) => console.log('Errors:', errors),
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
                            id="content"
                            type="text"
                            required
                            :tabindex="2"
                            autocomplete="content"
                            v-model="form.content"
                            placeholder="Description"
                        />
                        <InputError :message="form.errors.content" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="image">Image</Label>
                        <Input id="image" type="file" :tabindex="3" @input="handleImageChange" />
                        <img v-if="imagePreview" :src="imagePreview" alt="Preview" class="mt-2 max-w-xs" />
                        <InputError :message="form.errors.image" />
                    </div>


                    <Button type="submit" class="mt-4 w-full" variant="destructive" :tabindex="4" :disabled="form.processing">
                        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                       Submit
                    </Button>


                </div>


            </form>
        </div>
    </AppLayout>
</template>
