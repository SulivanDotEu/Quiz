// var $ = require('jquery');
// var greet = require('./greet');
//
// require('bootstrap-sass');
//
// $(document).ready(function() {
//     $('[data-toggle="popover"]').popover();
//
// });

import Vue from 'vue';
import App from './components/App'


/**
 * Create a fresh Vue Application instance
 */
new Vue({
    el: '#app',
    delimiters: ['${', '}'],
    components: [ App ],
    render: h => h(App)
});