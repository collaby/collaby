
$(function () {
   
   $("#bt-save").click(function () {
      editor.save();
   });
   
   $("#bt-preview").click(function () {
      editor.preview();
   });
   
   $("#bt-bold").click(function () {
      editor.bold();
   });
   
   $("#bt-italic").click(function () {
      editor.italic();
   });
   
   $("#bt-code").click(function () {
      editor.code();
   });
   
   $("#bt-link").click(function () {
      $("#modal-link").modal('show');
   });
   
   $("#modal-link").on('shown.bs.modal', function (e) {
      var range = doc.getSelectionRange();
      if (! range.isEmpty()) {
         var selectedText = doc.getSession().getTextRange(range);
         var urlPattern = /(http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?/;
         if (urlPattern.test(selectedText)) {
            $("#url").val(selectedText);
            $("#description").focus();
         } else {
            $("#description").val(selectedText);
            $("#url").focus();
         }
      } else {
         $("#url").focus();
      }
   });
   
   /**
    * When the modal is hidden clean up the fields.
    */
   $("#modal-link").on('hidden.bs.modal', function (e) {
      $("#url").val("");
      $("#description").val("");
   });
   
   $(".bt-header").click(function () {
      var depth = $(this).attr("data-depth") + " ";
      editor.header(depth);
   });
   
   $("#modal-link-bt-ok").click(function () {
      // TODO: validate precense of URL.
      var url = $("#url").val();
      var description = $("#description").val() || "";
      editor.link(url, description);
      $("#modal-link").modal('hide');
   });
});
