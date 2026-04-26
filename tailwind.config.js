import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                darkcolor: '#2E4F3C',
                white: '#ffffff',
                lightcolor: '#8DB9A0',
            },
            fontFamily: {
                sans: [
                    'Inter',
                    ...defaultTheme.fontFamily.sans
                ],
                mono: [
                    'Space Mono',
                    ...defaultTheme.fontFamily.mono
                ],
            },
        },
    },

    plugins: [forms],
};
