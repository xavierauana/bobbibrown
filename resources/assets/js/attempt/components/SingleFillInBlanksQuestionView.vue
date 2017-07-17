<template lang="html">
    <div>
        <div class="row" v-if="question.prefix && question.prefix.length > 0">
            <div class="col-sm-12 clearfix" v-html="question.prefix"></div>
         </div>
        <div>
            <h4 class="question-number">Q: {{index}}</h4>
        </div>
        <div class="row">
            <div class="col-sm-8 clearfix" v-html="question.content"></div>
            <div class="col-sm-4 pull-right">
                <input class="form-control single-fill-in-input pull-right" type="text" @change.prevent="updateAnswer"
                       v-model="answer">
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default{
      props  : {
        index         : {
          type   : String,
          default: 1,
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
          answer: ""
        }
      },
      mounted(){
        if (this.previous) {
          this.answer = this.previous.answer[0]
          this.updateAnswer()
        }
      },
      methods: {
        updateAnswer(){
          this.onAnswerChange(this.question.id, this.answer)
        }
      }
    }
</script>
<style>
    input.single-fill-in-input {
        max-width: 150px;
    }
</style>