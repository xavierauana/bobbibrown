<template lang="html">
    <div class="row">
        <div class="col-xs-12">
             <ul class="list-unstyled" :id="listId">
                <li v-for="(question, index) in questions" :data-id="question.id">
                    <span class="clearfix">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                        <button class="btn-sm btn btn-danger pull-right"
                                @click.prevent="deleteQuestion(index)">Delete</button>
                        <a :href="urls.edit(testId, question.id)" class="btn-sm btn btn-info pull-right">Edit</a>
                    </span>

                    <div class="summary" v-html="question.content"></div>
                </li>
            </ul>
            <button class="btn btn-primary btn-block" @click.prevent="updateOrder">Update Order</button>
        </div>
    </div>
</template>

<script type="text/babel">
    import Sortable from "sortablejs"
    import Question from "./../models/Question"
    import {Questions as urls} from "./../endpoints"
    export default{
      props   : {
        testId          : {
          type    : Number,
          required: true
        },
        initialQuestions: {
          type    : Array,
          required: true
        }
      },
      data(){
        return {
          questions: [],
          el       : {},
          urls     : urls
        }
      },
      computed: {
        listId(){
          return "list_" + this._uid
        }
      },
      created(){
        for (let q of this.initialQuestions) {
          this.questions.push(new Question(q))
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
          this.createQuestionOrderData()
          axios.post('/admin/questions/updateOrder', this.questions)
               .then(() => alert('Question Order Updated!'))
               .catch(response => console.log(response))
        },
        createQuestionOrderData(){
          let counter = 0;

          for (let li of this.el.getElementsByTagName('li')) {
            let question = _.find(this.questions, {id: parseInt(li.dataset.id)})
            if (question) {
              question.order = counter
            }
            counter += 1
          }
        },
        deleteQuestion(index){

          if (confirm('Are you sure you want to delete the question?')) {
            let question = this.questions[index],
                url      = this.urls.delete(this.testId, question.id)

            axios.delete(url)
                 .then(() => {
                   this.questions.splice(index, 1)
                   alert("Question deleted")
                 })
                 .then(() => this.questions.splice(index, 1))
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

    ul li div.summary {
        max-height: 50px;
        overflow: hidden
    }

    ul li button {
        margin-right: 15px;
    }

    ul li button:first-child {
        margin-right: 0;
    }
</style>