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
    build: {
        manifest: true, // This generates manifest.json
        outDir: 'public/build',
        rollupOptions: {
            output: {
                entryFileNames: 'assets/[name]-[hash].js',
                chunkFileNames: 'assets/[name]-[hash].js',
                assetFileNames: 'assets/[name]-[hash].[ext]'
            }
        }
    },
});
