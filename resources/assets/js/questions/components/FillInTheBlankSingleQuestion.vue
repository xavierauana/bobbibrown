<template lang="html">
    <div>
        <prefix-editor :on-change-handler="updatePrefix"></prefix-editor>

        <question-editor :on-change-handler="updateQuestion"></question-editor>

        <button @click.prevent="addMoreAnswer" class="btn btn-default">Add More Answer</button>

        <multiple-choice
                v-for="answer in answers"
                :answer="answer"
                :key="answer.id"
                :remove-answer-handler="removeAnswer"
                :on-change-handler="updateAnswer">
        </multiple-choice>

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

        <button type="submit" class="btn btn-info" @click.prevent="_saveAndCloseClosure">Back</button>
        <button type="submit" class="btn btn-success" @click.prevent="saveAndClose">Save and Close</button>
        <button type="submit" class="btn btn-success" @click.prevent="saveAndNew">Save and New</button>
    </div>
</template>

<script type="text/babel">
    import PrefixEditor from "./PrefixEditor.vue"
    import QuestionEditor from "./QuestionEditor.vue"
    import MultipleChoice from "./FillInTheBlankAnswer.vue"
    const answer = {
      id          : 0,
      textareaId  : "answer",
      content     : "",
      active      : true,
      is_corrected: false,
    }
    export default{
      props     : {
        questionTypes: {
          type: Array
        }
      },
      data(){
        return {
          prefix     : "",
          currentId  : 1,
          content    : "",
          is_active  : true,
          page_number: 1,
          answers    : []
        }
      },
      components: {
        PrefixEditor,
        QuestionEditor,
        MultipleChoice
      },
      created(){
        this.addMoreAnswer()
      },
      methods   : {
        updateQuestion(e){
          this.content = e.editor.getData()
        },
        updatePrefix(e){
          this.prefix = e.editor.getData()
        },
        updateAnswer(e){
          const editor = e.editor
          let answer = _.find(this.answers, {'textareaId': editor.name})
          if (answer) answer.content = editor.getData()
        },
        addMoreAnswer(){
          var newAnswer = _.assign({}, answer)
          newAnswer.id = this.currentId
          newAnswer.textareaId = newAnswer.textareaId + this.currentId
          this.answers.push(newAnswer)
          this.currentId++
        },
        removeAnswer(answer){
          this.answers = this._removeOneChoice(this.answers, answer)
        },
        _constructData(){
          // Dynamically set multiple question type id base on correct answer
          var choices = this.answers.filter(item => item.active == true).map(item => {return {content: item.content}});
          return {
            prefix          : this.prefix.trim(),
            content         : this.content,
            choices         : choices,
            page_number     : this.page_number,
            question_type_id: this._choiceQuestionTypeId(),
            is_active       : this.is_active,
          }
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
            this.$emit("persist-question", this._constructData(), this._saveAndNewClosure, this._rejectedClosure)
          }
        },
        _saveAndNewClosure(){
          this._resetAllFields()
        },
        _resetAllFields(){
          this.content = ""
          this.page_number = 1
          this.is_active = true
          this.answers = _.filter(this.answers, answer => false)
          _.forEach(CKEDITOR.instances, editor => editor.setData(""))
          setTimeout(() => {
            this.addMoreAnswer()
          }, 100)

        },
        _rejectedClosure(response){
          if (response.hasOwnProperty("validation") && response["validation"] == false) {
            console.log("validation fails, ", response)
          } else {
            console.log("network error, ", response)
          }
        },
        _validateInputs(){
          var messages = [],
              check    = true

          // All choice content must has something
          if (_.filter(this.answers, answer => {
              return answer.content.trim().length > 0
            }).length == 0) {
            check = false
            messages.push("All answer must has content")
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
        _choiceQuestionTypeId(){
          return _.find(this.questionTypes, {"code": "SingleFillInBlanks"}).id
        },
      }
    }
</script>
<style></style>