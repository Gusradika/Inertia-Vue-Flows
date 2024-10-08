<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
// import { bootstrap } from 'bootstrap';
import { Modal } from 'bootstrap';

defineProps({
    "greeting": String,
    "post": Object,
    "now": String,
});
const form = useForm({
    'body': '',
    'title': '',
});

const editForm = useForm({
    'id': '',
    'title': '',
    'body': '',
});

const createPost = () => {
    form.post(route('post.store'), {
        onSuccess: () => {
            form.reset();
        },
        onError: () => {

        }
    })
};
const deletePost = (id) => {
    form.delete(route('post.destroy', id), {
        onSuccess: () => {
            console.log('success');
        },
        onError: () => {
            console.log('error');

        }
    });
};

const updatePost = (id) => {
    editForm.patch(route('post.update', id), {
        onSuccess: () => {
            console.log('success');
            const modalElement = document.getElementById('exampleModal');
            const modal = Modal.getInstance(modalElement) || new Modal(modalElement);
            modal.hide();
        },
        onError: () => {
            console.log('error');
        }
    });
};

const updateModal = (id, title, body) => {
    console.log('clicked');
    editForm.id = id;
    editForm.title = title;
    editForm.body = body;

}
</script>



<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ greeting }}
            </h2>
        </template>
        <!-- {{ post }} -->
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-3">
                {{ form }}
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                    <form @submit.prevent="createPost()">

                        <div class=" text-gray-900 mb-4">
                            <input type="text" class="form-control mb-2" placeholder="Masukan Title..."
                                v-model="form.title" id="">
                            <!-- <p v-if="form.hasErrors('title')" class="text-danger">{{ form.errors.body }}</p> -->
                            <p v-if="form.errors.title" class="text-danger">{{ form.errors.title }}</p>
                            <textarea name="" class="form-control" placeholder="masukan text..." v-model="form.body"
                                id=""></textarea>
                            <!-- <p v-if="form.hasErrors('body')" class="text-danger">{{ form.errors.body }}</p> -->
                            <p v-if="form.errors.body" class="text-danger">{{ form.errors.body }}</p>
                        </div>
                        <button class="btn btn-primary" preserve-scroll type="submit" :disabled="form.processing"
                            :class="{ 'opacity-50': form.processing }">{{ form.processing ? 'processing...' : 'Save'
                            }}</button>
                    </form>
                </div>
                {{ now }}
                <div>

                    <Link preserve-scroll :only="['posts', 'now']" :href="route('post.index')"
                        class="mx-auto btn btn-primary text-center">Reset Data</Link>
                </div>

                <div v-for="key in post.data" :key="key.id">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h5>{{ key.title }}</h5>
                            <h6>{{ key.user.name }}</h6>
                            <p>{{ key.body }}</p>
                            <p>{{ key.created_at }}</p>
                            <form @submit.prevent="deletePost(key.id)" class="d-inline">
                                <button class="btn btn-danger  d-inline" type="submit">Delete</button>
                            </form>
                            <button data-bs-toggle="modal" data-bs-target="#exampleModal"
                                @click="updateModal(key.id, key.title, key.body)" class="btn btn-primary ms-4 d-inline"
                                type="submit">Edit</button>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <!-- Modal -->
        <div ref="editModal" class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form @submit.prevent="updatePost(editForm.id)">
                        <div class="modal-body">
                            <label for="">id</label>
                            <input type="text" v-model="editForm.id" class="form-control">
                            <p v-if="editForm.errors.id" class="text-danger">{{ editForm.errors.body }}</p>
                            <label for="">title</label>
                            <input type="text" v-model="editForm.title" class="form-control">
                            <p v-if="editForm.errors.title" class="text-danger">{{ editForm.errors.title }}</p>
                            <label for="">body</label>
                            <textarea type="text" class="form-control" v-model="editForm.body"></textarea>
                            <p v-if="editForm.errors.body" class="text-danger">{{ editForm.errors.body }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" :disabled="editForm.processing">{{
                                editForm.processing ? 'Processing...' : 'Save'
                            }}</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>


</template>
