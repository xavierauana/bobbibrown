<template lang="html">
    <div>
        <prefix-editor :on-change-handler="updatePrefix"></prefix-editor>
        <question-editor v-show="!is_finished_editing_question" :on-change-handler="updateQuestion"></question-editor>
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
                        v-for="title in selection_titles"
                        v-show="title.status"
                        :title="title.title"
                        :key="title.id"
                        :choices="choices"
                        @remove-choice="removeChoice"
                        @add-choice="addMoreChoice"
                        @update-content="updateChoiceContent">
                </selection-section>
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
    import PrefixEditor from "./PrefixEditor.vue"
    import QuestionEditor from "./QuestionEditor.vue"
    import SelectionSection from "./SelectionSection.vue"
    import * as InlineFunction from "./../helper/InlineMultipleChoiceHelpers"
    export default{
      props     : {
        questionTypes: {
          type: Array
        }
      },
      data(){
        return {
          prefix                      : "",
          filteredContent             : "",
          defaultNumber               : 4,
          closeUrl                    : "/",
          content                     : "",
          page_number                 : 1,
          is_active                   : true,
          is_finished_editing_question: false,
          choices                     : [],
          selection_titles            : [],
          currentId                   : 1,
          choiceObject                : {
            id          : 0,
            active      : true,
            content     : "",
            textareaId  : "answerInput",
            is_corrected: false
          }
        }
      },
      computed  : {
        filterChoices(){
          let result = {}
          for (var i = 0; i < this.selection_titles.length; i++) {
            const title = encodeURI(this.selection_titles[i].title)
            _.map(this.choices, choice => {
              if (choice.textareaId.indexOf(title) > -1) {
                if (result[title]) {
                  result[title].push(choice)
                } else {
                  result[title] = [choice]
                }
              }
            })

          }

          console.log(result)

          return result
        }
      },
      components: {
        PrefixEditor,
        QuestionEditor,
        SelectionSection
      },
      beforeDestroy(){
        CKEDITOR.instances = {}
      },
      methods   : {
        escape(value){
          return encodeURI(value)
        },
        updatePrefix(e){
          this.prefix = e.editor.getData()
        },
        parseQuestion(){
          let data = InlineFunction.filterContentWithSpan(this.content)

          this.updateTitleAndChoices(data.titles)

          return data.content
        },

        updateTitleAndChoices(titles){
          const Titles = InlineFunction.getUpdatedTitles(this.selection_titles, titles)

          if (Titles.newTitles.length) this.createNewSelection(Titles.newTitles)
          if (Titles.removedTitles.length) this.removeTitleChoices(Titles.removedTitles)
        },
        _createSectionChoices(titles){
          _.forEach(titles, title => {
            for (let i = 0; i < this.defaultNumber; i++) {
              this.addMoreChoice({title: title})
            }
          })
        },
        createNewSelection(newTitles){
          this._createSectionChoices(newTitles)

          const disabledTitles = _.filter(this.selection_titles, titleObject => !titleObject.status)

          _.forEach(newTitles, title => {
            if (disabledTitles.indexOf(title) > -1) {
              _.find(this.selection_titles, {"title": title}).status = true
            } else {
              this.selection_titles.push({title: title, status: true})
            }
          })
        },
        removeTitleChoices(removedTitles){
          _.chain(this.selection_titles)
           .filter(titleObject => removedTitles.indexOf(titleObject.title) > -1)
           .forEach(titleObject => {
             titleObject.status = false
             const phrase = escape(titleObject.title + "ans")
             _.chain(this.choices)
              .filter(choice => choice.textareaId.indexOf(phrase) > -1)
              .forEach(choice => this.removeChoice(choice))
              .value()
           })
           .value()
        },
        toggleEditQuestion(){
          if (!this.is_finished_editing_question) {
            this.filteredContent = this.parseQuestion()
          }

          this.is_finished_editing_question = !this.is_finished_editing_question
        },


        updateQuestion(e){
          this.content = e.editor.getData()
        },
        addMoreChoice(paramObject){
          let newChoice    = _.assign({}, this.choiceObject),
              escapedTitle = escape(paramObject.title)
          newChoice.id = this.currentId
          newChoice.textareaId = escapedTitle + newChoice.textareaId + this.currentId
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
              choices  = this.choices.filter(choice => choice.active == true)

          // All choice content must has something
          if (_.filter(choices, choice => !choice.content).length > 0) {
            check = false
            messages.push("All choice must has content")
          }

          // Question content must not be empty
          if (!this.content) {
            check = false
            messages.push("You have enter something for question!")
          }

          // One and Only one corrected answer
          let checkObject = {}
          _.forEach(choices, choice => {
            let index = choice.textareaId.indexOf("answer")

            let title = choice.textareaId.substring(0, index)

            if (checkObject[title]) {
              checkObject[title].push(choice)
            } else {
              checkObject[title] = [choice]
            }
          })
          _.forEach(Object.keys(checkObject), key => {
            var correct = _.filter(checkObject[key], choice => {
              return choice.is_corrected == true
            })
            if (correct.length < 1) {
              check = false
              messages.push("There must be at least one answer for " + unescape(key))
            }
          })

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
            titles          : _.chain(this.selection_titles).filter(titleObject => titleObject.status).map(titleObject => titleObject.title).value(),
            choices         : this.choices.filter(item => item.active == true).map(item => {
              return {
                content     : item.content,
                is_corrected: item.is_corrected,
                textareaId  : item.textareaId
              }
            }),
            page_number     : this.page_number,
            question_type_id: this._choiceQuestionTypeId(),
            is_active       : this.is_active,
          }
        },
        _choiceQuestionTypeId(){
          return _.find(this.questionTypes, {"code": "InlineMultipleChoice"}).id
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
          this.content = ""
          this.page_number = 1
          this.is_active = true
          this.is_finished_editing_question = false
          this.selection_titles = []
          this._removeAllChoiceEditors()
          this.choices = _.filter(this.choices, object => false)
        }
      }
    }
</script>
<style></style>