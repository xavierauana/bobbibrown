<template lang="html">
    <div id="test-section">
        <div class="title">
            <h2>{{title}} <span class="result pull-right" v-text="showResult"></span></h2>
        </div>
        <div class="question" v-if="questions.length > 0" v-for="(question, index) in questions">
            <component
                    :index="computeIndex(index)"
                    :is="getComponent(question.question_type_id)"
                    :on-answer-change="updateAnswer"
                    :question="getQuestionObject(question)"
                    v-show="current_page == question.page_number"
                    :result="getResultForQuestion(question)"
                    :disabled="true"
            ></component>
        </div>
        <div class="row">
            <button class="pull-left btn btn-default" v-show="has_previous_page" @click.prevent="current_page--">
                previous
            </button>
            <button class="pull-right btn btn-default" v-show="has_next_page" @click.prevent="current_page++">
                next
            </button>
        </div>
        <div class="footer-buttons clearfix">
            <h2 class="total-question">Total Questions：{{numberOfMarks}}</h2>
        </div>
    </div>
</template>

<script type="text/babel">
    import _ from "lodash"
    import Question from "./../../models/Question"
    import InlineMultipleChoice from "./InlineMultipleChoiceQuestionView.vue"
    import MultipleMultipleChoice from "./MultipleMultipleChoiceQuestionView.vue"
    import SingleMultipleChoice from "./SingleMultipleChoiceQuestionView.vue"
    import SingleFillInBlanks from "./SingleFillInBlanksQuestionView.vue"
    import MultipleFillInBlanks from "./MultipleFillInBlanksQuestionView.vue"
    import ReOrder from "./ReOrderQuestionView.vue"
    import Comprehension from "./ComprehensionQuestionView.vue"
    import InlineFillInBlanks from "./InlineFillInBlanksQuestionView.vue"

    export default{
      props     : {
        _result: {
          type: Array,
          default(){return null}
        },
        _score : {
          type   : Number,
          default: -1
        }
      },
      data(){
        return {
          current_page : 1,
          score        : 0,
          result       : [],
          answers      : [],
          questionTypes: [],
          questions    : [],
          title        : ""
        }
      },
      computed  : {
        showResult(){
          if (this.result['key'] && this.result['key'] === 'class_overall') return ""
          return Math.floor(this.score * this.numberOfMarks) + "/" + this.numberOfMarks
        },
        numberOfMarks(){
          if (this.questions.length > 0) {
            return _.reduce(this.questions, (previous, question) => {
              return previous += (question.sub_questions && question.sub_questions.length > 0) ? question.sub_questions.length : 1
            }, 0)
          }
          return 0
        },
        current_questions(){
          return this.questions.filter(question => question.page_number == this.current_page)
        },
        has_next_page(){
          return this.questions.filter(question => question.page_number > this.current_page).length > 0
        },
        has_previous_page(){
          return this.questions.filter(question => question.page_number < this.current_page).length > 0
        }
      },
      components: {
        ReOrder,
        Comprehension,
        InlineFillInBlanks,
        SingleFillInBlanks,
        InlineMultipleChoice,
        SingleMultipleChoice,
        MultipleFillInBlanks,
        MultipleMultipleChoice,
      },
      created(){
        const uri = this.getUri()

        this.$http.get(uri)
            .then(
              response => {
                this.title = response.data.test.title
                this.questionTypes = response.data.questionTypes

                this.result = _.isEmpty(this._result) ? response.data.result.attempt : this._result

                this.score = this._score > -1 ? this._score : response.data.result.score

                _.chain(response.data.test.questions)
                 .sortBy(question => question.order)
                 .forEach(question => this.questions.push(_.assign({}, question)))
                 .value()
                Vue.nextTick(() => {
                  let els = document.getElementById('test-section').getElementsByTagName('img')
                  for (var i = 0; i < els.length; i++) {
                    els[i].removeAttribute("style")
                  }
                })
              },
              response => console.log(response)
            )
      },
      methods   : {
        getResultForQuestion(question){
          if (this.result['key'] && this.result['key'] === 'class_overall') {
            return this.getOverallClassResult(question)
          }
          return question.sub_questions ?
                 _.map(question.sub_questions, question => _.find(this.result, {id: question.id})) :
                 _.find(this.result, {id: question.id})
        },
        computeIndex(index){
          let start = 0,
              end   = 0


          for (var i = 0; i < index; i++) {
            if (this.questions[i].sub_questions && this.questions[i].sub_questions.length > 1) {
              start += this.questions[i].sub_questions.length
            } else {
              start = start + 1
            }
          }
          if (this.questions[index].sub_questions && this.questions[index].sub_questions.length > 1) {
            end = start + this.questions[i].sub_questions.length
            start = start + 1
          } else {
            start = start + 1
            end = start
          }
          if (start === end) {
            return end.toString()
          }
          return [start, end].join(" - ")
        },
        in_current_page(question){
          return !!question.page_number == this.currentPage
        },
        getUri(){
          return window.location.href + "/result"
        },
        updateAnswer(questionId, updateAnswer){
          updateAnswer = _.isArray(updateAnswer) ? updateAnswer : [updateAnswer]

          let answer = _.find(this.answers, {"id": questionId})
          if (answer) {
            answer.answer = updateAnswer
          } else {
            this.answers.push({id: questionId, answer: updateAnswer})
          }
        },
        getComponent(questionTypeId){
          const questionTypeCode = _.find(this.questionTypes, {"id": questionTypeId}).code
          return questionTypeCode
        },
        getOverallClassResult(question){

        },
        getQuestionObject(question){
          return new Question(question)
        }
      }
    }
</script>
<style>
    body {
        color: black
    }

    nav.nav.navbar-nav.col-xs-12.sub-menu {
        margin: 0
    }

    #test-section {
        font-family: '標楷體', sans-serif, Arial, Verdana, "Trebuchet MS";
    }

    #test-section .save-button {
        font-size: 0.8em;
        margin-top: -3px;
    }

    #test-section > .row {
        margin: auto 0
    }

    div.question {
        margin-bottom: 0;
    }

    div.question input {
        font-size: 1.2em;
    }

    h4.question-number {
        color: blue;
        margin: 0;
    }

    h4.question-number .col-md-8 {
        padding-top: 0;
    }

    div.question > div > div:first-child {
        padding-bottom: 0;
    }

    div.question div {
        padding: 5px 10px
    }

    div.question label {
        margin: 0;
        line-height: 1.4em;
        font-size: 1.6em;
    }

    div.title {
        color: white;
        background-color: blue;
        padding: 10px;
    }

    div.title h2 {
        margin: 0;
    }

    div.question .row {
        padding: 0;
        margin: 0;
    }

    div.question .row div.col-md-8:first-child {
        padding-top: 0;
    }

    div.footer-buttons {
        margin: 15px;
    }

    h2.total-question {
        margin: 0;
        line-height: 66px
    }
</style>
