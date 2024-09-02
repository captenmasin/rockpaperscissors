import '../css/app.css'
import './echo'
import BaseLayout from '@/Layouts/BaseLayout.vue'
import { createApp, h } from 'vue'
import type { DefineComponent } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'

import.meta.glob(['../images/**', '../fonts/**'])

createInertiaApp({
    title: title => `${title} - ${import.meta.env.VITE_APP_NAME}`,
    resolve: async (name) => {
        const pages = import.meta.glob <DefineComponent>('./Pages/**/*.vue', { eager: true })
        const page = pages[`./Pages/${name}.vue`]

        page.default.layout = page.default.layout || ((h, p) => h(BaseLayout, () => [p]))

        return page
    },
    setup ({
        el,
        App,
        props,
        plugin
    }) {
        const app = createApp({
            render: () => h(App, props)
        })
        app.use(plugin)

        app.config.performance = true

        app.mount(el)
    },
    progress: {
        delay: 100,
        color: '#6E51FC',
        includeCSS: true,
        showSpinner: false
    }
}).then(r => '')
