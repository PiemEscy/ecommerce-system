<template>
    <div class="min-h-screen w-screen bg-gray-200 text-gray-800 flex flex-col">
        <header class="w-full bg-white shadow fixed top-0 left-0 z-50">
            <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
                <h1 class="text-2xl font-bold text-indigo-600">E-Comm Platform</h1>

                <div class="space-x-3 hidden md:flex">
                    <button @click="logout" class="px-4 py-2 border rounded-lg hover:bg-gray-100">Logout</button>
                </div>

                <!-- Mobile Menu Button -->
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
                    <div class="flex flex-col space-y-2 mt-2">
                        <button @click="logout" class="px-4 py-2 border rounded-lg hover:bg-gray-100">Logout</button>
                    </div>
                </nav>
            </div>
        </header>

        <main className="grid grid-cols-1 md:grid-cols-12 gap-6 pt-32 px-6">

                <div className="col-span-12 md:col-span-12 xl:col-span-8">

                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Available Products</h3>
                    
                    <div class="grid sm:grid-cols-2 xl:grid-cols-4 gap-6">
                        <div 
                            v-for="product in products" 
                            :key="product.id"
                            class="bg-white p-5 rounded-xl border shadow-sm hover:shadow-lg transition flex flex-col"
                        >
                            <h4 class="font-semibold">{{ product.name }}</h4>
                            <p class="text-indigo-600 font-bold text-lg mt-1">{{ formatAmount(product.price) }}</p>

                            <div class="mt-3">
                                <label class="text-sm text-gray-600">Quantity:</label>
                                <input 
                                    type="number" 
                                    v-model.number="product.quantity"
                                    min="1"
                                    class="w-24 mt-1 px-3 py-1 border rounded-lg"
                                >
                            </div>

                            <button 
                                @click="addToCart(product)"
                                :disabled="isAddingToCart && activeProductId === product.id || isCheckingOut || isLoading"
                                class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                <span v-if="isAddingToCart && activeProductId === product.id" class="animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full inline-block"></span>
                                <span v-else>Add to Cart</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div className="col-span-12 md:col-span-12 lg:col-span-4">

                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Your Cart</h3>

                    <div v-if="cart.length === 0" class="text-gray-500 h-fit bg-white p-6 rounded-xl border shadow">
                        Your cart is empty.
                    </div>

                    <div v-else class="bg-white p-6 rounded-xl border shadow">
                        <div 
                            v-for="item in cart" 
                            :key="item.id"
                            class="flex items-center justify-between py-3 border-b last:border-none"
                        >
                            <div class="flex flex-col w-40">
                                <span class="font-semibold text-gray-800 truncate">{{ item.name }}</span>
                                <span class="text-sm text-gray-500">{{ item.price }} each</span>
                            </div>

                            <div class="flex items-center space-x-1">
                                <button @click="decreaseQty(item)" :disabled="isCheckingOut || isLoading" class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed">-</button>
                                <span class="font-medium w-6 text-center">{{ item.quantity }}</span>
                                <button @click="increaseQty(item)" :disabled="isCheckingOut || isLoading" class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed">+</button>
                            </div>

                            <div class="w-24 text-right font-semibold">
                                {{ formatAmount(item.price * item.quantity) }}
                            </div>

                            <button @click="removeItem(item)" class="text-red-500 hover:text-red-700 px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">x</button>
                        </div>

                        <div class="flex justify-between items-center mt-4 font-bold text-lg">
                            <span>Total:</span>
                            <span>{{ formatAmount(cartTotal) }}</span>
                        </div>

                    <button 
                        @click="confirmCheckout"
                        :disabled="isCheckingOut || isLoading"
                        class="mt-5 w-full px-4 py-3 bg-green-600 text-white text-lg font-semibold rounded-lg hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span v-if="isCheckingOut" class="animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full inline-block"></span>
                        <span v-else>Checkout</span>
                    </button>
                    </div>
                    
                </div>
        </main>

        <div v-if="showConfirmation" class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96 text-center">
                <h2 class="text-xl font-bold mb-4">Confirm Checkout</h2>
                <p class="mb-6">Are you sure you want to place this order?</p>
                <div class="flex justify-between">
                    <button @click="showConfirmation = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                    <button 
                        @click="proceedToCheckout" 
                        :disabled="isCheckingOut || isLoading"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span v-if="isCheckingOut" class="animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full inline-block"></span>
                        <span v-else>Confirm</span>
                    </button>
                </div>
            </div>
        </div>

        <div v-if="isLoading" class="fixed inset-0 bg-black/40 flex items-center justify-center z-[9999]">
            <div class="animate-spin h-12 w-12 border-4 border-white border-t-transparent rounded-full"></div>
        </div>

        <footer class="py-6 text-center text-gray-500 text-sm mt-auto">
            © 2025 E-Comm Platform. All rights reserved.
        </footer>
    </div>
</template>

