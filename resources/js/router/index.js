import { createRouter, createWebHistory } from 'vue-router';
import Home from '../pages/Home.vue';
import Property from '../pages/Property.vue';
import Contact from '../pages/Contact.vue';
import PrivacyPolicy from '../pages/PrivacyPolicy.vue';
import Room from '../pages/Room.vue';
import Planner from '../pages/Planner.vue';
import Policies from '../pages/Policies.vue';
import Services from '../pages/Services.vue';

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home,
        meta: {
            theme: 'light',
            footer: true,
        },
    },
    {
        path: '/room',
        name: 'room',
        component: Room,
        meta: {
            theme: 'dark',
            footer: true,
        },
    },
    {
        path: '/property',
        name: 'property',
        component: Property,
        meta: {
            theme: 'dark',
            footer: true,
        },
    },
    {
        path: '/contact',
        name: 'contact',
        component: Contact,
        meta: {
            theme: 'dark',
            footer: true,
        },
    },
    {
        path: '/privacy-policy',
        name: 'privacy-policy',
        component: PrivacyPolicy,
        meta: {
            theme: 'light',
            footer: true,
        },
    },
    {
        path: '/planner',
        name: 'planner',
        component: Planner,
        meta: {
            theme: 'light',
            footer: true,
        },
    },
    {
        path: '/policies',
        name: 'policies',
        component: Policies,
        meta: {
            theme: 'light',
            footer: true,
        },
    },
    {
        path: '/services',
        name: 'services',
        component: Services,
        meta: {
            theme: 'light',
            footer: true,
        },
    },


];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior() {
        return { top: 0 };
    },
});

export default router;
