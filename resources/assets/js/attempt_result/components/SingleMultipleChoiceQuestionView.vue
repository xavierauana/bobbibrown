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
            <div class="col-md-6 clearfix" v-html="question.content"></div>
            <div class="col-md-6 multiple-choices pull-right">
                <ul class="list-unstyled  pull-right">
                    <li v-for="choice in randomChoices">
                        <label>
                            <input class="" type="radio" :value="choice.id" :checked="isSelected(choice.id)"
                                   :disabled="disabled">
                            <span v-html="choice.content"></span>
                        </label>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import ShowAnswer from "./show_answer.vue"
    import BaseQuestion from "./../../models/BaseQuestion"
    export default
    BaseQuestion.extend({
                          components: {
                            ShowAnswer
                          },
                          computed  : {
                            randomChoices(){
                              return _.shuffle(this.question.choices)
                            },
                            showAnswer(){
                              return _.find(this.question.choices, {id: this.result.correct_answer[0]}).content
                            }
                          },
                          methods   : {
                            isSelected(choiceId){
                              return this.result.input.indexOf(choiceId) > -1
                            }
                          }
                        })
</script>
<style>
    img {
        height: auto;
        max-width: 100%
    }

    div.multiple-choices ul {
        border: 2px solid #ffa61b;
        border-radius: 5px;
    }
</style>
