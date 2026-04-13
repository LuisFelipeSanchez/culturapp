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
            },
            keyframes: {
                'fade-in-up': {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                'fade-in': {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                }
            },
            animation: {
                'fade-in-up': 'fade-in-up 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                'fade-in': 'fade-in 0.6s ease-out forwards',
            }
        },
    },
    plugins: [forms],
};
