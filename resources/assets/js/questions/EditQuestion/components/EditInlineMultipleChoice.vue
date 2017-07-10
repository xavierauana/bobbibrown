<template lang="html">
    <div class="editSingleMultipleChoice">
        <h3>Edit Single Multiple Choice</h3>

        <prefix-editor :on-change-handler="updatePrefix"></prefix-editor>
        <question-editor :on-change-handler="updateQuestion"></question-editor>

        <button v-show="!is_finished_editing_question" class="btn btn-info"
                @click.prevent="toggleEditQuestion">Complete</button>


        <div v-show="is_finished_editing_question" class="panel panel-default">
            <div class="panel-heading">Sample Question</div>
            <div class="panel-body" v-html="filteredContent"></div>
        </div>

        <button v-show="is_finished_editing_question" class="btn btn-info" @click.prevent="toggleEditQuestion">Edit Question again</button>

        <div v-show="is_finished_editing_question">
            <div class="panel-group">
                <selection-section
                        v-for="title in titles"
                        v-if="allChoices.length > 0"
                        v-show="title.status"
                        :title="title.title"
                        :key="title.title"
                        :choices="allChoices"
                        @remove-choice="removeChoice"
                        @add-choice="addMoreChoice"
                        @update-content="updateChoiceContent">
                </selection-section>
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
    import Question from "./../../../models/Question"
    import Choice from "./../../../models/Choice"
    import QuestionEditor from "./../../components/QuestionEditor.vue"
    import PrefixEditor from "./../../components/PrefixEditor.vue"
    import SelectionSection from "./../../components/SelectionSection.vue"

    import * as InlineFunction from "./../../helper/InlineMultipleChoiceHelpers"

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
        toggleHandler          : {
          type   : Function,
          require: true
        },
      },
      data(){
        return {
          is_finished_editing_question: false,
          filteredContent             : "",
          titles                      : [],
        }
      },
      computed  : {
        allChoices(){
          let allChoices = []
          _.forEach(this.question.sub_questions, question => _.forEach(question.choices, choice => allChoices.push(this.transformChoice(choice, question))))
          return allChoices
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
        SelectionSection
      },
      mounted(){
        for (let name in  CKEDITOR.instances) {
          this.setEditorContent(CKEDITOR.instances[name])
        }
        this.titles = _.map(this.question.sub_questions, question => {
          return {title: question.content, status: true}
        });
      },
      methods   : {
        toggleActive(){
          this.toggleHandler('is_active')
        },
        removeChoice(choice){
          _.forEach(this.question.sub_questions, question => {
            question.setChoiceActiveToFalse(choice)
          })
        },
        addMoreChoice(title){
          let question = _.find(this.question.sub_questions, {content: title.title})
          if (question) question.addChoice()
        },
        updateChoiceContent(choice, key, value){
          choice.setValue(key, value)
        },
        toggleEditQuestion(){
          if (!this.is_finished_editing_question) {
            this.filteredContent = this.parseQuestion()
          }

          this.is_finished_editing_question = !this.is_finished_editing_question
        },
        parseQuestion(){
          let data = InlineFunction.filterContentWithSpan(this.question.content)
          this.updateTitlesAndChoices(this.titles, data.titles)
          return data.content
        },
        updateTitlesAndChoices(selectionTitle, parsedTitles){
          const Titles = InlineFunction.getUpdatedTitles(selectionTitle, parsedTitles)
          if (Titles.newTitles.length) {
            for (let i = 0; i < Titles.newTitles.length; i++) {
              this.question.sub_questions.push(this.createNewSubQuestion(Titles.newTitles[i]))
              this.titles.push({status: true, title: Titles.newTitles[i]})
            }
          }

          if (Titles.removedTitles.length) {
            for (let i = 0; i < Titles.removedTitles.length; i++) {
              this.question.sub_questions = _.filter(this.question.sub_questions, question => question.content !== Titles.removedTitles[i])
              this.titles = _.forEach(this.titles, title => {
                if (title.title === Titles.removedTitles[i]) {
                  title.status = false
                }

              })
              _.forEach(Object.keys(CKEDITOR.instances), key => {
                if (key.indexOf(Titles.removedTitles[i] + 'answerInput') > -1) CKEDITOR.instances[key].destroy(true)
              })
            }
          }
        },
        _updateSelectionTitles(titles, parsedTitles){
          // Add choices for new titles
          const newTitles = _.filter(titles, title => this.selection_titles.indexOf(title) < 0)

          // Remove choices for removed parsedTitles
          const removedTitles = _.filter(parsedTitles, title => parsedTitles.indexOf(title) < 0)
          _.forEach(removedTitles, title => {
            parsedTitles.splice(parsedTitles.indexOf(title), 1)
            _.forEach(this.choices, choice => {
              if (choice.textareaId.indexOf(escape(title)) > -1) {
                this.removeChoice(choice)
              }
            })
          })

        },
        createNewSubQuestion(title){
          let newSubQuestion = new Question()
          newSubQuestion.content = title
          newSubQuestion.is_active = true
          newSubQuestion.question_type_id = 1
          newSubQuestion.addChoice()
          newSubQuestion.addChoice()
          newSubQuestion.addChoice()
          return newSubQuestion
        },

        updatePrefix(e){
          this.updateQuestionHandler('prefix', e.editor.getData())
        },
        updateQuestion(e){
          this.updateQuestionHandler('content', e.editor.getData())
        },
        transformChoice(choice, question){
          choice.textareaId = choice.id ? escape(question.content) + "answerInput" + choice.id : escape(question.content) + "answerInput" + _.random(100000, 1000000)
          return choice
        },
      }
    }
</script>
<style></style>
