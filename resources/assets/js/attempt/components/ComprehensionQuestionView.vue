<template lang="html">
     <div class="group">
        <div>
            <h4 class="question-number">Q: {{index}}</h4>
        </div>
        <div v-html="question.content" class="clearfix"></div>
         <div v-for="subQuestion in question.sub_questions">
             <div class="row">
                <div class="col-sm-6 clearfix" v-html="subQuestion[0].content"></div>
                <div class="col-sm-6">
                    <input class="form-control" type="text" :data-id="subQuestion[0].id" @change.prevent="updateAnswer">
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
        previous      : {
          type: Object
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
    /*div.group{*/
        /*border: 2px solid #5ec8dc;*/
        /*border-radius: 5px;*/
    /*}*/
</style>