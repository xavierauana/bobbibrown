<template lang="html">
    <div class="row">
        <div class="col-xs-12">
             <ul class="list-unstyled" :id="listId">
                <li v-for="(lesson, index) in lessons" :data-id="lesson.id">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                    <span v-text="lesson.title"></span>
                </li>
            </ul>
            <button class="btn btn-primary btn-block" @click.prevent="updateOrder">Update Order</button>
        </div>
    </div>
</template>

<script type="text/babel">
    import Sortable from "sortablejs"
    import {Collections as urls} from "./../endpoints"
    export default{
      props   : {
        collectionId  : {
          type    : Number,
          required: true
        },
        initialLessons: {
          type    : Array,
          required: true
        }
      },
      data(){
        return {
          lessons: JSON.parse(JSON.stringify(this.initialLessons)),
          el     : {},
          urls   : urls
        }
      },
      computed: {
        listId(){
          return "list_" + this._uid
        }
      },
      mounted(){
        this.el = document.getElementById(this.listId)
        Sortable.create(this.el, {
          handle: ".fa.fa-bars"
        })
      },
      methods : {
        updateOrder(){
          this.createLessonOrderData()
          axios.post(this.urls.lessons_order(this.collectionId), this.lessons)
               .then(() => alert('Question Order Updated!'))
               .catch(response => console.log(response))
        },
        createLessonOrderData(){
          let counter = 0;

          for (let li of this.el.getElementsByTagName('li')) {
            let lesson = _.find(this.lessons, {id: parseInt(li.dataset.id)})
            if (lesson) {
              lesson.pivot.order = counter
            }
            counter += 1
          }
        },
        deleteLesson(index){

          if (confirm('Are you sure you want to delete the lesson?')) {
            let lesson = this.lessons[index],
                url    = this.urls.delete(this.collectionId, lesson.id)

            axios.delete(url)
                 .then(() => {
                   this.lessons.splice(index, 1)
                   alert("Question deleted")
                 })
                 .then(() => this.lessons.splice(index, 1))
          }
        }
      }
    }
</script>
<style scoped>
    ul li {
        min-height: 30px;
        line-height: 30px;
        border: 1px solid #c7c7c7;
        margin-bottom: 15px;
        padding: 5px;
        border-radius: 5px;
    }

    ul li button {
        margin-right: 15px;
    }

    ul li button:first-child {
        margin-right: 0;
    }
</style>