<template lang="html">
    <div>
        <prefix-editor :on-change-handler="updatePrefix"></prefix-editor>
        <question-editor :on-change-handler="updateQuestion"></question-editor>

        <button @click.prevent="addMoreChoice" class="btn btn-default">Add More Choice</button>

                 <multiple-choice
                         v-for="(choice, index) in choices"
                         :choice="choice"
                         :key="choice.id"
                         :show-index="true"
                         :index="index + 1"
                         :show-correct-dropbox="false"
                         v-on:remove-choice="removeChoice"
                         v-on:update-content="updateChoiceContent">
        </multiple-choice>
        <div class="form-group">
            <label class="col-sm-2 control-label">Correct Sequence</label>
            <div class="col-sm-10">
                <input class="form-control" v-model="theAnswer">
            </div>
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
import QuestionEditor from "./QuestionEditor.vue"
import PrefixEditor from "./PrefixEditor.vue"
import MultipleChoice from "./MultipleChoice.vue"

export default{
  props     : {
    questionTypes: {
      type: Array
    }
  },
  data(){
    return {
      prefix         : "",
      defaultNumber  : 3,
      closeUrl       : "/",
      content        : "",
      page_number    : 1,
      is_active      : true,
      is_required_all: true,
      choices        : [],
      currentId      : 1,
      theAnswer      : "",
      choiceObject   : {
        id        : 0,
        textareaId: "answerInput",
        content   : "",
        active    : true
      }
    }
  },
  components: {
    PrefixEditor,
    MultipleChoice,
    QuestionEditor
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
    updatePrefix(e){
      this.prefix = e.editor.getData()
    },
    updateQuestion(e){
      this.content = e.editor.getData()
    },
    addMoreChoice(){
      let newChoice = _.assign({}, this.choiceObject)
      newChoice.id = this.currentId
      newChoice.textareaId += this.currentId
      this.choices.push(newChoice)
      this.currentId++
    },
    removeChoice(choice){
      this.choices = _.filter(this.choices, object => object.id != choice.id)
    },
    updateChoiceContent(choice, key, content){
      choice[key] = content
    },
    _validateInputs(){
      var messages = [],
          check    = true,
          choices  = this.choices.filter(choice => choice.active == true)

      // All choice content must has something
      if (_.filter(choices, choice => {
          return !choice.content
        }).length > 0) {
        check = false
        messages.push("All choice must has content")
      }

      // Question content must not be empty
//      if (!this.content) {
//        check = false
//        messages.push("You have enter something for question!")
//      }

      if (this.theAnswer < 1) {
        check = false
        messages.push("You have to input the correct sequence.")
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
        choices         : this.choices.filter(item => item.active == true).map(item => {return {content: item.content}}),
        question_type_id: this._choiceQuestionTypeId(),
          page_number       : this.page_number,
        sequence        : this.theAnswer,
        is_active       : this.is_active
      }
    },
    _choiceQuestionTypeId(){
      return _.find(this.questionTypes, {"code": 'ReOrder'}).id
    },
    saveAndClose(){
      this._updateChoicesContent()
      if (this.validation(this._validateInputs)) {
        this.$emit("persist-question", this._constructData(), this._saveAndCloseClosure, this._rejectedClosure)
      }
    },
    _saveAndCloseClosure(){
      this.$router.go(-1)
    },
    saveAndNew(){
      this._updateChoicesContent()
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
      this.content = ""
      this.theAnswer = ""
      this.page_number = 1
      this.is_active = true
      this._removeAllChoiceEditors()
      this.choices = _.filter(this.choices, object => false)

      setTimeout(() => {
        for (var i = 0; i < this.defaultNumber; i++) {
          this.addMoreChoice()
        }
      }, 100)
    },
    _updateChoicesContent(){
      _.forEach(CKEDITOR.instances, instance => {
        let choice = _.find(this.choices, {'textareaId': instance.name})
        if (choice) choice.content = instance.getData()
      })
    }
  }
}
</script>
<style></style>