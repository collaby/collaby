
$(function() {
   var html_editor_mode = $("#html_editor_mode").val();
   var doc = ace.edit('editor');
   var Mode = require('ace/mode/' + html_editor_mode).Mode;
   doc.getSession().setMode(new Mode());
   
   var content = $("#content");
   doc.getSession().setValue(content.val());
   doc.getSession().on('change', function() {
      content.val(doc.getSession().getValue());
   });
   /**
    * editor.getSession().setValue(textarea.val());
      editor.getSession().on('change', function(){
        textarea.val(editor.getSession().getValue());
      });
    */
});