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


Vue.component('example', require('./components/Example.vue'))
Vue.component('test_table', require('./components/TestsTable.vue'))
Vue.component('event_table', require('./components/EventsTable.vue'))
Vue.component('event_detail', require('./components/frontEnd/EventDetail.vue'))
Vue.component('user_events_table', require('./components/UserEventsTable.vue'))
Vue.component('collection_lessons', require('./components/CollectionLessons.vue'))
Vue.component('lesson_list', require('./components/LessonsList.vue'))
Vue.component('lesson_table', require('./components/LessonsTable.vue'))
Vue.component('question_list', require('./components/QuestionList.vue'))
Vue.component('permission_table', require('./components/PermissionsTable.vue'))
Vue.component('create_question', require('./questions/components/CreateQuestionPage.vue'))
Vue.component('edit_question', require('./questions/EditQuestion/components/main.vue'))
Vue.component('menu_table', require('./components/MenuTable.vue'))
Vue.component('user_table', require('./components/UsersTable.vue'))
Vue.component('role_table', require('./components/RolesTable.vue'))
Vue.component('role_permissions', require('./components/RolePermissions.vue'))
Vue.component('test', require('./attempt/components/attempt.vue'))
Vue.component('event_sign_in', require('./components/frontEnd/EventSignIn.vue'))

const app = new Vue({
                      el: '#app'
                    })
