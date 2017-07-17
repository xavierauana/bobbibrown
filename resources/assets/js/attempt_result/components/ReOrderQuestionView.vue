<template lang="html">
    <div class="reorder">
        <div class="row" v-if="question.prefix && question.prefix.length > 0">
            <div class="col-sm-12 clearfix" v-html="question.prefix"></div>
         </div>
        <div>
            <show-answer :is_correct="result.is_correct" :correct_answer="showAnswer"></show-answer>
            <h4 class="question-number">Q: {{index}}</h4>
        </div>
        <div v-html="question.content" class="clearfix"></div>
        <div class="no-margin well">
            <h5>Choices:</h5>
            <ul :id="'reorder_choices_'+question.id" class="list-inline choices">
                <li v-for="choice in randomizedChoices" :data-id="choice.id" v-html="choice.content"></li>
            </ul>
        </div>
        <div class="no-margin well">
            <h5>Answer Section:</h5>
            <ul :id="'reorder_answers_'+question.id" class="list-inline answers">
                <li v-for="input in result.input" v-html="getInputContent(input)">  </li>
            </ul>
        </div>

    </div>
</template>

<script type="text/babel">
    import {disableScroll, enableScroll} from "./helpers/DisableScrolling"
    import ShowAnswer from "./show_answer.vue"
    import BaseQuestion from "./../../models/BaseQuestion"

    export default BaseQuestion.extend(
      {
        components: {
          ShowAnswer
        },
        mounted(){
          const choicesId = 'reorder_choices_' + this.question.id,
                answersId = 'reorder_answers_' + this.question.id

          if (!this.disabled) {
            if (document.getElementById(choicesId) && document.getElementById(answersId)) {
              $("#" + choicesId).sortable({
                                            placeholder: "ui-state-highlight",
                                            connectWith: "ul#" + answersId
                                          }).disableSelection();
              $("#" + answersId).sortable({
                                            placeholder: "ui-state-highlight",
                                            connectWith: "ul#" + choicesId,
                                          }).disableSelection();
            }
          }

        },
        computed  : {
          randomizedChoices(){
            return _.shuffle(this.question.choices)
          },
          showAnswer(){
            return _.reduce(this.result.correct_answer,
                            (previous, id) => previous += this.getInputContent(id),
                            "")
          }
        },
        methods   : {
          getInputContent(id){
            return _.find(this.question.choices, {id: id}).content
          }
        }
      }
    )
</script>
<style>
    .reorder ul li {
        margin: 5px;
    }

    .reorder ul.choices li,
    .reorder ul.answers li {
        background: #33cdfa;
    }

    .reorder ul.answers {
        width: auto;
        min-height: 40px;
        background-color: lightgoldenrodyellow;
    }

    .reorder ul.choices {
        width: auto;
        min-height: 40px;
        background-color: #c1face;
    }

    .well.no-margin h5 {
        margin: 3px;
    }

    .well.no-margin {
        margin: 0;
        padding: 0;
    }

    .reorder .well.no-margin ul.list-inline {
        margin: 10px
    }

    .well.no-margin li {
        font-size: 1.5em
    }

</style>