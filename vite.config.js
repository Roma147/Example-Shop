import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0', // Убедитесь, что это есть для внешнего доступа
        hmr: {
            host: process.env.VITE_HMR_HOST || 'localhost', // Используем переменную окружения
            protocol: 'wss', // <--- ДОБАВЬТЕ ЭТУ СТРОКУ
        },
    }
});