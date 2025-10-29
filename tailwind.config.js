
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.js',
    './resources/**/*.vue',
        './resources/views/**/*.blade.php',
    ],
    
    theme: {
      

        extend: {
            colors: {
                primary: '#550000',
                accent: '#FDFBFB',
                secondary: '#F0F0F0',
                accent2: '#FFD95C',
                accent3: '#F6F6F6',
                charcoal: '#1A1A1A',
                darkgray: '#333333',
              },
              boxShadow: {
                'custom-button': '5px 5px 1px rgba(0, 0, 0, 1)',
                'maroon-shadow': '8px 8px 1px rgba(85, 0, 0, 1)',
              },
              dropShadow: {
                'custom-drop-shadow': '5px 5px 0 rgba(0, 0, 0, 1)',
                'custom-drop-shadow-small': '3px 3px 0 rgba(0, 0, 0, 1)',
              },
            fontFamily: {
                poppins: ['Poppins'],
                dela: ['Dela Gothic One'],

            },
            animation: {
              marquee: 'marquee 15s linear infinite',
              reverse_marquee: 'reverse-marquee 15s linear infinite',
              shake: 'shake 0.5s',
            },
            keyframes: {
              shake: {
                '0%, 100%': { transform: 'translateX(0)' },
                '10%, 30%, 50%, 70%, 90%': { transform: 'translateX(-5px)' },
                '20%, 40%, 60%, 80%': { transform: 'translateX(5px)' },
              },
            },
            backgroundImage: {
              pointedGrid: 'url(/public/images/card-bg.svg)',
            }
        },
        
    },

    plugins: [require("@tailwindcss/forms")],
    plugins: [require('tailwind-hamburgers')],
};
