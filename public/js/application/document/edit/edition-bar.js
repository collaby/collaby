
$(function () {
   
   $("#bt-save").click(function() {
      editor.save();
   });
   
   $("#bt-preview").click(function() {
      editor.preview();
   });
   
   $("#bt-bold").click(function() {
      editor.bold();
   });
   
   $("#bt-italic").click(function() {
      editor.italic();
   });
   
   $("#bt-code").click(function() {
      editor.code();
   });
   
   $("#bt-link").click(function() {
      editor.link();
   });
   
   $(".bt-header").click(function() {
      var depth = $(this).attr("data-depth") + " ";
      editor.header(depth);
   });
});
