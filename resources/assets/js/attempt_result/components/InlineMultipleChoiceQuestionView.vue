<template lang="html">
    <div>
        <div class="row" v-if="question.prefix && question.prefix.length > 0">
            <div class="col-sm-12 clearfix" v-html="question.prefix"></div>
         </div>
        <div>
            <div class="ans-collection">
                <show-answer v-for="(r, index) in result"
                             :key="index"
                             :index="getIndex(index)"
                             :is_correct="r.is_correct"
                             :correct_answer="showAnswer(r)"
                ></show-answer>
            </div>
            <h4 class="question-number">Q: {{index}}</h4>
        </div>
        <div v-html="computedContent" class="clearfix"></div>
    </div>
</template>

<script type="text/babel">
    import * as InlineFunction from "./../../questions/helper/InlineMultipleChoiceHelpers"
    import ShowAnswer from "./show_answer.vue"
    import BaseQuestion from "./../../models/BaseQuestion"

    export default BaseQuestion.extend(
      {
        components: {
          ShowAnswer
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
        },
        methods   : {
          showAnswer(result){
            if (result.is_correct) return ""
            const q = _.find(this.question.sub_questions, {'id': result.id})
            const c = _.find(q.choices, {'id': result.correct_answer[0]})

            return c ? c.content : ""
          },
          getIndex(r){
            const indexRange = this.index.split(" - ").map(r => parseInt(r)),
                  indexArray = []
            for (let i = indexRange[0]; i <= indexRange[indexRange.length - 1]; i++) {
              indexArray.push(i)
            }

            return "Q:" + indexArray[r]
          },
          updateComputedContent(data){
            let content = this.question.content;
            for (var i = 0; i < this.titles.length; i++) {
              const SubQuestion   = _.find(this.question.sub_questions, subQuestion => subQuestion.content === this.titles[i]),
                    selectElement = this.createSelection(SubQuestion, _.find(this.result, {id: SubQuestion.id}).input[0])
              if (selectElement) {
                content = content.replace(data.symbols[i], selectElement.outerHTML)
              }
            }
            this.computedContent = content
          },
          createSelection(SubQuestion, input = null){
            if (SubQuestion) {
              let select = document.createElement('select')
              select.dataset.id = SubQuestion.id
              select.className = "inline_select_" + this.question.id
              select.disabled = true

              const defaultOption = document.createElement('option')
              defaultOption.text = SubQuestion.content
              if (input === null) defaultOption.setAttribute('selected', true)
              select.appendChild(defaultOption)
              for (var i = 0; i < SubQuestion.choices.length; i++) {
                select.add(this.createOption(SubQuestion.choices[i], input))
              }

              return select
            }
          },
          decodeHtml(html) {
            var txt = document.createElement("textarea");
            txt.innerHTML = html;
            return txt.value;
          },
          createOption(choice, input = null){
            const option = document.createElement('option')
            option.text = this.decodeHtml(choice.content)
            option.value = choice.id
            if (input === parseInt(choice.id)) option.setAttribute('selected', true)
            return option
          }
        }
      }
    )
</script>
<style scoped>
    h4.question-number {
        color: blue
    }

    div.ans-collection div {
        display: inline-block;
        margin-right: 15px;
    }

    div.ans-collection div p {
        display: inline;
    }
</style>