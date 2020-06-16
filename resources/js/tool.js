Nova.booting((Vue, router, store) => {
    Vue.config.devtools = true
    Vue.component('nest-tool', require('./components/Tool'))
})
