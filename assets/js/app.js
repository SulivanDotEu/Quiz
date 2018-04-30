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


/**
 * Create a fresh Vue Application instance
 */
var app = new Vue({
    el: '#app',
    delimiters: ['${', '}'],
    data: {
        message: 'Hello Vue!'
    }
})