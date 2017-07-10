<template lang="html">
    <div>
        <prefix-editor :on-change-handler="updatePrefix"></prefix-editor>
        <question-editor :on-change-handler="updateQuestion"></question-editor>

        <button @click.prevent="addMoreChoice" class="btn btn-default">Add More Choice</button>

        <multiple-choice
                v-for="choice in choices"
                v-if="choice.active"
                :choice="choice"
                :key="choice.idF"
                @remove-choice="removeChoice"
                @update-content="updateChoiceContent">
        </multiple-choice>

        <div class="form-group" v-show="false">
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

        <div class="checkbox">
            <label for="is_required_all" class="col-sm-offset-2">
                <input type="checkbox" id="is_required_all" name="is_required_all" value="1" v-model="is_required_all"> If more than 1 corrected answers, require to check all
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

    class MyException {
      constructor(message) {
        this.message = message
        this.name = 'MyException'
      }
    }
    import QuestionEditor from "./QuestionEditor.vue"
    import PrefixEditor from "./PrefixEditor.vue"
    import MultipleChoice from "./MultipleChoice.vue"
    export default{
      props     : {
        testId       : {
          type    : Number,
          required: true
        },
        questionTypes: {
          type: Array
        }
      },
      data(){
        return {
          prefix         : "",
          defaultNumber  : 4,
          closeUrl       : "/",
          content        : "",
          page_number    : 1,
          is_active      : true,
          is_required_all: true,
          choices        : [],
          currentId      : 1,
          choiceObject   : {
            id          : 0,
            active      : true,
            content     : "",
            textareaId  : "answerInput",
            is_corrected: false
          }
        }
      },
      components: {
        PrefixEditor,
        QuestionEditor,
        MultipleChoice
      },
      created(){
        for (var i = 0; i < this.defaultNumber; i++) {
          this.addMoreChoice()
        }
      },
      beforeDestroy(){
        CKEDITOR.instances = {}
      },
      methods   : {
        updateQuestion(e){
          this.content = e.editor.getData()
        },
        updatePrefix(e){
          this.prefix = e.editor.getData()
        },
        addMoreChoice(){
          let newChoice = _.assign({}, this.choiceObject)
          newChoice.id = this.currentId
          newChoice.textareaId += this.currentId
          this.choices.push(newChoice)
          this.currentId++
        },
        removeChoice(choice){
          this.choices = this._removeOneChoice(this.choices, choice)
        },
        updateChoiceContent(choice, key, content){
          choice[key] = content
        },
        _validateInputs(){
          var messages = [],
              check    = true,
              choices  = _.filter(this.choices, choice => choice.active == true)

          // All choice content must has something
          if (_.filter(choices, choice => {
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

          // One and Only one corrected answer
          var correct = _.filter(choices, choice => {
            return choice.is_corrected == true
          })
          if (correct.length < 1) {
            check = false
            messages.push("There must be at least one answer")
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
                content     : item.content,
                is_corrected: item.is_corrected
              }
            }),
            page_number     : this.page_number,
            question_type_id: this._choiceQuestionTypeId(),
            is_active       : this.is_active,
            is_required_all : this.is_required_all,
          }
        },
        _choiceQuestionTypeId(){
          let correct      = _.filter(this.choices, choice => {
                return choice.is_corrected == true
              }),
              searchType   = correct.length > 1 ? "MultipleMultipleChoice" : "SingleMultipleChoice",
              questionType = _.find(this.questionTypes, {"code": searchType})
          console.log(questionType)
          if (questionType) {
            return questionType.id
          }
          throw new MyException("no quesiton type found")
        },
        saveAndClose(){
          if (this.validation(this._validateInputs)) {
            this.$emit("persist-question", this._constructData(), this._saveAndCloseClosure, this._rejectedClosure)
          }
        },
        _saveAndCloseClosure(){
          window.location.href = '/admin/tests/' + this.testId + "/questions"
        },
        saveAndNew(){
          if (this.validation(this._validateInputs)) {
            this.$emit("persist-question", this._constructData(), this._resetAllFields, this._rejectedClosure)
          }
        },
        _rejectedClosure(response){
          console.log("reject closure fired", response)
          if (response.hasOwnProperty("validation") && response["validation"] == false) {
            console.log("validation fails, ", response)
          } else {
            console.log("network error, ", response)
          }
        },
        _resetAllFields(){

          this.content = ""
          this.page_number = 1
          this.is_active = true
          this.is_required_all = true
          this._removeAllChoiceEditors()
          this.choices = _.filter(this.choices, object => false)

          Vue.nextTick(() => {
            for (let i = 0; i < this.defaultNumber; i++) {
              this.addMoreChoice()
            }
          })
        }
      }
    }
</script>
<style></style>