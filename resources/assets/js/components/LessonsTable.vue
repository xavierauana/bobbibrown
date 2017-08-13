<template lang="html">
    <table class="table">
       <thead>
            <th>Title</th>
            <th>Actions</th>
       </thead>
       <tbody>
               <tr v-for="(lesson, index) in lessons">
                   <td v-text="lesson.title"></td>
                    <td>
                        <button-group :labels="labels" :on-click-functions="onClickFunctions"
                                      :row-number="index"></button-group>
                    </td>
               </tr>
       </tbody>
   </table>
</template>

<script type="text/babel">
    import {Lessons as urls} from "../endpoints"
    import ButtonGroup from "../elements/ButtonGroups.vue"

    export default {
      name:"lessons-table",
      components: {
        ButtonGroup
      },
      props     : {
        initialLessons: {
          type    : Array,
          required: true
        }
      },
      data() {
        return {
          urls            : urls,
          lessons         : JSON.parse(JSON.stringify(this.initialLessons)),
          onClickFunctions: [
            this.goToTestPage,
            this.goToUserPage,
            this.goToEditPage,
            this.deleteLesson
          ],
          labels          : [
            {label: "Test", "class": "btn-default"},
            {label: "Users", "class": "btn-primary"},
            {label: "Edit", "class": "btn-info"},
            {label: "Delete", "class": "btn-danger"},
          ],
        }
      },
      methods   : {
        goToTestPage(index) {
          const lesson = this.lessons[index]
          window.location.href = this.urls.tests(lesson.id);
        },
        goToEditPage(index) {
          const lesson = this.lessons[index]
          window.location.href = this.urls.edit(lesson.id);
        },
        deleteLesson(index) {
          let lesson = this.lessons[index],
              url    = this.urls.delete(lesson.id)
          if (confirm('going to delete' + lesson.title)) {
            axios.delete(url)
                 .then(response => this.lessons.splice(index, 1))
                 .catch(response => console.log(response))
          }
        },
        goToUserPage(index) {
          const lesson = this.lessons[index]
          window.location.href = this.urls.users(lesson.id)
        }
      }
    }
</script>
<style></style>