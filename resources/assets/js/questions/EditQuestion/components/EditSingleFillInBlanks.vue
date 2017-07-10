<template lang="html">
    <div class="editSingleMultipleChoice">
        <h3>Edit Single Fill in the blank</h3>

        <prefix-editor
                v-if="hasPrefix"
                :on-change-handler="updatePrefix"></prefix-editor>
        <question-editor
                v-if="hasContent"
                :on-change-handler="updateQuestion"></question-editor>
        <choices
                v-for="answer in computedAnswers"
                :answer="answer"
                :key="answer.id"
                :remove-answer-handler="removeAnswer"
                :on-change-handler="updateContent"
        >
        </choices>
         <div class="form-group" v-if="hasPageNumber">
            <label class="col-sm-2 control-label">Page Number: </label>
            <div class="col-sm-10">
               <input class="form-control" type="number" v-model="question.page_number" min="1">
            </div>
        </div>
        <div class="">
            <label for="is_active" class="col-sm-offset-2">
                <input type="checkbox" id="is_active" name="is_active" value="1" :checked="question.is_active"
                       @change="toggleActive"> Is Question Active
            </label>
        </div>
    </div>
</template>

<script type="text/babel">
    import QuestionEditor from "./../../components/QuestionEditor.vue"
    import PrefixEditor from "./../../components/PrefixEditor.vue"
    import Choices from "./../../components/FillInTheBlankAnswer.vue"


    export default{
      props     : {
        hasPrefix              : {
          type   : Boolean,
          default: true
        },
        hasContent             : {
          type   : Boolean,
          default: true
        },
        hasPageNumber          : {
          type   : Boolean,
          default: true
        },
        question               : {
          type   : Object,
          require: true
        },
        setChoiceEditorsContent: {
          type   : Function,
          require: true
        },
        setEditorContent       : {
          type   : Function,
          require: true
        },
        updateContentHandler   : {
          type   : Function,
          require: true
        },
        updateQuestionHandler  : {
          type   : Function,
          require: true
        },
        toggleHandler          : {
          type   : Function,
          require: true
        },
      },
      computed  : {
        computedAnswers(){
          let data = _.map(this.question.choices, this.transformChoice)
          Vue.nextTick(() => {
            this.setChoiceEditorsContent(data)
          })
          return data
        }
      },
      components: {
        PrefixEditor,
        QuestionEditor,
        Choices
      },
      mounted(){
        Object.keys(CKEDITOR.instances).forEach(key => this.setEditorContent(CKEDITOR.instances[key]))
      },
      methods   : {
        toggleActive(){
          this.toggleHandler('is_active')
        },
        updatePrefix(e){
          this.updateQuestionHandler('prefix', e.editor.getData())
        },
        updateQuestion(e){
          this.updateQuestionHandler('content', e.editor.getData())
        },
        removeAnswer(choice){
          choice.setValue('active', false)
        },
        updateContent(e){
          let answer = _.find(this.computedAnswers, {'textareaId': e.editor.name})
          this.updateContentHandler(answer, 'content', e.editor.getData())
        },
        transformChoice(choice){
          let temp = choice
          temp['type'] = '_db'
          temp['textareaId'] = 'inputAnswer' + choice.id
          return temp
        },
      }
    }
</script>
<style></style>