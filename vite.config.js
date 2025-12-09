import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/HealthCoreLight.css', 'resources/js/HealthCoreLight.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
