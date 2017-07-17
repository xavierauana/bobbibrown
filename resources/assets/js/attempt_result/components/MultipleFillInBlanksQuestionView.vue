<template lang="html">
    <div>

        <div class="row" v-if="question.prefix && question.prefix && question.prefix.length > 0">
            <div class="col-sm-12 clearfix" v-html="question.prefix"></div>
         </div>
        <div>
             <div class="ans-collection">
                <show-answer :is_correct="result.is_correct"
                             :correct_answer="showAnswer()"></show-answer>
            </div>
            <h4 class="question-number">Q: {{index}}</h4>
        </div>
        <div class="row">
            <div class="col-md-6 clearfix" v-html="question.content"></div>
            <div class="col-md-6 pull-right">
                <div class="pull-right" v-if="!question.is_fractional && result">
                    <div class="col-xs-4 non-fractional" v-for="n in result.correct_answer.length">
                        <input :disabled="disabled" class="form-control" type="text" :value="oldInput(n-1)">
                        <span v-if="n < result.correct_answer.length"><i class="fa fa-arrow-right" aria-hidden="true"></i></span>
                    </div>
                </div>
                <div v-if="question.is_fractional" class="fractional pull-right col-xs-12">
                        <input :disabled="disabled" class="form-control" type="text" :value="oldInput(0)">
                        <hr />
                        <input :disabled="disabled" class="form-control" type="text" :value="oldInput(1)">
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import ShowAnswer from "./show_answer.vue"
    import BaseQuestion from "./../../models/BaseQuestion"
    export default
    BaseQuestion.extend(
      {
        components: {
          ShowAnswer
        },

        methods: {
          showAnswer(){
            if (this.result.is_correct) return ""
            let seperator = this.question.is_fractional ? " / " : " > "
            return this.result.correct_answer.join(seperator)
          },
          oldInput(index)
          {
            return this.result.input[index] ? this.result.input[index] : ""
          }
        }
      }
    )
</script>
<style scoped>

    div.question .fractional {
        max-width: 100px;
    }

    div.question .fractional hr {
        margin-top: 5px;
        margin-bottom: 5px;
        border-top: 2px solid black;
    }

    div.question .fractional input {
        text-align: center;
        font-size: 2em;
        height: 100%;
        padding: 3px;
    }

    div.question .non-fractional {
        padding: 10px 0;
    }

    div.question .non-fractional input {
        width: 78%;
        max-width: 150px;
        display: inline-block;
        padding-left: 5px;
    }

    div.question .non-fractional i.fa.fa-arrow-right {
        font-size: 1em;
    }

    @media (min-width: 992px) and (max-width: 1199px) {
        div.question .non-fractional i.fa.fa-arrow-right {
            font-size: 0.8em;
        }
    }

    div.ans-collection div {
        display: inline-block;
    }

    /*@media (min-width: 768px) and (max-width: 991px) {*/
    /*div.question .non-fractional i.fa.fa-arrow-right {*/
    /*font-size: 0.4em;*/
    /*}*/
    /*}*/
</style>