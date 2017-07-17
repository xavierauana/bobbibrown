<template lang="html">
    <div>
        <div class="row" v-if="question.prefix && question.prefix.length > 0">
            <div class="col-sm-12 clearfix" v-html="question.prefix"></div>
         </div>
        <div>
            <h4 class="question-number">Q: {{index}}</h4>
        </div>
        <div v-html="computedContent" class="clearfix"></div>
    </div>
</template>

<script type="text/babel">
    import * as InlineFunction from "./../../questions/helper/InlineMultipleChoiceHelpers"
    export default{
      props  : {
        index         : {
          type   : String,
          default: "1"
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
      data(){
        return {
          titles         : [],
          computedContent: ""
        }
      },
      mounted(){
        let temObj = _.assign({}, this.question)
        const data = InlineFunction.filterContentWithSpan(temObj.content)
        this.titles = data.titles
        this.updateComputedContent(data)
        this.addEventListenerToSelectEls()
      },
      methods: {
        updateComputedContent(data){
          let content = this.question.content;
          for (var i = 0; i < this.titles.length; i++) {
            const htmlString = this.createSelection(this.titles[i])
            if (htmlString) {
              content = content.replace(data.symbols[i], htmlString)
            }
          }
          this.computedContent = content
        },
        addEventListenerToSelectEls(){
          Vue.nextTick(() => {
            let els = document.querySelectorAll('select.inline_select_' + this.question.id)
            for (var i = 0; i < els.length; i++) {
              els[i].addEventListener('change', this.updateAnswer)
            }
            this.updatePreviousAttempt(els)
          })
        },
        updatePreviousAttempt(els){
          for (var i = 0; i < els.length; i++) {
            const el_id = parseInt(els[i].dataset.id)
            this.previous.forEach(record => {
              if (record.id === el_id) {
                els[i].value = record.answer[0]
                els[i].dispatchEvent(new Event('change'))
              }
            })
          }
        },
        updateAnswer(e){
          this.onAnswerChange(parseInt(e.target.dataset.id), parseInt(e.target.value))
        },
        //        TODO:: implement change
        createSelection(title){
          const SubQuestion = _.find(this.question.sub_questions, subQuestion => subQuestion.content == title)
          if (SubQuestion) {
            const htmlString = this.createOption(SubQuestion)
            return '<select data-id="' + SubQuestion.id + '" class="inline_select_' + this.question.id + '" >' + htmlString + '</select>'
          }
        },
        createOption(SubQuestion){

          let htmlString = '<option selected>' + SubQuestion.content + '</option>'
          const choices = SubQuestion.choices
          for (var i = 0; i < choices.length; i++) {
            htmlString += '<option value="' + choices[i].id + '">' + choices[i].content + '</option>'
          }
          return htmlString
        }
      }
    }
</script>
<style></style>