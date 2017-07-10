<template lang="html">
    <div class="editSingleMultipleChoice">
        <h3>Edit Multiple Fill in the blank</h3>

        <prefix-editor :on-change-handler="updatePrefix"></prefix-editor>
        <question-editor :on-change-handler="updateQuestion"></question-editor>
        <button class="btn btn-default" @click.prevent="addChoice">Add Choice</button>

        <choices
                v-for="answer in question.choices"
                v-show="answer.active"
                :answer="answer"
                :key="answer.id"
                :remove-answer-handler="removeChoice"
                @update-content="updateContentHandler"
                :on-change-handler="updateChoices"
        >
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
        <div class="">
            <label for="is_fractional" class="col-sm-offset-2">
                <input type="checkbox" id="is_fractional" name="is_fractional" value="1"
                       :checked="question.is_fractional" @change="toggleFractional"> Is Fractional
            </label>
        </div>

        <div class="">
            <label for="is_ordered" class="col-sm-offset-2">
                <input type="checkbox" id="is_ordered" name="is_ordered" value="1" :checked="question.is_ordered"
                       @change="toggleOrdered"> Is Ordered
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
        addChoiceHandler       : {
          type   : Function,
          require: true
        },
        removeChoiceHandler    : {
          type   : Function,
          require: true
        },
        toggleHandler          : {
          type   : Function,
          require: true
        },
      },
      components: {
        PrefixEditor,
        QuestionEditor,
        Choices
      },
      mounted(){
        Object.keys(CKEDITOR.instances)
              .forEach(key => this.setEditorContent(CKEDITOR.instances[key]))
      },
      methods   : {
        addChoice(){
          if (_.isFunction(this.addChoiceHandler)) {
            this.addChoiceHandler(this.question)
          }
        },
        toggleActive(){
          this.toggleHandler('is_active')
        },
        toggleFractional(){
          this.toggleHandler('is_fractional')
        },
        toggleOrdered(){
          this.toggleHandler('is_ordered')
        },
        updatePrefix(e){
          this.updateQuestionHandler('prefix', e.editor.getData())
        },
        updateQuestion(e){
          this.updateQuestionHandler('content', e.editor.getData())
        },
        removeChoice(choice){
          if (_.isFunction(this.removeChoiceHandler))
            this.removeChoiceHandler(choice)
        },
        updateChoices(e, choice){
          choice.setValue('content', e.editor.getData())
        }
      }
    }
</script>
<style></style>