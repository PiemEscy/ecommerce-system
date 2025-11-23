<template>
    <div class="min-h-screen bg-gray-50 text-gray-800 flex flex-col">
        <header class="w-full bg-white shadow-sm fixed top-0 left-0 z-50">
            <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
                <h1 class="text-2xl font-bold text-indigo-600">E-Comm System</h1>

                <nav class="hidden md:flex items-center space-x-8">
                <a href="#" class="hover:text-indigo-600">Home</a>
                <a href="#" class="hover:text-indigo-600">Features</a>
                <a href="#" class="hover:text-indigo-600">About Us</a>
                <a href="#" class="hover:text-indigo-600">Contact</a>
                </nav>

                <div class="space-x-3 hidden md:flex">
                    <button @click="$router.push('/login')" class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                        Login
                    </button>
                <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    Register Account
                </button>
                </div>

                <div class="md:hidden">
                <button @click="isMobileMenuOpen = !isMobileMenuOpen" class="text-indigo-600 focus:outline-none">
                    <svg v-if="!isMobileMenuOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
                </div>
            </div>

            <div v-if="isMobileMenuOpen" class="md:hidden bg-white shadow-md">
                <nav class="flex flex-col px-6 py-4 space-y-3">
                    <a href="#" class="hover:text-indigo-600">Home</a>
                    <a href="#" class="hover:text-indigo-600">Features</a>
                    <a href="#" class="hover:text-indigo-600">About Us</a>
                    <a href="#" class="hover:text-indigo-600">Contact</a>
                    <div class="flex flex-col space-y-2 mt-2">
                        <button class="px-4 py-2 border rounded-lg hover:bg-gray-100">Login</button>
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                        Register Account
                        </button>
                    </div>
                </nav>
            </div>
        </header>

        <section class="pt-32 pb-28 mt-20 max-w-5xl mx-auto text-center px-6">
            <span class="inline-block bg-indigo-100 text-indigo-600 px-4 py-1 rounded-full text-sm font-semibold mb-6">THE FUTURE OF E-COMMERCE</span>

            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold leading-tight text-gray-900">
                Connect. Create. Collaborate.
                <br />
                <span class="text-indigo-600">Your New Digital Marketplace.</span>
            </h1>

            <p class="mt-6 text-lg sm:text-xl text-gray-600 max-w-2xl mx-auto">
                Explore the powerful features of our platform designed for seamless
                inventory management and global reach. <strong>Register today</strong>
                to begin building your digital storefront.
            </p>

            <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4">
                <button class="px-8 py-3 bg-indigo-600 text-white text-lg rounded-lg shadow hover:bg-indigo-700">
                Explore Our Features
                </button>
                <button class="px-8 py-3 bg-white border text-lg rounded-lg shadow hover:bg-gray-100">
                See a Demo
                </button>
            </div>
        </section>

        <footer class="py-10 text-center text-gray-500 text-sm mt-auto">
        © 2025  E-Comm System. All rights reserved.
        </footer>
    </div>

</template>

<script>
export default {
  name: 'App',
  data() {
    return {
      isMobileMenuOpen: false,
    };
  },
};
</script>

<style scoped>
/* Smooth button hover animation */
button {
  transition: all 0.3s ease;
}
</style>
