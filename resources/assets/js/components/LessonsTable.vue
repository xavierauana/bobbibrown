<template lang="html">
<div>
    <input v-model="filterBy" placeholder="Filter By..."
           class="form-control">
    <br>
    <table class="table filtered" v-if="lessons.length">
       <thead>
            <th @click="sortBy('title')"
                :class="upDownOrNone('title')">Title</th>
            <th @click="sortBy('is_featured')"
                :class="upDownOrNone('is_featured')">Featured</th>
            <th @click="sortBy('is_new')"
                :class="upDownOrNone('is_new')">New</th>
            <th>Actions</th>
       </thead>
       <tbody>
               <tr v-for="(lesson, index) in refinedLessons">
                   <td v-text="lesson.title"></td>
                   <td>
                       <span class="label"
                             :class="{'label-success':lesson.is_featured,'label-warning':!lesson.is_featured}"
                       >{{lesson.is_featured?'Featured':'Not Featured'}}</span>
                   </td>
                   <td>
                       <span class="label"
                             :class="{'label-success':lesson.is_new,'label-warning':!lesson.is_new}">{{lesson.is_new?'New':'Not New'}}</span>
                   </td>
                    <td>
                        <button-group :labels="labels"
                                      :on-click-functions="onClickFunctions"
                                      :row-number="index"></button-group>
                    </td>
               </tr>
       </tbody>
   </table>
</div>
</template>

<script type="text/babel">
    import {Lessons as urls} from "../endpoints"
    import ButtonGroup from "../elements/ButtonGroups.vue"

    export default {
      name      : "lessons-table",
      components: {
        ButtonGroup
      },
      data() {
        return {
          filterBy        : "",
          order           : 1,
          sortByKey       : null,
          urls            : urls,
          lessons         : [],
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
      created() {
        axios.get(window.location.href + "?ajax=true")
             .then(({data}) => this.lessons = data)
      },
      computed  : {
        refinedLessons() {
          let lessons = this.lessons
          if (this.filterBy.length) {
            lessons = _.filter(lessons, lesson => {
              return lesson.title.indexOf(this.filterBy) > -1
            })
          }
          if (this.sortByKey) {
            lessons = _.sortBy(lessons, lesson => lesson[this.sortByKey])
          }
          if (this.order < 0) {
            lessons = _.reverse(lessons)
          }
          return lessons
        },
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
        },
        upDownOrNone(key) {
          if (this.sortByKey !== key) return
          return this.order > 0 ? "up" : "down"
        },
        sortBy(key) {
          if (this.sortByKey === key) {
            this.order = this.order * -1
          } else {
            this.sortByKey = key
            this.order = 1
          }
        }
      }
    }
</script>
<style>
    table.filtered thead th::after {
        content: "";
        position: relative;
        display: none;
        width: 0;
        height: 0;
        margin-left: 0.5em;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
    }

    table.filtered thead th.up::after {
        content: "";
        position: relative;
        display: inline-block;
        border-bottom: 5px solid black;
    }

    table.filtered thead th.down::after {
        content: "";
        position: relative;
        display: inline-block;
        border-top: 5px solid black;
    }
</style>