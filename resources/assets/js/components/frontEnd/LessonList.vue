<template lang="html">
    <div class="lesson-list">
        <h4><a :href="'collections/'+collection.id"
               v-text="collection.title"></a> </h4>
        <ul class="list-group borderless">
          <li class="list-group-item" v-for="lesson in collection.lessons">
           <div class="row">
               <div class="col-xs-9 col-md-10 col-lg-11">
                    {{lesson.title}}
               </div>
               <div class="col-xs-3 col-md-2  col-lg-1"
                    v-html="getResultHtml(lesson)">
               </div>
           </div>
          </li>
        </ul>
    </div>

</template>

<script type="text/babel">
    export default {
      name   : "lesson-list",
      props  : {
        collection  : {
          type    : Object,
          required: true
        },
        lessonStatus: {
          type    : Object,
          required: true
        }
      },
      methods: {
        getResultHtml(lesson) {
          if (lesson.tests.length > 0 && this.lessonStatus[parseInt(lesson.tests[0].id)]) {
            const state = this.lessonStatus[parseInt(lesson.tests[0].id)]
            if (state.is_completed) {
              return '<span class="label label-success">Passed</span>'
            } else if (state.is_overdue) {
              return '<span class="label label-danger">Overdue</span>'
            } else {
              return '<span class="label label-info">Due in ' + state.due_in_days + ' days</span>'
            }
          }
        }
      }
    }
</script>
<style scoped>

  .borderless .list-group-item {
      border: none;
  }
</style>