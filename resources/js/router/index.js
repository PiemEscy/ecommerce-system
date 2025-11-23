import { createRouter, createWebHistory } from 'vue-router';
import Home from '../pages/Home.vue';
import Login from '../pages/Login.vue';
import Register from '../pages/Register.vue';
import Dashboard from '../pages/Dashboard.vue';
import axios from '../axios';

const routes = [
  { path: '/', component: Home, meta: { guestOnly: true } },
  { path: '/login', component: Login, meta: { guestOnly: true } },
  { path: '/register', component: Register, meta: { guestOnly: true } },
  { path: '/dashboard', component: Dashboard, meta: { requiresAuth: true } },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from, next) => {
    const token = localStorage.getItem('token');
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
    const guestOnly = to.meta.guestOnly;

    if (requiresAuth) {
        if (!token) {
        return next('/login');
        }

        try {
            var me = await axios.get('api/me-process', {
                headers: { Authorization: `Bearer ${token}`, Accept: 'application/json' },
            });
            return next();
        } catch (err) {
            localStorage.removeItem('token');
            return next('/login');
        }
    }

    if (guestOnly && token) {
        try {
            await axios.get('/me-process', {
                headers: { Authorization: `Bearer ${token}` },
            });
            return next('/dashboard');
        } catch (err) {
            localStorage.removeItem('token');
            return next();
        }
    }

    next();
});

export default router;
