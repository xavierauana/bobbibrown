<template lang="html">
    <div class="content">
		<form class="form-horizontal" method="post" role="form">
			<fieldset>
				<legend>Create New Question</legend>
				<div class="form-group">
					<label for="question_type_id"
                           class="col-sm-2 control-label">Question Type: </label>
					<div class="col-sm-10" v-if="questionTypes.length > 0">
						<select class="form-control" name="question_type_id" id="question_type_id"
                                @change="changeChosenQuestionType" v-model="chosenQuestionTypeCode">
						<option value="">-- Please Selection A Question Type --</option>
						<option v-for="type in pickFromTypes" :value="type.component">{{ type.label }}</option>
						</select>
					</div>
				</div>
			</fieldset>

			<fieldset>
				<component
                        v-if="chosenQuestionTypeCode"
						:test-id="test_id"
                        :is="chosenQuestionTypeCode"
                        :question-types="questionTypes"
                        v-on:persist-question="persistQuestionHandler"
                ></component>
			</fieldset>
		</form>
	</div>
</template>

<script type="text/babel">
    import MultipleChoice from "./MultipleChoiceQuestion.vue"
    import FillInTheBlankSingle from "./FillInTheBlankSingleQuestion.vue"
    import FillInTheBlankMultiple from "./FillInTheBlankMultipleQuestion.vue"
    import InlineMultipleChoice from "./InlineMultipleChoiceQuestion.vue"
    import InlineFillInTheBlank from "./InlineFillInBlanksQuestion.vue"
    import ReOrder from "./ReorderQuestion.vue"
    import Comprehension from "./ComprehensionQuestion.vue"
    import {Network} from "./../Network/network"

    export default{
      props     : ['test_id'],
      components: {
        ReOrder,
        Comprehension,
        MultipleChoice,
        InlineMultipleChoice,
        InlineFillInTheBlank,
        FillInTheBlankSingle,
        FillInTheBlankMultiple,
      },
      data() {
        return {
          postUrl               : "",
          chosenQuestionTypeCode: "MultipleChoice",
          questionTypes         : [],
          pickFromTypes         : [
            {component: "MultipleChoice", label: "Multiple Choice"},
//            {component: "InlineMultipleChoice", label: "Multiple Choice - Inline"},
//            {component: "InlineFillInTheBlank", label: "Fill in the blank - Inline"},
//            {component: "FillInTheBlankSingle", label: "Fill in the blank - Single"},
//            {component: "FillInTheBlankMultiple", label: "Fill in the blank - Multiple"},
//            {component: "ReOrder", label: "Reorder"},
          ]
        }
      },
      created(){
        axios.get("/admin/questionTypes")
             .then(response => this.questionTypes = response.data)
      },
      methods   : {
        persistQuestionHandler(data, successfulClosure, rejectedClosure)
        {
          return this._persistQuestion(data)
                     .then(successfulClosure)
                     .catch(rejectedClosure)
        },
        _persistQuestion(data){
          return new Promise((resolve, reject) => {
            return Network.createSingleMultipleChoice(this.test_id, data)
                          .then(
                            response => resolve(response),
                            response => reject(response)
                          )
                          .catch(response => reject(response))
          })

        },
        changeChosenQuestionType(e){
          switch (e.target.value) {
            case "MultipleChoice":
              this.chosenQuestionTypeCode = "MultipleChoice"
              break;
            case "FillInTheBlankSingle":
              this.chosenQuestionTypeCode = "FillInTheBlankSingle"
              break;
            case "FillInTheBlankMultiple":
              this.chosenQuestionTypeCode = "FillInTheBlankMultiple"
              break;
            case "InlineMultipleChoice":
              this.chosenQuestionTypeCode = "InlineMultipleChoice"
              break;
            case "ReOrder":
              this.chosenQuestionTypeCode = "ReOrder"
              break;
            case "Comprehension":
              this.chosenQuestionTypeCode = "Comprehension"
              break;
            case "InlineFillInTheBlank":
              this.chosenQuestionTypeCode = "InlineFillInTheBlank"
              break;
            default:
              this.chosenQuestionTypeCode = ""
          }
        }
      }
    }
</script>
