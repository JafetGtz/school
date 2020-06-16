import Vue from 'vue'
import axios from 'axios'
import App from './App.vue'
import ErrorBag from './ErrorBag'
import '../sass/blank.scss'

window.ErrorBag = ErrorBag

const root = document.getElementById('app')
const { dataset } = root

const constants = JSON.parse(dataset.constants)
Object.assign(window, constants)
Object.assign(Vue.prototype, constants)

Vue.prototype.$http = axios.create({
    baseURL: window.location.origin,
    headers: {
        'X-CSRF-TOKEN': dataset.csrfToken,
        'X-Requested-With': 'XMLHttpRequest',
    },
})

Vue.prototype.$auth = JSON.parse(dataset.auth)

window.CSRF_TOKEN = dataset.csrfToken
Vue.prototype.CSRF_TOKEN = CSRF_TOKEN

Vue.prototype.route = route

const components = require.context('./components', false, /\.vue$/, 'lazy')

components.keys().forEach(key => {
    Vue.component(
        key.slice(key.lastIndexOf('/') + 1, key.lastIndexOf('.')),
        () => components(key)
    )
})

const kebabCase = string =>
    string
        .replace(/([a-z])([A-Z])/g, '$1-$2')
        .replace(/\s+/g, '-')
        .toLowerCase()

const pages = require.context('./pages', true, /\.vue$/, 'lazy')

pages.keys().forEach(key => {
    if (key.indexOf('_') > -1) return

    const filename = key.slice(key.lastIndexOf('/') + 1, key.lastIndexOf('.'))
    const path = key.slice(key.indexOf('/') + 1, key.lastIndexOf('/'))
    const name =
        (path ? path.replace(/\//g, '_') + '_' : '') + kebabCase(filename)

    Vue.component(name, () => pages(key))
})

const layouts = require.context('./layouts', true, /\.vue$/, 'lazy')

layouts.keys().forEach(key => {
    const name = kebabCase(
        key.slice(key.lastIndexOf('/') + 1, key.lastIndexOf('.'))
    )
    Vue.component(name, () => layouts(key))
})

Vue.config.productionTip = false

const Page = Vue.component(dataset.pageName.replace(/\./g, '_'))
const Layout = Vue.component(dataset.layout)
const props = JSON.parse(dataset.routeData) || {}

const app = new Vue({
    el: root,
    render: h =>
        h(App, {
            scopedSlots: {
                default: () =>
                    h(Layout, {
                        scopedSlots: { default: () => h(Page, { props }) },
                    }),
            },
        }),
})