<script>
    import axios from '../axios';
    import { useToast } from 'vue-toastification';

    export default {
        name: 'Dashboard',
        data() {
            return {
                isMobileMenuOpen: false,
                products: [],
                cart: [],
                isCheckingOut: false,
                showConfirmation: false,
                checkoutMessage: '',
                isLoading: false,
                isAddingToCart: false,
                activeProductId: null,
            };
        },
        methods: {

            async fetchProducts() {
                try {
                    const token = localStorage.getItem('token');
                    const response = await axios.get(`${import.meta.env.VITE_ECOM_CATALOG_SERVICE_URL}/api/products`, {
                        headers: {
                            Authorization: `Bearer ${token}`
                        }
                    });
                    if(response.data.data){
                        this.products = response.data.data.map(product => ({
                            ...product,
                            quantity: 1
                        }));
                        
                    }
                } catch (error) {
                    console.error('Error fetching products:', error.response.data);
                }
            },

            logout() {
                localStorage.removeItem('token');
                this.$router.push('/login');
            },

            async addToCart(product) {
                this.isAddingToCart = true;
                this.activeProductId = product.id;

                setTimeout(() => {
                    const existing = this.cart.find(item => item.id === product.id);

                    if (existing) {
                        existing.quantity += Number(product.quantity);
                    } else {
                        this.cart.push({
                            ...product,
                            quantity: Number(product.quantity)
                        });
                    }

                    product.quantity = 1;
                    this.isAddingToCart = false;
                    this.activeProductId = null;
                }, 100);
            },

            decreaseQty(item) {
                item.quantity--;
                if (item.quantity <= 0) {
                    this.removeItem(item);
                }
            },

            increaseQty(item) {
                item.quantity++;
            },

            removeItem(item) {
                this.cart = this.cart.filter(i => i.id !== item.id);
            },

            formatAmount(amount) {
                return new Intl.NumberFormat('en-PH', { 
                    minimumFractionDigits: 2, 
                    maximumFractionDigits: 2 
                }).format(amount);
            },

            formatDate() {
                const now = new Date();
                const phTime = new Date(now.toLocaleString('en-US', { timeZone: 'Asia/Manila' }));
                return phTime.getFullYear() + '-' +
                            String(phTime.getMonth() + 1).padStart(2, '0') + '-' +
                            String(phTime.getDate()).padStart(2, '0') + ' ' +
                            String(phTime.getHours()).padStart(2, '0') + ':' +
                            String(phTime.getMinutes()).padStart(2, '0') + ':' +
                            String(phTime.getSeconds()).padStart(2, '0');
            },

            async proceedToCheckout() {
                const toast = useToast();

                if (this.cart.length === 0) {
                    toast.error("Your cart is empty!");
                    return;
                }

                this.isCheckingOut = true;
                this.isLoading = true;

                try {
                    const token = localStorage.getItem('token');
                    const user = await this.getUser();
                    const user_id = user?.id;
                    const order_date = this.formatDate();

                    const items = this.cart.map(item => ({
                        product_id: item.id,
                        quantity: item.quantity,
                        price_at_checkout: item.price
                    }));

                    const payload = {
                        user_id,
                        status: "pending",
                        order_date,
                        items
                    };

                    const response = await axios.post(
                        `${import.meta.env.VITE_ECOM_CHECKOUT_SERVICE_URL}/api/checkout`,
                        payload,
                        { headers: { Authorization: `Bearer ${token}`, "Content-Type": "application/json" }}
                    );

                    this.showConfirmation = false;

                    await this.emailUser();
                    toast.success("Order placed successfully!");
                    this.cart = [];

                } catch (error) {
                    console.error("Checkout error:", error.response?.data || error);
                    toast.error("Failed to place order.");
                } finally {
                    this.isCheckingOut = false;
                    this.isLoading = false;
                }
            },

            confirmCheckout() {
                const toast = useToast();
                if (this.cart.length === 0) {
                    toast.error("Your cart is empty!");
                    return;
                }
                this.showConfirmation = true;
            },

            async getUser(){
                try {
                    const token = localStorage.getItem('token');
                    var me = await axios.get('api/me-process', {
                        headers: { Authorization: `Bearer ${token}`, Accept: 'application/json' },
                    });
                    if (me?.data) {
                        
                        return me.data;
                    }else{
                        return [];
                    }
                } catch (error) {
                    console.error("Get user error:", error.response?.data || error);
                    return [];
                }
            },

            async emailUser(){
                const toast = useToast();
                const token = localStorage.getItem('token');
                const user = await this.getUser();
                const email = user?.email;
                const order_date = this.formatDate();
                const items = this.cart;

                const payload = {
                    email,
                    status: "pending",
                    order_date,
                    items
                };

                const response = await axios.post(`${import.meta.env.VITE_ECOM_EMAIL_SERVICE_URL}/api/email`, payload, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        'Content-Type': 'application/json',
                    }
                });

                if(response.status == '201' || response.status == '200'){
                    toast.success('An email has been sent for Order Summary');
                }
                else {
                    console.error("Email error:", error.response?.data || error);
                    toast.error('Failed to email Order Summary.');
                }
            }
        },
        computed: {
            cartTotal() {
                return this.cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
            }
        },
         mounted() {
            this.fetchProducts();
        }
    };
</script>

<style scoped>
    div:hover {
    transition: all 0.3s ease;
    }
</style>
