import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    css: {
        preprocessorOptions: {
            scss: {
                quietDeps: true // This will silence the deprecation warnings
            }
        }
    },
    plugins: [
        laravel([
            'resources/sass/app.scss',
            'resources/js/app.js',
        ]),
    ],
});