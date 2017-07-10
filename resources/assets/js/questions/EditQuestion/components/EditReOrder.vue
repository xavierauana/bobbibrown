<template lang="html">
    <div class="editSingleMultipleChoice">
        <h3>Edit Reorder</h3>

        <prefix-editor :on-change-handler="updatePrefix"></prefix-editor>
        <question-editor :on-change-handler="updateQuestion"></question-editor>
        <button class="btn btn-default" @click="addChoice">Add Choice</button>

        <choices
                v-for="choice in question.choices"
                :choice="choice"
                :key="choice.id"
                v-show="choice.active"
                :show-correct-dropbox="false"
                @update-content="updateContentHandler"
                @remove-choice="removeAnswer"
        >
        </choices>

        <div class="form-group">
            <label class="col-sm-2 control-label">Correct Sequence</label>
            <div class="col-sm-10">
                <input class="form-control " aria-label="..." name="answer" :value="question.answer.join(',')"
                       @change.prevent="updateCorrectSequence($event)" />
            </div>
        </div>

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
    import swal from "sweetalert2"
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
        removeChoiceHandler    : {
          type   : Function,
          require: true
        },
        addChoiceHandler       : {
          type   : Function,
          require: true
        },
        toggleHandler          : {
          type   : Function,
          require: true
        },
      },
      computed  : {
        correctedSequence(){
          return this.question.answer.join(",")
        },
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
        for (var name in  CKEDITOR.instances) {
          this.setEditorContent(CKEDITOR.instances[name])
        }
        if (_.isArray(this.question.answer)) {
//          this.correctedSequence = this.answerArrayToString()
          const answerString = this.answerArrayToString()
          const answerArray = this.stringToAnswerArray(answerString)
          if(answerArray){
            this.updateQuestionHandler('answer', answerArray)
          }
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
        transformChoice(choice){
          let temp = choice
          temp['type'] = '_db'
          temp['textareaId'] = 'inputAnswer' + choice.id
          return temp
        },
        answerArrayToString(){
          let sequence = [];
          _.forEach(this.question.choices, choice => {
            let index = this.question.answer.indexOf(choice.id)
            if (index > -1) sequence.push(index + 1)
          })
          return sequence.join(",")
        },
        stringToAnswerArray(stringValue){
          let sequenceArray = stringValue.split(',').map(segment => parseInt(segment.trim())).filter(item=>item?item:false),
              check         = true

          if (sequenceArray.length != this.question.activeChoices.length) {
            check = false
            swal('Em...', 'Make sure your total sequence items should be equal to number of the available choices!', "info")
          } else if ((new Set(sequenceArray)).size != sequenceArray.length) {
            check = false
            swal('Em...', 'Make sure your sequence has no duplication !', "info")
          } else {
            _.forEach(sequenceArray, item => {
              if (item > this.question.activeChoices.length) {
                check = false
                swal('Em...', 'Make sure each sequence number is smaller than the total number of available choices!', "info")
              }
            })
          }
          if (check) {
            return sequenceArray
          }
          return false
        },
        addChoice(){
          if (_.isFunction(this.addChoiceHandler)) {
            this.addChoiceHandler(this.question)
          }
        },
        removeAnswer(choice){
          if (_.isFunction(this.removeChoiceHandler)) {
            this.removeChoiceHandler(choice)
          }
        },
        updateCorrectSequence(e){
          console.log(e)
          const choicesSequence = this.stringToAnswerArray(e.target.value.trim())
          if (choicesSequence) {
            this.updateQuestionHandler('answer', choicesSequence)
          }
        }
      }
    }
</script>
<style></style>