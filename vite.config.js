import path from 'path'
import laravel from 'laravel-vite-plugin'
import vuePlugin from '@vitejs/plugin-vue'
import { defineConfig } from 'vite'
import { run } from 'vite-plugin-run'

const { APP_DOMAIN } = process.env

export default defineConfig({
    resolve: {
        alias: {
            '@': path.resolve('./resources/js'),
            '~': path.resolve('./resources/images'),
            'tailwind.config.js': path.resolve(__dirname, 'tailwind.config.js'),
            'ziggy-js': path.resolve(__dirname, 'vendor/tightenco/ziggy')
        }
    },
    build: {
        minify: 'terser',
        chunkSizeWarningLimit: 1500,

        rollupOptions: {
            output: {
                manualChunks (id) {
                    if (id.includes('node_modules')) {
                        return id.toString().split('node_modules/')[1].split('/')[0].toString()
                    }
                }
            }
        },

        sourcemap: true
    },
    optimizeDeps: {
        include: [
            'tailwind.config.js'
        ]
    },
    plugins: [
        laravel({
            hotFile: 'public/vite.hot',
            input: [
                'resources/js/app.ts'
            ],
            refresh: true,
            detectTls: APP_DOMAIN
        }),
        run([
            {
                name: 'generate routes',
                run: ['php', 'artisan', 'ziggy:generate'],
                pattern: ['routes/*.php']
            },
            {
                name: 'generate route types',
                run: ['php', 'artisan', 'generate-route-types'],
                pattern: ['routes/*.php']
            }
        ]),
        vuePlugin({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                    detectTls: APP_DOMAIN
                }
            }
        })
    ]
})
