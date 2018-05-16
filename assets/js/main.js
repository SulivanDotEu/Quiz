var $ = require('jquery');
// var greet = require('./greet');
//
require('bootstrap');
//
// $(document).ready(function() {
//     $('[data-toggle="popover"]').popover();
//
// });

import Vue from 'vue';
import VueResource from 'vue-resource'
import App from './components/App'

Vue.use(VueResource)

// class ContextStore {
//
//     constructor()
//     {
//         this.state = {
//
//         }
//     }
//
// }

/**
 * Create a fresh Vue Application instance
 */
new Vue({
    el: '#app',
    data() {
        return {
        }
    },
    delimiters: ['${', '}'],
    render: h => h(App)
});