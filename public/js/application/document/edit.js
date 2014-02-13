
$(function() {
   var doc = ace.edit('editor');
   // make doc global
   window.doc = doc;
   var Mode = require('ace/mode/markdown').Mode;
   doc.getSession().setMode(new Mode());
   doc.setFontSize('12pt');

   var content = $("#content");
   doc.getSession().setValue(content.val());
   doc.getSession().on('change', function() {
      content.val(doc.getSession().getValue());
   });
});