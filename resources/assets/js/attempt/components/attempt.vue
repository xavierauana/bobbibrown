<template lang="html">
    <div id="test-section">
        <div class="question" v-if="questions.length > 0" v-for="(question, index) in questions">
            <component
                    :is="getComponent(question.question_type_id)"
                    :index="computeIndex(index)"
                    :on-answer-change="updateAnswer"
                    :question="question"
                    :previous="get_previous_attempt(question)"
                    v-show="current_page == question.page_number"
            ></component>
            <hr>
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
            <button class="btn btn-success pull-right" @click.prevent="submit">Submit</button>
            <h2 class="total-question">Total Questions：{{numberOfMarks}}</h2>
        </div>
    </div>
</template>

<script type="text/babel">
    import _ from "lodash"
    import InlineMultipleChoice from "./InlineMultipleChoiceQuestionView.vue"
    import MultipleMultipleChoice from "./MultipleMultipleChoiceQuestionView.vue"
    import SingleMultipleChoice from "./SingleMultipleChoiceQuestionView.vue"
    import SingleFillInBlanks from "./SingleFillInBlanksQuestionView.vue"
    import MultipleFillInBlanks from "./MultipleFillInBlanksQuestionView.vue"
    import ReOrder from "./ReOrderQuestionView.vue"
    import Comprehension from "./ComprehensionQuestionView.vue"
    import InlineFillInBlanks from "./InlineFillInBlanksQuestionView.vue"
    import {Tests as urls} from "./../../endpoints"

    export default {
      created() {
        const uri = this.getUri()
        axios(uri)
          .then(
            response => {
              this.title = response.data.test.title
              this.questionTypes = response.data.questionTypes
              if (response.data.previous) {
                this.previous = response.data.previous.attempt
              }

              _.chain(response.data.test.questions)
               .sortBy(question => question.order)
               .forEach(question => this.questions.push(_.assign({}, question)))
               .value()


              Vue.nextTick(() => {
                let els = document.getElementById('test-section').getElementsByTagName('img')
                for (let i = 0; i < els.length; i++) {
                  els[i].removeAttribute("style")
                }
              })

            },
            response => console.log(response)
          )
      },
      data() {
        return {
          current_page : 1,
          answers      : [],
          questionTypes: [],
          questions    : [],
          title        : "",
          previous     : []
        }
      },
      computed  : {
        numberOfMarks() {
          if (this.questions.length > 0) {
            return _.reduce(this.questions, (previous, question) => {
              return previous += (question.sub_questions && question.sub_questions.length > 0) ? question.sub_questions.length : 1
            }, 0)
          }
          return 0
        },
        current_questions() {
          return this.questions.filter(question => question.page_number == this.current_page)
        },
        has_next_page() {
          return this.questions.filter(question => question.page_number > this.current_page).length > 0
        },
        has_previous_page() {
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
      methods   : {
        computeIndex(index) {
          let start = 0,
              end   = 0
          for (let i = 0; i < index; i++) {
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
        in_current_page(question) {
          return !!question.page_number == this.currentPage
        },
        getUri() {
          return window.location.href + "?ajax=1"
        },
        updateAnswer(questionId, updateAnswer) {
          updateAnswer = _.isArray(updateAnswer) ? updateAnswer : [updateAnswer]

          let answer = _.find(this.answers, {"id": questionId})
          if (answer) {
            answer.answer = updateAnswer
          } else {
            this.answers.push({id: questionId, answer: updateAnswer})
          }
        },
        getComponent(questionTypeId) {
          return _.find(this.questionTypes, {"id": questionTypeId}).code
        },
        responseClosure(response) {
          if (response.data.is_passed) {
            alert('Congratulations! You pass the test!')
          } else {
            alert('Sorry! You cannot pass the test. Please try again')
          }

          window.location.href = window.location.href.replace("/test", '')
        },

        submit() {
          const uri = window.href.location
          if (this.answers.length === this.numberOfMarks || confirm('you still have question haven\'t filled, you are sure to submit?')) {
            axios.post(uri, this.answers)
                 .then(this.responseClosure)
                 .catch(this.failClosure)
          }
        },
        getTestIdFromUrl() {
          let segments = window.location.href.split("/"),
              test_id  = segments[segments.length - 2]
          return test_id
        },
        get_previous_attempt(question) {
          return null
        },
        failClosure(response) {
          console.log("failed, ", response)
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
        color: #000000;
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

    div.multiple-choices ul {
        display: inline-block;
        padding: 15px;
        border: 2px solid #f0f0f0;
        border-radius: 5px;
    }

</style>
