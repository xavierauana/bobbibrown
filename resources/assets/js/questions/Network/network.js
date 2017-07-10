/**
 * Created by Xavier on 20/1/2017.
 */

const URIs = {
  Question: {
    store : testId => "/admin/tests/" + testId + "/questions",
    edit  : (testId, questionId) => "/admin/tests/" + testId + "/questions/" + questionId + "/edit",
    update: (testId, questionId) => "/admin/tests/" + testId + "/questions/" + questionId,
  }
}


export const Network = {
  createSingleMultipleChoice(testId, data){
    const url = URIs.Question.store(testId)

    return axios.post(url, data)
  }
}

export const Test = {
  getTestById(){
    var uri = window.location.href;

    return Vue.http.get(uri)
  },
  persistUpdateTest(data){
    const uri = window.location.href.replace("/edit", "")
    return Vue.http.patch(uri, data)
  }
}

export const Question = {
  getQuestionById(testId, questionId){
    const uri = URIs.Question.edit(testId, questionId)
    return Vue.http.get(uri)
  },
  updateQuestion(testId, questionId, data){
    const uri = URIs.Question.update(testId, questionId)
    return axios.put(uri, data)
  }

}