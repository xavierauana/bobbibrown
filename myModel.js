/**
 * Created by Xavier on 14/8/2017.
 */

class BaseObject {

  constructor(baseUrl, params) {
    this.createUrl = "/api/" + baseUrl
    this.indexUrl = "/api/" + baseUrl
    this.updateUrl = id => "/api/" + baseUrl + "/" + id
    this.deleteUrl = id => "/api/" + baseUrl + "/" + id
  }

  create(data) { return axios.post(this.createUrl, data)}

  update(data) { return axios.patch(this.updateUrl(data.id), data)}

  delete() { return axios.delete(this.deleteUrl(data.id))}

  index() { return axios.get(this.indexUrl)}

  where(column, operator, parameter) {

    predicates.push = {
      column,
      operator,
      parameter
    }
    return this
  }
}


const Eloquent = new Proxy({}, {
  get: function (target, name, receiver) {
    return (params) => new BaseObject(name + "/url", params);
  }
});

export default Eloquent