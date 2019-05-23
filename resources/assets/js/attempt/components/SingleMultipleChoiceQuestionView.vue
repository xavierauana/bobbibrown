<template lang="html">
    <div>
         <div class="row" v-if="question.prefix && question.prefix.length > 0">
            <div class="col-sm-12 clearfix" v-html="question.prefix"></div>
         </div>
        <div>
            <h4 class="question-number">Q: {{index}}</h4>
        </div>
        <div class="row">
            <div class="col-md-6 clearfix" v-html="question.content"></div>
            <div class="col-md-6 multiple-choices pull-right">
                <ul class="list-unstyled pull-right">
                    <li v-for="choice in randomChoices">
                        <label>
                            <input class="" type="radio"
                                   :value="choice.id"
                                   v-model="answer"
                                   @change.prevent="updateAnswer">
                            <span v-html="choice.content"></span>
                        </label>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
      props   : {
        index         : {
          type   : String,
          default: 1
        },
        onAnswerChange: {
          type    : Function,
          required: true
        },
        question      : {
          type    : Object,
          required: true
        },
        previous      : {
          type: Object
        }
      },
      data() {
        return {
          answer: ""
        }
      },
      computed: {
        randomChoices() {
          return _.shuffle(this.question.choices)
        }
      },
      mounted() {
        if (this.previous) {
          this.answer = this.previous.answer[0]
          this.updateAnswer()
        }
      },
      methods : {
        updateAnswer() {
          this.onAnswerChange(this.question.id, this.answer)
        }
      }
    }
</script>
<style>
    img {
        height: auto;
        max-width: 100%
    }
</style>
