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
                            <input class="" type="checkbox" :value="choice.id" v-model="answers"
                                   @click="updateAnswer">
                            <span v-html="choice.content"></span>
                        </label>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default{
      props   : {
        index         : {
          type   : String,
          defalut: 1
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
      data(){
        return {
          answers: []
        }
      },
      computed: {
        randomChoices(){
          return _.shuffle(this.question.choices)
        }
      },
      mounted(){
        if (this.previous) {
          this.answers = this.previous.answer
          this.updateAnswer()
        }
      },
      methods : {
        updateAnswer(){
          this.onAnswerChange(this.question.id, this.answers)
        }
      }
    }
</script>