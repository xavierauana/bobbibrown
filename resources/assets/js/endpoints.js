export const Events = {
  edit        : eventId => "/admin/events/" + eventId + "/edit",
  update      : eventId => "/admin/events/" + eventId,
  delete      : eventId => "/admin/events/" + eventId,
  publish     : eventId => "/admin/events/" + eventId + "/publish",
  frontEnd    : "/events",
  detail      : eventId => "/events/" + eventId,
  registration: eventId => "/events/" + eventId + "/registration",
  cancel      : eventId => "/events/" + eventId + "/cancel"
}
export const Users = {
  show   : userId => "/admin/users/" + userId,
  edit   : userId => "/admin/users/" + userId + "/edit",
  update : userId => "/admin/users/" + userId,
  delete : userId => "/admin/users/" + userId,
  approve: userId => "/admin/users/" + userId + "/approve",
  restore: userId => "/admin/users/" + userId + "/restore",
}
export const Menus = {
  update: menuId => "/admin/events/" + menuId,
  delete: menuId => "/admin/events/" + menuId,
}
export const Lessons = {
  edit  : lessonId => "/admin/lessons/" + lessonId + "/edit",
  tests : lessonId => "/admin/lessons/" + lessonId + "/tests",
  update: lessonId => "/admin/lessons/" + lessonId,
  delete: lessonId => "/admin/lessons/" + lessonId,
  users : lessonId => "/admin/lessons/" + lessonId + "/users",
}
export const Collections = {
  edit         : collectionId => "/admin/collections/" + collectionId + "/edit",
  lessons      : collectionId => "/admin/collections/" + collectionId + "/lessons",
  update       : collectionId => "/admin/collections/" + collectionId,
  delete       : collectionId => "/admin/collections/" + collectionId,
  lessons_order: collectionId => "/admin/collections/" + collectionId + "/updateOrder",
  test         : collectionId => "/admin/collections/" + collectionId + "/tests",
}
export const Permissions = {
  edit  : permissionId => "/admin/permissions/" + permissionId + "/edit",
  update: permissionId => "/admin/permissions/" + permissionId,
  delete: permissionId => "/admin/permissions/" + permissionId,
}
export const Roles = {
  edit       : roleId => "/admin/roles/" + roleId + "/edit",
  update     : roleId => "/admin/roles/" + roleId,
  delete     : roleId => "/admin/roles/" + roleId,
  permissions: roleId => "/admin/roles/" + roleId + "/permissions",
}
export const Categories = {
  edit  : categoryId => "/admin/categories/" + categoryId + "/edit",
  update: categoryId => "/admin/categories/" + categoryId,
  delete: categoryId => "/admin/categories/" + categoryId,
}
export const Lines = {
  edit  : lineId => "/admin/lines/" + lineId + "/edit",
  update: lineId => "/admin/lines/" + lineId,
  delete: lineId => "/admin/lines/" + lineId,
}
export const Products = {
  edit  : productId => "/admin/products/" + productId + "/edit",
  update: productId => "/admin/products/" + productId,
  delete: productId => "/admin/products/" + productId,
}
export const Tests = {
  edit  : testId => "/admin/tests/" + testId + "/edit",
  update: testId => "/admin/tests/" + testId,
  delete: testId => "/admin/tests/" + testId,
  grade : testId => "/tests/" + testId + "/grade",
}
export const Questions = {
  index : testId => "/admin/tests/" + testId + "/questions",
  edit  : (testId, questionId) => "/admin/tests/" + testId + "/questions/" + questionId + "/edit",
  update: (testId, questionId) => "/admin/tests/" + testId + "/questions/" + questionId,
  delete: (testId, questionId) => "/admin/tests/" + testId + "/questions/" + questionId,
}