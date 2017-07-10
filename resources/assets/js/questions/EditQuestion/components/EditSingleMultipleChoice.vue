<template lang="html">
    <div class="editSingleMultipleChoice">
        <h3>Edit Single Multiple Choice</h3>

        <prefix-editor :on-change-handler="updatePrefix"></prefix-editor>
        <question-editor :on-change-handler="updateQuestion"></question-editor>
        <button class="btn btn-default" @click="addChoice">Add Choice</button>

        <choices
                v-for="choice in question.choices"
                :choice="choice"
                :key="choice.id"
                v-show="choice.active"
                @remove-choice="removeChoice"
                @update-content="updateContentHandler">
        </choices>

        <div class="form-group" v-show="false">
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
    import Choices from "./../../components/MultipleChoice.vue"


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
        for (var name in  CKEDITOR.instances) {
          this.setEditorContent(CKEDITOR.instances[name])
        }
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
        addChoice(){
          if (_.isFunction(this.addChoiceHandler)) {
            this.addChoiceHandler(this.question)
          }
        },
        removeChoice(choice){
          if (_.isFunction(this.removeChoiceHandler)) {
            this.removeChoiceHandler(choice)
          }
        }
      }
    }
</script>
<style></style>