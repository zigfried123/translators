import {fileURLToPath, URL} from 'node:url'

import {defineConfig} from 'vite'
import vue from '@vitejs/plugin-vue'
import vueDevTools from 'vite-plugin-vue-devtools'

// https://vite.dev/config/
export default defineConfig({
    plugins: [
        vue(),
        vueDevTools(),
    ],
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./src', import.meta.url))
        },
    },
    server: {
        port: 5173, // Or your preferred port
        strictPort: true, // Ensures the port is available
        host: true, // Allows access from outside the container
        watch: {
            usePolling: true, // Essential for Docker environments
            interval: 100, // Adjust as needed
        },
        hmr: {
            host: 'localhost', // Or the IP address of your host machine
            port: 5173, // The same port as the server
        },
    },
})
