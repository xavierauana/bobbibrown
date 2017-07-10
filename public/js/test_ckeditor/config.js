var token = document.querySelector("meta[name='csrf-token']").getAttribute("content")

/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function (config) {
  // Define changes to default configuration here.
  // For complete reference see:
  // http://docs.ckeditor.com/#!/api/CKEDITOR.config


  config.extraPlugins = "html5audio,eqneditor,html5video,font,colorbutton,youtube"
  config.removePlugins = 'elementspath';

  config.autoParagraph = true;


  // The toolbar groups arrangement, optimized for two toolbar rows.
  config.toolbarGroups = [
    //{ name: 'clipboard',   groups: [ 'undo' ] },
    {name: 'editing', groups: ['find', 'selection', 'spellchecker']},
    {name: 'links'},
    {name: 'insert'},
    {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
    {name: 'forms'},
    {name: 'tools'},
    {name: 'document', groups: ['mode', 'document', 'doctools']},
    {name: 'others'},
    '/',
    {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi']},
    {name: 'styles', groups: ['Styles', 'Format', 'Font', 'FontSize']},
    {name: 'colors'},
  ];

  // Remove some buttons provided by the standard plugins, which are
  // not needed in the Standard(s) toolbar.
  config.removeButtons = 'Subscript,Superscript,Source,Anchor';

  // Set the most common block elements.
  config.format_tags = 'p;h1;h2;h3;pre';

  // Simplify the dialog windows.
  config.removeDialogTabs = 'image:advanced;link:advanced';

  config.filebrowserUploadUrl = '/CKEditorFileUploader/upload?_token=' + token
  config.filebrowserImageUploadUrl = '/CKEditorFileUploader/upload?type=Images&_token=' + token
  config.filebrowserHtml5audioUploadUrl = '/CKEditorFileUploader/upload?type=Audios&_token=' + token
  config.filebrowserHtml5VideoUploadUrl = '/CKEditorFileUploader/upload?type=Videos&_token=' + token
  //config.filebrowserUploadUrl = '/ckeditor/uploader/upload?_token=' + token
  //config.filebrowserImageUploadUrl = '/ckeditor/uploader/upload?type=Images&_token=' + token
  //config.filebrowserHtml5audioUploadUrl = '/ckeditor/uploader/upload?type=Audios&_token=' + token
  //config.filebrowserHtml5VideoUploadUrl = '/ckeditor/uploader/upload?type=Videos&_token=' + token
};
