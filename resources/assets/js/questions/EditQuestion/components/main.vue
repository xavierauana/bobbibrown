<template lang="html">
    <div class="panel panel-default">
        <div class="panel-heading"> Edit Question </div>
        <div class="panel-body" v-if="question">
             <component :is="questionType"
                        :question="question"
                        :set-editor-content="setEditorContent"
                        :set-choice-editors-content="setChoiceEditorsContent"
                        :update-content-handler="updateChoice"
                        :update-question-handler="updateQuestion"
                        :remove-choice-handler="removeChoice"
                        :add-choice-handler="addChoice"
                        :toggle-handler="toggle"
             ></component>
        </div>
        <div class="panel-footer">
             <div class="form-group">
                <a class="btn btn-info" href="#"
                   @click.prevent="goBack">Back</a>
                <a class="btn btn-success" href="#" @click.prevent="update">Update</a>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import swal from "sweetalert2"
    import {Question as Network} from "./../../../questions/Network/network"
    import Question from "./../../../models/Question"
    import SingleMultipleChoice from "./EditSingleMultipleChoice.vue"
    import MultipleMultipleChoice from "./EditMultipleMultipleChoice.vue"
    import InlineMultipleChoice from "./EditInlineMultipleChoice.vue"
    import SingleFillInBlanks from "./EditSingleFillInBlanks.vue"
    import MultipleFillInBlanks from "./EditMultipleFillInBlanks.vue"
    import InlineFillInBlanks from "./EditInlineFillInBlanks.vue"
    import ReOrder from "./EditReOrder.vue"

    export default {
      props     : {
        testId: {
          type    : Number,
          required: true
        }
      },
      data() {
        return {
          question     : null,
          questionTypes: []
        }
      },
      computed  : {
        questionType() {
          if (this.questionTypes.length && this.question.question_type_id) {
            const questionType = _.find(this.questionTypes, {"id": this.question.question_type_id})
            return questionType ? questionType.code : null
          }
          return null
        }
      },
      components: {
        ReOrder,
        SingleFillInBlanks,
        InlineFillInBlanks,
        MultipleFillInBlanks,
        SingleMultipleChoice,
        InlineMultipleChoice,
        MultipleMultipleChoice,
      },
      created() {
        axios.get(window.location.href + "?ajax=true")
             .then(({data}) => {
               this.question = new Question(data[0])
               if (data[0].answer) this.question.setCorrectAnswer(data[0].answer)
             })
        axios.get('/admin/questionTypes')
             .then(({data}) => {
               this.questionTypes = data
               Vue.nextTick(() => {
                 const checkStrings = ['prefix', 'content']
                 _.forEach(Object.keys(CKEDITOR.instances), key => {
                   checkStrings.forEach(checkString => {
                     if (key.indexOf(checkString) > -1 && this.question.hasOwnProperty(checkString)) {
                       CKEDITOR.instances[key].setData(this.question[checkString])
                     }
                   })
                 })
               })
             })
             .catch(res => console.log(res))

      },
      destroyed() {
        Object.keys(CKEDITOR.instances)
              .forEach(key => CKEDITOR.instances[key].destroy(true))
      },
      methods   : {
        toggle(key) {
          if (!this.question.toggleProperty(key)) {
            swal("Em....", "Choice cannot be updated. Please report to admin!", "info")
          }
        },
        updateQuestion(key, value) {
          if (!this.question.setValue(key, value)) {
            swal("Em....", "Choice cannot be updated. Please report to admin!", "info")
          }
        },
        updateChoice(choice, key, value) {
          if (!choice.setValue(key, value)) {
            swal("Em....", "Choice cannot be updated. Please report to admin!", "info")
          }
        },
        update() {
          Network.updateQuestion(this.testId, this.question.id, this.question)
                 .then(response => window.location.href = "/admin/tests/" + this.testId + "/questions")
        },
        setEditorContent(editor) {
        },
        goBack() {
          window.location.href = "/admin/tests/" + this.testId + "/questions"
        },
        removeChoice(choice) {
          if (this.question.setChoiceActiveToFalse(choice)) {
            CKEDITOR.instances[choice.textareaId].destroy(true)
          }
        },
        addChoice(question) {
          // TODO weather this check is necessary?
          if (this.question.id === question.id) this.question.addChoice()
        },
        setChoiceEditorsContent(data) {
          data.forEach(choice => CKEDITOR.instances.hasOwnProperty(choice.textareaId) ? CKEDITOR.instances[choice.textareaId].setData(choice.content) : "")
        }
      }
    }

</script>
<style></style>