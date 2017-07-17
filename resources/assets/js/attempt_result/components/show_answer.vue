<template lang="html">
    <div>
        <p class="corrected_ans" :class="{'text-danger':!is_correct,'text-success':is_correct}"
           v-html="answer"></p>
    </div>
</template>

<script type="text/babel">
    export default{
      props   : {
        index         : {
          type   : String,
          default: ""
        },
        correct_answer: {
          type   : String,
          default: ""
        },
        is_correct    : {
          type    : Boolean,
          required: true
        }
      },
      computed: {
        answer(){
          return this.is_correct ?
                 this.index + ' <i class="fa fa-check" aria-hidden="true"></i> ' :
                 this.index + ' <i class="fa fa-times" aria-hidden="true"></i> ' + this.correct_answer
        }
      }
    }
</script>