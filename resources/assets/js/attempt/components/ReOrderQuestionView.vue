<template lang="html">
    <div class="reorder">
        <div class="row" v-if="question.prefix && question.prefix.length > 0">
            <div class="col-sm-12 clearfix" v-html="question.prefix"></div>
         </div>
        <div>
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
                <li v-for="choice in previousAttempt" :data-id="choice.id" v-html="choice.content"></li>
            </ul>
        </div>

    </div>
</template>

<script type="text/babel">
    import {disableScroll, enableScroll} from "./helpers/DisableScrolling"
    export default{
      props   : {
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
      mounted(){
        const that      = this,
              choicesId = 'reorder_choices_' + this.question.id,
              answersId = 'reorder_answers_' + this.question.id

        if (document.getElementById(choicesId) && document.getElementById(answersId)) {
          $("#" + choicesId).sortable({
                                        placeholder: "ui-state-highlight",
                                        connectWith: "ul#" + answersId
                                      }).disableSelection();
          $("#" + answersId).sortable({
                                        placeholder: "ui-state-highlight",
                                        connectWith: "ul#" + choicesId,
                                        update     : function (evt, ui) {
                                          that.updateSequence()
                                        }
                                      }).disableSelection();
        }
      },
      computed: {
        randomizedChoices(){
          if (this.previous) {
            const ids = this.previous.answer.map(attempt => attempt)

            return _.chain(this.question.choices)
                    .filter(choice => ids.indexOf(choice.id) == -1)
                    .shuffle()
                    .value()
          }

          return _.shuffle(this.question.choices)

        },
        previousAttempt(){
          let previous = []
          if (this.previous) {
            for (let i = 0; i < this.previous.answer.length; i++) {
              for (let j = 0; j < this.question.choices.length; j++) {
                if (this.question.choices[j].id === this.previous.answer[i]) previous.push(this.question.choices[j])
              }
            }


            Vue.nextTick(() => {
              this.updateSequence()
            })
          }


          return previous
        }
      },
      methods : {
        updateSequence(){
          let sequence = []
          const list_items = document.getElementById('reorder_answers_' + this.question.id).getElementsByTagName('li')
          for (var i = 0; i < list_items.length; i++) {
            sequence.push(parseInt(list_items[i].dataset.id))
          }
          this.onAnswerChange(this.question.id, sequence)
        }
      }
    }
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