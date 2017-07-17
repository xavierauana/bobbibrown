<template lang="html">
    <div>
        <div class="row" v-if="question.prefix && question.prefix.length > 0">
            <div class="col-sm-12 clearfix" v-html="question.prefix"></div>
         </div>
        <div>
             <div class="ans-collection">
                <show-answer :index="getIndex(index)"
                             :is_correct="r.is_correct"
                             :key="index"
                             :correct_answer="showAnswer(r)"
                             v-for="(r, index) in result"></show-answer>
            </div>
            <h4 class="question-number">Q: {{index}}</h4>
        </div>
        <div class="row">
            <div class="col-md-9 clearfix" v-html="question.content"></div>
            <div class="col-md-3 pull-right">
                <ul class="list-unstyled pull-right">
                    <li v-for="(sub_question, index) in question.sub_questions" class="inline-fill-in-li">
                            {{computedIndex(index)}}. <input class="form-control" data-id="sub_question.id"
                                                             :value="getInput(sub_question)"
                                                             :disabled="disabled">
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
     import ShowAnswer from "./show_answer.vue"
     import BaseQuestion from "./../../models/BaseQuestion"
     export default BaseQuestion.extend(
       {
         components: {
           ShowAnswer
         },
         methods   : {
           getIndex(r){
             const indexRange = this.index.split(" - ").map(r => parseInt(r)),
                   indexArray = []
             for (let i = indexRange[0]; i <= indexRange[indexRange.length - 1]; i++) {
               indexArray.push(i)
             }
             return "Q:" + indexArray[r]
           },
           showAnswer(result){
             return result.is_correct ? "" : String(result.correct_answer[0])
           },
           getInput(sub_question){
             const theInput = this.result.find(result => result.id === sub_question.id).input
             return theInput.length > 0 ? theInput[0] : ""
           },
           computedIndex(index){
             return parseInt(this.index.split(' ')[0]) + index
           }
         }
       }
     )
</script>
<style scoped>
    li.inline-fill-in-li > input {
        max-width: 150px;
    }

    div.ans-collection div {
        display: inline-block;
    }
</style>