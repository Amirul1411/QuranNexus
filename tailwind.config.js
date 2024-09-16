import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                surahnames: ['surahnames'],
                basmalah: ['basmalah'],
                UthmanicHafs: ['UthmanicHafs'],
                IndoPak: ['IndoPak'],
                ayaNo: ['ayaNo'],
                BorderIslamic: ['BorderIslamic'],
            },
            colors: {
                'light-green': '#8DFD98',
                'light-green-teal' : '#5EFEBE',
                'teal': '#3AFFDC',
            },
            gradientColorStopPositions: {
                56: '56%',
              }
        },
    },

    plugins: [forms, typography],
};
