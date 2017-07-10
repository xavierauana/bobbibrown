<template lang="html">
     <div>
        <question-editor question-identifier="description"
                         :on-change-handler="updateQuestion"></question-editor>
        <button class="btn btn-default"
                @click.prevent="addSubQuestion">Add Question</button>

        <button v-show="is_finished_editing_question" class="btn btn-info" @click.prevent="toggleEditQuestion">Edit Question again</button>

         <br />
        <div class="well" v-show="subQuestions.length > 0">
            <div class="panel-group">
                <div v-for="(question, index) in subQuestions" v-if="question.active" class="panel panel-default">
                    <div class="panel-heading">
                         <h4 class="panel-title">
                            <p>Question {{index+1}}:  <button @click.prevent="removeSubQuestion(question)"
                                                              class="pull-right btn btn-sm btn-danger"><i
                                    class="fa fa-times"></i></button></p>
                        </h4>
                    </div>
                    <div class="panel-collapse">
                      <div class="panel-body">
                          <question-editor
                                  :question-identifier="question.id"
                                  :on-change-handler="updateQuestion"></question-editor>

                        <multiple-choice
                                :show-remove-answer="false"
                                :answer="question.answer"
                                :remove-answer-handler="removeAnswer"
                                :on-change-handler="updateQuestion">
                            </multiple-choice>
                      </div>
                    </div>
                </div>
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
    import QuestionEditor from "./QuestionEditor.vue"
    import MultipleChoice from "./FillInTheBlankAnswer.vue"
    const answerTemplate = {
      content   : "",
      textareaId: "answerInput"
    }
    const subQuestionDataTemplate = {
      id     : 0,
      content: "",
      active : true,
      answer : {},
    }
    export default{
      props     : {
        questionTypes: {
          type: Array
        }
      },
      components: {
        QuestionEditor,
        MultipleChoice
      },
      data(){
        return {
          filteredContent: "",
          closeUrl       : "/",
          content        : "",
          is_active      : true,
          subQuestions   : [],
          currentId      : 1
        }
      },
      methods   : {
        updateQuestion(e){
          console.log(e)
          const editor      = e.editor,
                editor_name = editor.name
          if (editor_name == "content_description") {
            this.content = editor.getData()
          } else {
            const subQuestionId = parseInt(editor_name.substring(editor_name.indexOf('_') + 1, editor_name.length))
            let subQuestion = _.find(this.subQuestions, {'id': subQuestionId})
            if (subQuestion) {
              if (e.editor.name.indexOf('content') > -1) {
                subQuestion.content = editor.getData()
              } else {
                subQuestion.answer.content = editor.getData()
              }
            }
          }
        },
        removeSubQuestion(subQuestion){
          let subQuestions = _.find(this.subQuestions, question => question.id != subQuestion.id)
          subQuestions.active = false
        },
        addSubQuestion(){
          let newSubQuestion = _.assign({}, subQuestionDataTemplate)
          newSubQuestion.answer = _.assign({}, answerTemplate)
          newSubQuestion.answer.textareaId += "_" + this.currentId
          newSubQuestion.id = this.currentId
          this.currentId++
          this.subQuestions.push(newSubQuestion)
        },
        _validateInputs(){
          var messages = [],
              check    = true

          // Description content must not be empty
          if (!this.content) {
            check = false
            messages.push("You have enter something for question descrition!")
          }

          // All choice content must has something
          _.chain(this.subQuestions)
           .filter({'active': true})
           .forEach(this.subQuestions, quesetion => {
             if (!quesetion.content.trim().lenght > 0) {
               check = false
               messages.push("Question " + this.question.id + " must has content")
             }
             if (!quesetion.answer.content.trim().lenght > 0) {
               check = false
               messages.push("Question " + this.question.id + " answer must has content")
             }
           })
          return {
            check   : check,
            messages: messages
          }
        },
        _constructData(){
          return {
            question_type_id: _.find(this.questionTypes, {'code': "Comprehension"}).id,
            content         : this.content,
            is_active       : this.is_active,
            sub_questions   : _.chain(this.subQuestions).filter({'active': true}).map(item => {
              return {
                content: item.content,
                answer : item.answer.content
              }
            }).value()
          }
        },
        _resetAllFields(){
          this.content = ""
          this.is_active = true
          this._removeAllChoiceEditors('content_description')
          this.subQuestions = []
          _.forEach(CKEDITOR.instances, editor => editor.setData(""))
        },
        _rejectedClosure(response){
          if (response.hasOwnProperty("validation") && response["validation"] == false) {
            console.log("validation fails, ", response)
          } else {
            console.log("network error, ", response)
          }
        },
        saveAndNew(){
          if (this.validation(this._validateInputs)) {
            this.$emit("persist-question", this._constructData(), this._saveAndNewClosure, this._rejectedClosure)
          }
        },
        saveAndClose(){
          if (this.validation(this._validateInputs)) {
            this.$emit("persist-question", this._constructData(), this._saveAndCloseClosure, this._rejectedClosure)
          }
        },
        _saveAndNewClosure(){
          this._resetAllFields()
        },
        _saveAndCloseClosure(){
          this.$router.go(-1)
        },
      }
    }
</script>
<style></style>