<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem,FlashMessage } from '@/types';
import { Head ,Link,usePage,useForm  } from '@inertiajs/vue3';
import { computed,onMounted,watch } from 'vue';
import { Button } from '@/components/ui/button';
import {StickyNote,Pencil,Trash2}  from 'lucide-vue-next';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert'
import { Table, TableBody,TableCell, TableHead, TableHeader, TableRow} from '@/components/ui/table'
import { toast } from 'vue-sonner'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Posts',
        href: '/posts',
    },
];
const page = usePage()

const flash = computed(() => page.props.flash)
defineProps({ posts: Object })

const form = useForm({});

onMounted(() => {
    watch(() => usePage<{ flash: FlashMessage }>().props.flash,
        (flash: FlashMessage) => {
            if (flash.success) {
                toast.success(flash.success);
                flash.success = '';
            }

            if(flash.error){
                toast.error(flash.error);
                flash.error = '';
            }
        },
        { immediate: true }
    );
});


const deletePost = (id: number) => {
    toast('Are you sure you want to delete this post and its image?', {
        action: {
            label: 'Delete',
            onClick: () => {
                form.delete(route("posts.destroy", id), {
                    onSuccess: () => {
                        toast.success("Post deleted successfully");
                    },

                });
            }
        },
    })

};
</script>

<template>
    <Head title="Posts" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex justify-end">
                <Link href="/posts/create">   <Button variant="destructive" class="mt-2 w-40 justify-center">
                    <StickyNote />Create Post
                </Button></Link>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <Table>

                    <TableHeader class="justify-center">
                        <TableRow >
                            <TableHead class="w-[100px] font-medium text-center">
                                Sl No
                            </TableHead>
                            <TableHead class="w-[100px] font-medium text-center">
                                Title
                            </TableHead>
                            <TableHead class="font-medium text-center">Descriptions</TableHead>
                            <TableHead class="font-medium text-center">Image</TableHead>
                            <TableHead class="font-medium text-center">Edit</TableHead>
                            <TableHead class="font-medium text-center">Delete</TableHead>

                        </TableRow>
                    </TableHeader>
                    <TableBody class="text-justify">
                        <TableRow v-for="(post, index) in posts" :key="index">
                            <TableCell class="font-medium text-center">{{ post.id }}</TableCell>
                            <TableCell class="font-medium text-center">{{ post.title }}</TableCell>
                            <TableCell class="font-medium text-justify">{{ post.content }}</TableCell>
                            <TableCell class="w-100"><img :src="`/storage/${post.image}`" alt="image" class="h-40 w-80  object-fill"></TableCell>
                            <TableCell class="font-medium text-center"> <Link :href="route('posts.edit', post.id)"><Button class="mt-2 w-30 justify-center">
                                <Pencil />Edit
                            </Button></Link></TableCell>
                            <TableCell class="font-medium text-center"><Button variant="destructive"  @click="deletePost(post.id)" class="mt-2 w-30 justify-center">
                                <Trash2 />Delete
                            </Button></TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
