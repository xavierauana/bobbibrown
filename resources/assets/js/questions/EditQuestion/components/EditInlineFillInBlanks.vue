<template lang="html">
    <div class="editInlineFillInBlanks">
        <h3>Edit Inline Fill in the banks</h3>

        <prefix-editor :on-change-handler="updatePrefix"></prefix-editor>
        <question-editor :on-change-handler="updateQuestion"></question-editor>
        <button class="btn btn-default" @click="addChoice">Add Choice</button>


        <div v-for="subQuestion in question.sub_questions">
            <answer
                    :answer="subQuestion.choices[0]"
                    :on-change-handler="updateContent"
                    :remove-answer-handler="removeAnswer"
                    v-show="subQuestion.choices[0].active"
            ></answer>

        </div>
        </choices>
        <div class="form-group">
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
    import Question from "./../../../models/Question"
    import QuestionEditor from "./../../components/QuestionEditor.vue"
    import PrefixEditor from "./../../components/PrefixEditor.vue"
    import EditSingleFillInBlank from "./EditSingleFillInBlanks.vue"
    import Answer from "./../../components/FillInTheBlankAnswer.vue"


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
        EditSingleFillInBlank,
        Answer
      },
      mounted(){
        Object.keys(CKEDITOR.instances)
              .forEach(key => this.setEditorContent(CKEDITOR.instances[key]))
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
        updateContent(e, answer){
          this.updateContentHandler(answer, 'content', e.editor.getData())
        },
        removeAnswer(answer){
          answer.setValue('active', false)
          if (CKEDITOR.instances.hasOwnProperty(answer.textareaId)) CKEDITOR.instances[answer.textareaId].destroy(true)
        },
        addChoice(){
          // this will add a sub_question with only 1 choice
          let newQuestion = new Question()
          newQuestion.addChoice()
          this.question.sub_questions.push(newQuestion)
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