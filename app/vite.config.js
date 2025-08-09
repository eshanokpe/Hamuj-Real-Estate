import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    server: {
        proxy: {
        '/api': 'http://localhost:8000',
        },
    },
    plugins: [
        laravel({
            input: [
                // 'resources/js/app.js',
                'resources/sass/app.scss',
                'resources/js/app.jsx',
            ],
            refresh: true,
        }),
        react(),
    ],
});
