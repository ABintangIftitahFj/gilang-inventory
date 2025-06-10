// vite.config.js

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/responsive.css',
                'resources/js/app.js',
                'resources/js/scanner.js', 
                'resources/js/mobile.js', // For mobile-friendly enhancements
                'resources/js/menu-fix.js', // Fix for mobile menu toggle
            ],
            refresh: true,
        }),
    ],
});