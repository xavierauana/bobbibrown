/**
 * Created by Xavier on 6/4/2017.
 */
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

window.Vue = require('vue');
require('vue-resource');

window.$ = window.jQuery = require('jquery')
$.extend(require('jquery-ui-bundle'))
require('bootstrap')

/**
 * We'll register a HTTP interceptor to attach the "CSRF" header to each of
 * the outgoing requests issued by this application. The CSRF middleware
 * included with Laravel will automatically verify the header's value.
 */

Vue.http.interceptors.push((request, next) => {
  var token = document.querySelector("meta[name='csrf_token']").getAttribute("content")

  if (token) {
    request.headers.set('X-CSRF-TOKEN', token);
  }
  next();
});


/**
 * Check for some js function availability
 */
if (!String.prototype.format) {
  String.prototype.format = function() {
    var args = arguments;
    return this.replace(/{(\d+)}/g, function(match, number) {
      return typeof args[number] != 'undefined'
        ? args[number]
        : match
        ;
    });
  };
}


import MainContainer from "./components/main.vue"

const app = new Vue({
                      el        : '#answerForm',
                      components: {
                        MainContainer
                      },
                      mounted(){
                        console.log('vue loaded')
                      },
                    });