<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" v-text="title"></div>

                    <div class="card-body">
                        <div class="alert alert-success" role="alert" v-if="status" v-text="status"></div>

                        <span v-text="content"></span>

                        <div class="text-center mt-1">
                            <a v-bind:href="contactsRoute" 
                               v-text="contactsButtonTitle"
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full no-underline">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            title: String,
            status: String,
            content: String, 
            contactsRoute: String,
            contactsButtonTitle: String,
        },
        mounted() {

        }
    }
</script>
