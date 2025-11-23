<template>
        <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">
            <h2 class="text-3xl font-bold text-indigo-600 text-center mb-6">
                Register Account to E-Comm System
            </h2>
            <p class="text-gray-600 text-center mb-6">
                Enter required fields to create your account.
            </p>

            <form @submit.prevent="handleRegister" class="space-y-4">

                <div v-if="error" class="mb-4 text-red-600 text-center font-medium">
                    {{ error }}
                </div>

                <div>
                    <label for="email" class="block text-gray-700 mb-1">Email</label>
                    <input
                        v-model="email"
                        type="email"
                        id="email"
                        placeholder="you@example.com"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600"
                        required
                    />
                </div>

                <div>
                    <label for="password" class="block text-gray-700 mb-1">Password</label>
                    <input
                        v-model="password"
                        type="password"
                        id="password"
                        placeholder="********"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600"
                        required
                    />
                </div>

                <div>
                    <label for="password_confirmation" class="block text-gray-700 mb-1">Confirm Password</label>
                    <input
                        v-model="password_confirmation"
                        type="password"
                        id="password_confirmation"
                        placeholder="********"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600"
                        required
                    />
                </div>

                <button
                    type="submit"
                    class="w-full px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow hover:bg-indigo-700"
                >
                    Submit
                </button>
            </form>
        </div>
</template>

<script>
    import axios from '../axios';
    import { useToast } from 'vue-toastification';

    export default {
        name: 'Register',
        data() {
            return {
            email: '',
            password: '',
            password_confirmation: '',
            error: '',
            };
        },
        methods: {
            async handleRegister() {
                try {
                    const toast = useToast();
                    const response = await axios.post('api/register-process', {
                        email: this.email,
                        password: this.password,
                        password_confirmation: this.password_confirmation,
                    });
                    if(response.status == '201'){
                        toast.success('Registered successfully!');
                        this.$router.push('/login');
                    }
                    else {
                        this.error = 'Register failed. Please try again.';
                    }
                } catch (err) {
                    if (err.response) {
                        this.error = err.response.data.message || 'Register failed.';
                    } 
                    else {
                        this.error = 'Register failed. Please try again.';
                    }
                    console.error(err);
                }
            },
        },
    };
</script>


<style scoped>
input:focus {
  transition: all 0.3s ease;
}
</style>
