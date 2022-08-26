<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" v-text="title"></div>
                    <div class="card-body">
                        <form v-on:submit.prevent="submitInquiry">
                            <div class="flex flex-wrap -mx-3 md:mb-6">
                                <div class="w-full px-3 mb-6 md:mb-0">
                                    <label class="mb-2" for="name">
                                        Name
                                    </label>
                                    <input 
                                        class="form-control py-3 px-4 mb-3" 
                                        :class="{ 'is-invalid': errors.name }"
                                        id="name" 
                                        type="text" 
                                        placeholder="John Doe"
                                        v-model="name">
                                    <span 
                                        class="invalid-feedback" 
                                        v-if="errors.name"  
                                        role="alert">
                                        <strong v-text="errors.name[0]"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="flex flex-wrap -mx-3 md:mb-6">
                                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label class="mb-2" for="email">
                                        Email
                                    </label>
                                    <input 
                                        class="form-control py-3 px-4 mb-3" 
                                        :class="{ 'is-invalid': errors.email }"
                                        id="email" 
                                        type="text" 
                                        placeholder="test@example.com"
                                        v-model="email">
                                    <span 
                                        class="invalid-feedback" 
                                        v-if="errors.email"  
                                        role="alert">
                                        <strong v-text="errors.email[0]"></strong>
                                    </span>
                                </div>
                                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label class="mb-2" for="phone">
                                        Phone
                                    </label>
                                    <input 
                                        class="form-control py-3 px-4 mb-3" 
                                        :class="{ 'is-invalid': errors.phone }"
                                        id="phone" 
                                        type="text" 
                                        placeholder="Phone number"
                                        v-model="phone">
                                    <span 
                                        class="invalid-feedback" 
                                        v-if="errors.phone"  
                                        role="alert">
                                        <strong v-text="errors.phone[0]"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full px-3">
                                    <label class="mb-2" for="message">
                                        Message
                                    </label>
                                    <textarea 
                                        class="form-control py-3 px-4 mb-3 h-48 no-resize resize-none"
                                        :class="{ 'is-invalid': errors.message }"
                                        id="message"
                                        v-model="message">
                                    </textarea>
                                    <span 
                                        class="invalid-feedback" 
                                        v-if="errors.message"  
                                        role="alert">
                                        <strong v-text="errors.message[0]"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="text-center mb-2">
                                <button v-if="!loading" type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
                                    Submit
                                </button>
                                <div v-else-if="loading" class="text-center">
                                    <div role="status">
                                        <svg class="inline mr-2 w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                        </svg>
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { useToast } from "vue-toastification";

export default {
    setup() {

        // Setup toast
        const toast = useToast();

        // Make toast available to methods
        return { toast }
    },

    props: {
        title: String,
        submitUrl: String
    },

    data() {
        return {
            name: '',
            email: '',
            phone: '',
            message: '',
            loading: false,
            errors: {}
        }
    },

    methods: {
        async submitInquiry() {

            // Reset errors
            this.errors = {};

            try {

                // Show loading spinner
                this.loading = true;

                // Send post request to store the inquiry
                await axios.post(this.submitUrl, {
                    name: this.name,
                    email: this.email, 
                    phone: this.phone, 
                    message: this.message
                });

                // Show success notification
                this.toast.success('Inquiry send successfully!');
                
                // Reset form
                this.name = this.email = this.phone = this.message = '';
            }
            catch(e) {

                // Set errors
                this.errors = e.response.data.errors;

                // Show error notification
                this.toast.error(e.response.data.message);
            }
            finally {

                // Hide loading spinner
                this.loading = false;
            }
        }
    }
}
</script>
