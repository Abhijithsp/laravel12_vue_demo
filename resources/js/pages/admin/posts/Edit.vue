<script setup lang="ts">
import { useForm,Head } from "@inertiajs/vue3";
import AppLayout from '@/layouts/AppLayout.vue';

const props = defineProps<{ post: { id: number; title: string; content: string;image: string } }>();

const form = useForm({
    title: props.post.title,
    content: props.post.content,
    image: null,
});

const submit = () => {
    form.post(route("posts.update", props.post.id), {
        onSuccess: () => alert("Post updated successfully!"),
        onError:()=>alert("Error updating post"),
    });
};
</script>

<template>
    <Head class="text-white" title="Edit Post"/>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="grid w-full gap-3 pt-5 mt-4 justify-center">
        <form @submit.prevent="submit" class="text-black">
            <div class="mb-4">
                <label class="block">Title:</label>
                <input v-model="form.title" class="border p-2 w-full " />
            </div>
            <div class="mb-4">
                <label class="block">Content:</label>
                <input v-model="form.content" class="border p-2 w-full" />
            </div>

            <div class="mb-4">
                <label class="block">Image:</label>
                <input type="file" @change="(e) => (form.image = e.target.files[0])" class="border p-2 w-full" />
                <img :src="`/storage/${post.image}`" alt="Current Image" class="h-20 mt-2">
            </div>

            <Button type="submit">Update Post</Button>
        </form>
        </div>
    </AppLayout>
</template>
