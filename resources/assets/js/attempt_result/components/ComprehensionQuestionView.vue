<template lang="html">
     <div class="group">
        <div>
            <h4 class="question-number">Q: {{index}}</h4>
        </div>
        <div v-html="question.content" class="clearfix"></div>
         <div v-for="subQuestion in question.sub_questions">
             <div class="row">
                <div class="col-sm-8 clearfix" v-html="subQuestion[0].content"></div>
                <div class="col-sm-4">
                    <input class="form-control" type="text" :data-id="subQuestion[0].id" @change.prevent="updateAnswer" :disabled="disabled">
                </div>
        </div>
         </div>
    </div>
</template>

<script type="text/babel">
    export default{
      props  : {
        index:{
          type: String,
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
        disabled      : {
          type    : Boolean,
          required: false
        }
      },
      methods: {
        updateAnswer(e){
          this.onAnswerChange(parseInt(e.target.dataset.id), parseInt(e.target.value))
        },
      }
    }
</script>
<style>
</style>