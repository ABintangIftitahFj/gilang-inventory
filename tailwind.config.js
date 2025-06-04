/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php", // Memindai semua file .blade.php di folder resources
    "./resources/**/*.js",       // Memindai semua file .js di folder resources
    "./resources/**/*.vue",      // Memindai semua file .vue di folder resources (jika Anda menggunakan Vue.js)
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}