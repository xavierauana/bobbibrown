<template lang="html">
    <div>
        <prefix-editor :on-change-handler="updatePrefix"></prefix-editor>
        <question-editor v-show="!is_finished_editing_question" :on-change-handler="updateQuestion"></question-editor>
        <button v-show="!is_finished_editing_question" class="btn btn-info"
                @click.prevent="toggleEditQuestion">Complete</button>

        <div v-show="is_finished_editing_question" class="panel panel-default">
            <div class="panel-heading">Sample Question</div>
            <div class="panel-body" v-html="content"></div>
        </div>
        <button v-show="is_finished_editing_question" class="btn btn-info" @click.prevent="toggleEditQuestion">Edit Question again</button>

        <div v-show="is_finished_editing_question">
            <button class="btn btn-default" @click.prevent="addMoreChoice">Add More Question</button>
            <multiple-choice
                    v-for="(answer, index) in choices"
                    v-if="answer.active"
                    :answer="answer"
                    :key="answer.id"
                    :index="index+1"
                    :remove-answer-handler="removeChoice"
                    :on-change-handler="updateChoiceContent">
            </multiple-choice>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Page Number: </label>
            <div class="col-sm-10">
               <input class="form-control" type="number" v-model="page_number" min="1">
            </div>
        </div>

        <div class="checkbox">
            <label for="is_active" class="col-sm-offset-2">
                <input type="checkbox" id="is_active" name="is_active" value="1" v-model="is_active"> Is Question Active
            </label>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-info" @click.prevent="_saveAndCloseClosure">Back</button>
            <button type="submit" class="btn btn-success" @click.prevent="saveAndClose">Save and Close</button>
            <button type="submit" class="btn btn-success" @click.prevent="saveAndNew">Save and New</button>
        </div>
    </div>
</template>

<script type="text/babel">
    import PrefixEditor from "./PrefixEditor.vue"
    import QuestionEditor from "./QuestionEditor.vue"
    import MultipleChoice from "./FillInTheBlankAnswer.vue"
    export default{
      props     : {
        questionTypes: {
          type: Array
        }
      },
      data(){
        return {
          prefix                      : "",
          closeUrl                    : "/",
          content                     : "",
          page_number                 : 1,
          is_active                   : true,
          is_finished_editing_question: false,
          choices                     : [],
          selection_titles            : [],
          currentId                   : 1,
          choiceObject                : {
            id        : 0,
            textareaId: "answer",
            content   : "",
            active    : true
          }
        }
      },
      components: {
        PrefixEditor,
        MultipleChoice,
        QuestionEditor,
      },
      beforeDestroy(){
        CKEDITOR.instances = {}
      },
      methods   : {
        updatePrefix(e){
          this.prefix = e.editor.getData()
        },
        toggleEditQuestion(){
          this.is_finished_editing_question = !this.is_finished_editing_question
        },
        updateQuestion(e){
          this.content = e.editor.getData()
        },
        addMoreChoice(){
          let newChoice = _.assign({}, this.choiceObject)
          newChoice.id = this.currentId
          newChoice.textareaId = newChoice.textareaId + this.currentId
          this.choices.push(newChoice)
          this.currentId++
        },
        removeChoice(choice){
          console.log(choice)
          this.choices = this._removeOneChoice(this.choices, choice)
        },
        updateChoiceContent(editorEvent){
          console.log(editorEvent)
          let choice = _.find(this.choices, {'textareaId': editorEvent.editor.name})
          if (choice) {
            choice.content = editorEvent.editor.getData()
          }
        },
        _validateInputs(){
          var messages = [],
              check    = true,
              choices  = this.choices.filter(choice => choice.active == true)

          // All choice content must has something
          if (_.filter(this.choices, choice => {
              return !choice.content
            }).length > 0) {
            check = false
            messages.push("All choice must has content")
          }

          // Question content must not be empty
          if (!this.content) {
            check = false
            messages.push("You have enter something for question!")
          }

          return {
            check   : check,
            messages: messages
          }
        },
        _constructData(){
          // Dynamically set multiple question type id base on correct answer
          return {
            prefix          : this.prefix.trim(),
            content         : this.content,
            choices         : this.choices.filter(item => item.active == true).map(item => {
              return {
                content: item.content
              }
            }),
            question_type_id: this._choiceQuestionTypeId(),
            page_number     : this.page_number,
            is_active       : this.is_active,
          }
        },
        _choiceQuestionTypeId(){
          return _.find(this.questionTypes, {"code": "InlineFillInBlanks"}).id
        },
        saveAndClose(){
          if (this.validation(this._validateInputs)) {
            this.$emit("persist-question", this._constructData(), this._saveAndCloseClosure, this._rejectedClosure)
          }
        },
        _saveAndCloseClosure(){
          this.$router.go(-1)
        },
        saveAndNew(){
          if (this.validation(this._validateInputs)) {
            this.$emit("persist-question", this._constructData(), this._resetAllFields, this._rejectedClosure)
          }
        },
        _rejectedClosure(response){
          if (response.hasOwnProperty("validation") && response["validation"] == false) {
            console.log("validation fails, ", response)
          } else {
            console.log("network error, ", response)
          }
        },
        _resetAllFields(){
          this.prefix = ""
          this.content = ""
          this.page_number = 1
          this.is_active = true
          this.is_finished_editing_question = false
          this._removeAllChoiceEditors()
          this.choices = _.filter(this.choices, object => false)
        }
      }
    }
</script>
<style></style>