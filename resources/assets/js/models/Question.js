/**
 * Created by Xavier on 22/3/2017.
 */
import Choice from "./Choice"
import _ from "lodash"

class Question {

  constructor(data = null) {
    this._init()
    if (data) {
      this._setParameters(data)
    }
  }

  _init() {
    this.id = null
    this.order = 0
    this.answer = []
    this.prefix = ""
    this.content = ""
    this.choices = []
    this.page_number = 1
    this.sub_questions = []
    this.is_active = false
    this.question_type_id = null
    this.is_required_all = false
    this.is_ordered = false
    this.is_fractional = false
  }

  _setParameters(data) {
    _.chain(Object.keys(this))
     .forEach(key => {
       if (data[key]) {
         switch (key) {
           case "choices":
             this[key] = _.map(data[key], objectData => new Choice(objectData))
             break
           case "sub_questions":
             this[key] = _.map(data[key], objectData => new Question(objectData))
             break
           default:
             this[key] = _.isBoolean(this[key]) ? !!data[key] : data[key]
         }
       }
     })
     .value()
  }

  get activeChoices() {
    return _.filter(this.choices, choice => choice.active)
  }

  addChoice() {
    this.choices.push(new Choice())
  }

  setChoiceActiveToFalse(choice) {
    let theChoice = _.find(this.choices, {id: choice.id})
    if (theChoice) {
      theChoice.active = false
      return true
    }
    return false
  }

  removeChoice(choice) {
    this.choices = _.filter(this.choices, item => item.id != choice.id)
  }

  toggleProperty(property) {
    if (this.hasOwnProperty(property) && _.isBoolean(this[property])) {
      this[property] = !this[property]
      return true
    }
    return false
  }

  setValue(property, value) {
    if (this.hasOwnProperty(property)) {
      this[property] = value
      return true
    }
    return false
  }

  updateChoice(choice, property, value) {
    let theChoice = _.find(this.choices, item => item === choice)
    if (theChoice) {
      return theChoice.setValue(property, value)
    }
    return false
  }

  setCorrectAnswer(answer) {
    if (answer) {
      this.choices = _.map(this.choices, choice => {
        if (answer.indexOf(choice.id) > -1) {
          choice.is_corrected = true
        }
        return choice
      })
    }
  }
}

export default Question