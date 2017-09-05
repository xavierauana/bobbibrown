/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

window.Vue = require('vue')

let _en = require("../../lang/en.json")
let _chi = require("../../lang/chi.json")


/**FillInTheBlankMultipleQuestion.vue
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.mixin({
            methods: {
              _removeOneChoice(choices, choice) {
                let theChoice = _.find(choices, {"id": choice.id})
                if (theChoice) {
                  theChoice.active = false
                }
                return choices
              },
              _removeAllChoiceEditors(escape_key = 'content') {
                _.forEach(Object.keys(CKEDITOR.instances), key => {
                  if (key.indexOf(escape_key) < 0 && key.indexOf('prefix')) {
                    CKEDITOR.instances[key].destroy(true)
                  } else {
                    CKEDITOR.instances[key].setData("")
                  }
                })
              },
              _removeCKEditor(editorName) {
                console.log(editorName)
              },
              validation(validationClosure) {
                var validation = validationClosure()
                if (validation.check) return true
                var message = validation.messages.join("! ")
                alert(message)
                return false
              },
              __(key) {
                const lang = document.getElementsByTagName('html')[0].getAttribute("lang");
                switch (lang) {
                  case 'chi':
                    return _chi[key] ? _chi[key] : ""
                  default:
                    return _en[key]
                }
              }
            },
          })

Vue.component('event_detail', require('./components/frontEnd/EventDetail.vue'))
Vue.component('test', require('./attempt/components/attempt.vue'))
Vue.component('event_sign_in', require('./components/frontEnd/EventSignIn.vue'))
Vue.component('my_events', require('./components/frontEnd/MyEvents.vue'))
Vue.component('my_progress', require('./components/frontEnd/Progress.vue'))
Vue.component('resources_table', require('./components/frontEnd/Resource.vue'))
Vue.component('user_events_table', require('./components/UserEventsTable.vue'))


//let data = "dummy"
//const Post = new BaseObject('posts')
//
//Post.index().then(response => console.log(response))
//    .catch(response => console.log(response))

const app = new Vue({
                      el     : '#app',
                      methods: {
                        back() {
                          window.history.back();
                        },
                        backWithConfirm(message) {
                          if (confirm(message)) {
                            this.back()
                          }
                        }
                      }
                    })
