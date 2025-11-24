<template>
    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8 relative">

        <div v-if="isLoading" class="absolute inset-0 bg-white/60 backdrop-blur-sm flex items-center justify-center z-50 rounded-lg">
            <div class="animate-spin h-10 w-10 border-4 border-indigo-600 border-t-transparent rounded-full"></div>
        </div>

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
                    :disabled="isLoading"
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
                    :disabled="isLoading"
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
                    :disabled="isLoading"
                />
            </div>

            <button
                type="submit"
                :disabled="isLoading"
                class="w-full px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center"
            >
                <span v-if="isLoading" class="animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full mr-2"></span>
                <span>{{ isLoading ? 'Processing...' : 'Submit' }}</span>
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
                isLoading: false,  // NEW
            };
        },
        methods: {
            async handleRegister() {
                const toast = useToast();

                if (this.password !== this.password_confirmation) {
                    this.error = "Passwords do not match!";
                    return;
                }

                this.error = "";
                this.isLoading = true;

                try {
                    const response = await axios.post('api/register-process', {
                        email: this.email,
                        password: this.password,
                        password_confirmation: this.password_confirmation,
                    });

                    if (response.status == 201) {
                        toast.success('Registered successfully!');
                        this.$router.push('/login');
                    } else {
                        this.error = 'Register failed. Please try again.';
                    }

                } catch (err) {
                    if (err.response) {
                        this.error = err.response.data.message || 'Register failed.';
                    } else {
                        this.error = 'Register failed. Please try again.';
                    }
                    console.error(err);
                } finally {
                    this.isLoading = false;
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
