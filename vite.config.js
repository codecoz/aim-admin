import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import {viteStaticCopy} from 'vite-plugin-static-copy'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js'
            ],
            refresh: true,
        }),
        viteStaticCopy({
            targets: [
                {
                    src: 'vendor/codecoz/aim-admin/resources/img',
                    dest: '../'
                },
                {
                    src: 'node_modules/admin-lte/dist/img',
                    dest: '../dist'
                }
            ]
        })
    ],
    build: {
        rollupOptions: {
            output: {
                manualChunks(id) {
                    if (id.includes('node_modules')) {
                        return 'vendor'; // split vendor modules into a separate chunk
                    }
                    // more conditions for other chunks
                }
            }
        },
        chunkSizeWarningLimit: 500, // Adjust the chunk size limit
    },
    server: {
        hmr: {
            host: 'localhost',
            protocol: 'ws',
            port: 3000
        }
    },
});
