/**
 * Created by Xavier on 19/1/2017.
 */
(function () {
  var doNothingCmd =
        {
          exec: function (editor) {
            return;
          }
        };
  var pluginName = 'doNothing';
  CKEDITOR.plugins.add(pluginName,
                       {
                         init: function (editor) {
                           editor.addCommand(pluginName, doNothingCmd);
                         }
                       });
})();