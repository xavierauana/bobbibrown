<template lang="html">
    <div>
        <div class="row" v-if="question.prefix && question.prefix.length > 0">
            <div class="col-sm-12 clearfix" v-html="question.prefix"></div>
         </div>
        <div>
            <show-answer :is_correct="result.is_correct" :correct_answer="showAnswer"></show-answer>
            <h4 class="question-number">Q: {{index}}</h4>
        </div>
        <div class="row">
            <div class="col-sm-8 clearfix" v-html="question.content"></div>
            <div class="col-sm-4 pull-right">
                <input class="form-control single-fill-in-input  pull-right" type="text"
                       :value="this.result.input[0]" :disabled="disabled">
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import ShowAnswer from "./show_answer.vue"
    import BaseQuestion from "./../../models/BaseQuestion"

    export default BaseQuestion.extend(
      {
        components: {
          ShowAnswer
        },
        computed  : {
          showAnswer(){
            return this.result.is_correct ? "" : this.result.correct_answer[0]
          }
        },
      }
    )
</script>
<style>
    input.single-fill-in-input {
        max-width: 150px;
    }
</style>