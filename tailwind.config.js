import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            colors: {
                "menu-card-a": 'hsl(var(--menu-card-a))',
                "menu-card-b": 'hsl(var(--menu-card-b))',
                "menu-card-c": 'hsl(var(--menu-card-c))',
                "navbar": 'hsl(var(--navbar))',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms, require("daisyui")],


    daisyui: {
        themes: [
            {
                light:
                    {
                        ...require("daisyui/src/theming/themes")["light"],
                        '--menu-card-a': '44, 94%, 67%',
                        '--menu-card-b': '176, 47%, 52%',
                        '--menu-card-c': '190, 67%, 57%',
                        '--navbar': '176, 47%, 52%',
                    },
            },
            {
                dark:
                    {
                        ...require("daisyui/src/theming/themes")["dark"],
                        '--menu-card-a': '10, 100%, 15%',
                        '--menu-card-b': '176, 40%, 20%',
                        '--menu-card-c': '190, 67%, 15%',
                        '--navbar': '221 39% 11%',
                    }
            },
        ],
    },
};
