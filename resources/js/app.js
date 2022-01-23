require('./bootstrap');

window.Vue = require('vue').default;

Vue.component('Board', require('./Board.vue').default);

const app = new Vue({
    el: '#app',
});
