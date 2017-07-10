export const Events = {
  update: eventId => "/admin/events/" + eventId,
  delete: eventId => "/admin/events/" + eventId,
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
}
export const Collections = {
  edit         : collectionId => "/admin/collections/" + collectionId + "/edit",
  lessons      : collectionId => "/admin/collections/" + collectionId + "/lessons",
  update       : collectionId => "/admin/collections/" + collectionId,
  delete       : collectionId => "/admin/collections/" + collectionId,
  lessons_order: collectionId => "/admin/collections/" + collectionId + "/updateOrder",
}
export const Permissions = {
  edit  : permissionId => "/admin/permissions/" + permissionId + "/edit",
  update: permissionId => "/admin/permissions/" + permissionId,
  delete: permissionId => "/admin/permissions/" + permissionId,
}
export const Tests = {
  edit  : testId => "/admin/tests/" + testId + "/edit",
  update: testId => "/admin/tests/" + testId,
  delete: testId => "/admin/tests/" + testId,
}
export const Questions = {
  index : testId => "/admin/tests/" + testId + "/questions",
  edit  : (testId, questionId) => "/admin/tests/" + testId + "/questions/" + questionId + "/edit",
  update: (testId, questionId) => "/admin/tests/" + testId + "/questions/" + questionId,
  delete: (testId, questionId) => "/admin/tests/" + testId + "/questions/" + questionId,
}