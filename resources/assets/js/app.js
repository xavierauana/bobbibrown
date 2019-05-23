/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

window.Vue = require('vue')


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
            }
          })


Vue.component('example', require('./components/Example'))
Vue.component('test_table', require('./components/TestsTable'))
Vue.component('event_table', require('./components/EventsTable'))
Vue.component('event_detail', require('./components/frontEnd/EventDetail'))
Vue.component('collection_lessons', require('./components/CollectionLessons'))
Vue.component('lesson_list', require('./components/LessonsList'))
Vue.component('lesson_table', require('./components/LessonsTable'))
Vue.component('question_list', require('./components/QuestionList'))
Vue.component('permission_table', require('./components/PermissionsTable'))
Vue.component('create_question', require('./questions/components/CreateQuestionPage'))
Vue.component('edit_question', require('./questions/EditQuestion/components/main'))
Vue.component('menu_table', require('./components/MenuTable'))
Vue.component('user_table', require('./components/UsersTable'))
Vue.component('trashed-user-table', require('./components/TrashedUserTable'))
Vue.component('role_table', require('./components/RolesTable'))
Vue.component('role_permissions', require('./components/RolePermissions'))
Vue.component('test', require('./attempt/components/attempt'))
Vue.component('event_sign_in', require('./components/frontEnd/EventSignIn'))
Vue.component('my_events', require('./components/frontEnd/MyEvents'))
Vue.component('collection_table', require('./components/CollectionsTable'))
Vue.component('categories_table', require('./components/CategoriesTable'))
Vue.component('lines_table', require('./components/LinesTable'))
Vue.component('products_table', require('./components/ProductsTable'))

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
