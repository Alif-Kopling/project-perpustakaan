/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'soft-brown': '#C4A484',
        'dark-tea-brown': '#8B6F47',
        'cream': '#F5EFE6',
        'light-beige': '#E8DCC8',
        'white': '#FFFFFF',
        'border-soft': '#D6D3CE',
      }
    },
  },
  plugins: [],
}