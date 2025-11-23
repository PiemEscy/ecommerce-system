<template>
        <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">
            <h2 class="text-3xl font-bold text-indigo-600 text-center mb-6">
                Login to E-Comm System
            </h2>
            <p class="text-gray-600 text-center mb-6">
                Enter your credentials to access your account.
            </p>

            <form @submit.prevent="handleLogin" class="space-y-4">

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

                <button
                    type="submit"
                    class="w-full px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow hover:bg-indigo-700"
                >
                    Login
                </button>
            </form>

            <div class="flex items-center my-6">
                <hr class="flex-grow border-gray-300" />
                <span class="mx-4 text-gray-400">or</span>
                <hr class="flex-grow border-gray-300" />
            </div>

            <button
                @click="$router.push('/register')"
                class="w-full px-4 py-2 border border-indigo-600 text-indigo-600 font-semibold rounded-lg hover:bg-indigo-50"
            >
                Register Account
            </button>
        </div>
</template>

<script>
    import axios from '../axios';
    import { useToast } from 'vue-toastification';

    export default {
        name: 'Login',
        data() {
            return {
            email: '',
            password: '',
            error: '',
            };
        },
        methods: {
            async handleLogin() {
                try {
                    const toast = useToast();
                    const response = await axios.post('api/login-process', {
                        email: this.email,
                        password: this.password,
                    });
                    localStorage.setItem('token', response.data.access_token);
                    toast.success('Login successfully!');
                    this.$router.push('/dashboard');
                } catch (err) {
                    if (err.response) {
                        this.error = err.response.data.message || 'Login failed.';
                    } 
                    else {
                        this.error = 'Login failed. Please try again.';
                    }
                }
            },
        },
    };
</script>


<style scoped>
/* Optional: smooth input focus effect */
input:focus {
  transition: all 0.3s ease;
}
</style>
