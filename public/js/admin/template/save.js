
$(function() {
   var doc = ace.edit('editor');
   var Mode = require('ace/mode/latex').Mode;
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