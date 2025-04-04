<script setup lang="ts">
import { useForm,Head } from "@inertiajs/vue3";
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea'
import InputError from '@/components/InputError.vue';
import { LoaderCircle } from 'lucide-vue-next';
import { ref } from 'vue';
const props = defineProps<{ post: { id: number; title: string; content: string;image: string } }>();

const form = useForm({
    title: props.post.title,
    content: props.post.content,
    image: props.post.image,
});

const submit = () => {
    form.put(route("posts.update", props.post.id), {
        onSuccess: () => alert("Post updated successfully!"),
        onError:()=>alert("Error updating post"),
    });
};

const imagePreview = ref<string | null>(null);

const handleImageChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];
    if (file) {
        form.image = file;
        imagePreview.value = URL.createObjectURL(file);
    }
};
</script>

<template>
    <Head class="text-white" title="Edit Post"/>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="grid w-full gap-3 pt-5 mt-4 justify-center">
            <form @submit.prevent="submit" class="flex flex-col gap-6">
                <div class="grid gap-6">
                    <div class="grid gap-2">
                        <Label for="title pt-4">Title</Label>
                        <Input
                            id="title"
                            type="text"

                            autofocus
                            :tabindex="1"

                            v-model="form.title"

                        />
                        <InputError :message="form.errors.title" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="description">Description</Label>
                        <Textarea
                            id="content"
                            type="text"

                            v-model="form.content"

                        />
                        <InputError :message="form.errors.content" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="image">Image</Label>
                        <Input id="image" type="file" :tabindex="3" @change="(e) => (form.image = e.target.files[0])" />
                        <img :src="`/storage/${post.image}`" alt="Current Image" class="mt-2 max-w-xs">
                        <div class="h-2"></div>
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
        <div class="grid w-full gap-3 pt-5 mt-4 justify-center">

        </div>
    </AppLayout>
</template>
