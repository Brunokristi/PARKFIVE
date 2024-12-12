import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/room.js',
                'resources/js/customer.js',
                'resources/js/payments.js',
                'resources/css/homepage.css',
                'resources/css/style.css',],
            refresh: true,
        }),
    ],
});
