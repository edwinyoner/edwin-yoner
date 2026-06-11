// import defaultTheme from 'tailwindcss/defaultTheme';
// import forms from '@tailwindcss/forms';
// import typography from '@tailwindcss/typography';

// /** @type {import('tailwindcss').Config} */
// export default {
//     content: [
//         './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
//         './vendor/laravel/jetstream/**/*.blade.php',
//         './storage/framework/views/*.php',
//         './resources/views/**/*.blade.php',
//     ],

//     theme: {
//         extend: {
//             fontFamily: {
//                 sans: ['Figtree', ...defaultTheme.fontFamily.sans],
//             },
//         },
//     },

//     plugins: [forms, typography],
// };
/** 
@type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'icco': {
          'red': '#bf0f11',
          'red-muted': '#b58182',
          'gray-dark': '#4b4b4b',
          'gray-light': '#cfcacb',
        },
      },
      fontFamily: {
        sans: ['Figtree', 'sans-serif'],
      },
    },
  },
  plugins: [],
}