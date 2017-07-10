var token = document.querySelector("meta[name='csrf-token']").getAttribute("content")

CKEDITOR.editorConfig = function (config) {

  config.extraPlugins = 'doNothing';

  config.toolbar = [
    {name: 'insert', items: ['Image']}
  ];


  config.autoParagraph = false;

  config.height = 50;

  config.resize_enabled = false;

  config.removePlugins = 'elementspath';

  config.enterMode = CKEDITOR.ENTER_BR;

  config.keystrokes = [
    [13, 'doNothing'],
    [CKEDITOR.SHIFT + 13, 'doNothing']];

  config.filebrowserImageUploadUrl = '/CKEditorFileUploader/upload?type=Images&_token=' + token;

};
