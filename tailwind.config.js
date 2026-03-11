import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                // Nunito es la tipografía principal del manual [cite: 514, 518]
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Paleta oficial MZL
                'mzl-blue': '#3650BB',
                'mzl-teal': '#0CB29C',
                'mzl-orange': '#FF6702',
                'mzl-pink': '#E92050',
                'mzl-yellow': '#FFC400',
            }
        },
    },
    plugins: [forms],
};
