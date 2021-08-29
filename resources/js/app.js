require('./bootstrap');

// Import modules...
import { createApp, h } from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import Vuex from 'vuex'
import adminStore from './store/admin'

const store = new Vuex.Store({
    modules: {
        admin: adminStore,
    }
})

const el = document.getElementById('app');

createApp({
    render: () =>
        h(InertiaApp, {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: (name) => require(`./Pages/${name}`).default,
        }),
    mounted () {
        if(this.$page.props.user) {
            localStorage.setItem('user', JSON.stringify(this.$page.props.user))
        }
    }
})
    .mixin({ methods: { route } })
    .use(InertiaPlugin)
    .use(store)
    .mount(el);

InertiaProgress.init({ color: '#4B5563' });
