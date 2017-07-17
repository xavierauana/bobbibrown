<template lang="html">
    <div>
        <div class="row" v-if="question.prefix && question.prefix.length > 0">
            <div class="col-sm-12 clearfix" v-html="question.prefix"></div>
         </div>
        <div>
            <h4 class="question-number">Q: {{index}}</h4>
        </div>
        <div class="row">
            <div class="col-md-9 clearfix" v-html="question.content"></div>
            <div class="col-md-3 pull-right">
                <ul class="list-unstyled  pull-right">
                    <li v-for="(sub_question, index) in question.sub_questions" class="inline-fill-in-li">
                            {{computedIndex(index)}}. <input class="form-control" :data-id="sub_question.id"
                                                             @change="updateAnswer">
                    </li>
                </ul>
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
          type: Array
        }
      },
      mounted(){
        console.log('from inline fill in the blanks, ', this.previous)
        _.forEach(this.previous, attempt => {
          const id = attempt.id
          let el = document.querySelector("input[data-id='" + id + "']")
          if (el) {
            el.value = attempt.answer[0]
            el.dispatchEvent(new Event("change"))
          }
        })
      },
      methods: {
        updateAnswer(e){
          this.onAnswerChange(parseInt(e.target.dataset.id), e.target.value)
        },
        computedIndex(index){
          return parseInt(this.index.split(' ')[0]) + index
        }
      }
    }
</script>
<style>
    li.inline-fill-in-li > input {
        max-width: 150px;
    }
</style>