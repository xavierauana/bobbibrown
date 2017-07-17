<template lang="html">
    <div>

        <div class="row" v-if="question.prefix && question.prefix && question.prefix.length > 0">
            <div class="col-sm-12 clearfix" v-html="question.prefix"></div>
         </div>
        <div>
            <h4 class="question-number">Q: {{index}}</h4>
        </div>
        <div class="row">
            <div class="col-md-6 clearfix" v-html="question.content"></div>
            <div class="col-md-6 pull-right" :data-id="question.id">
                <div class="pull-right" v-if="!question.is_fractional">
                    <div class="col-xs-4 non-fractional" v-for="n in question.number_of_fields">
                        <input class="form-control" type="text" @change.prevent="updateAnswer"
                               v-model="answers[n-1]">
                        <span v-if="n < question.number_of_fields"><i class="fa fa-arrow-right" aria-hidden="true"></i></span>
                    </div>
                </div>
                <div v-if="question.is_fractional" class="fractional pull-right col-xs-12" :data-id="question.id">
                        <input class="form-control" type="text" @change.prevent="updateAnswer"
                               v-model="answers[0]">
                        <hr />
                        <input class="form-control" type="text" @change.prevent="updateAnswer"
                               v-model="answers[1]">

                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default{
      props  : {
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
        },
      },
      data(){
        return {
          answers: []
        }
      },
      mounted(){
        if (this.previous) {
          this.answers = this.previous.answer
          this.updateAnswer()
        }
      },
      methods: {
        updateAnswer(){
          this.onAnswerChange(this.question.id, this.answers)
        }
      }
    }
</script>
<style>

    div.question .fractional {
        max-width: 100px;
    }
    div.question .fractional hr{
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
</style>