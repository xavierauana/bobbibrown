/**
 * Created by Xavier on 22/3/2017.
 */
/**
 * Created by Xavier on 22/3/2017.
 */
class Choice {
  constructor(data = null) {
    this._init()
    if (data) {
      this._setParameters(data)
    }
  }

  _init() {
    this.id = null
    this.content = ""
    this.active = true
    this.textareaId = 'newInputAnswer' + _.random(1, 10000000)
    this.type = "new"
    this.is_corrected = false
  }

  _setParameters(data) {
    _.chain(Object.keys(this))
     .forEach(key => {
       if (data[key]) {
         this[key] = data[key]
       }
     })
     .value()

    this.type = "_db"
    this.textareaId = 'inputAnswer' + data["id"]
  }

  setValue(property, value) {
    if (this.hasOwnProperty(property)) {
      this[property] = value
      return true
    }
    return false
  }
}

export default Choice