var editor = function() {
	
   /* constants, do not modify! */
	var DEF_TEXT = {
			save: '<i class="icon-save"></i> Save',
			view: '<i class="icon-eye-open"></i> View',
		};
	
	function load(file) {
		
	}
	
	function save(callback) {
        var id = $('#id').val();
            //btn = $('#bt-save').find('i');
        
        callback = callback || null;
        
        //btn.removeClass('fa-save').addClass('fa-refresh fa-spin');
        _handle_save_button(true);

        $.post('/application/document/ajax-save', {
            id : id,
            content : $('#content').val()
        },
        
        function(res) {
            _handle_save_button(false);
            
            if (callback != null) {
                callback();
            }
        });
        
	}
    
    
   /**
    * if preview is selected
    *    call save current content and preview, hiding the editor area
    * else
    *    hide preview area and show editor
    * @returns {void}
    */
	function preview() {
        var id = $('#id').val(),
            //btn = $('#bt-preview').find('i'),
            preview = $('div.preview-content'),
            editor = $('#editor');
        
        if (editor.is(':visible') === true) {
            editor.slideUp('fast');
            //btn.removeClass('fa-eye').addClass('fa-refresh fa-spin');
            _handle_preview_button("previewing");
            save(function() {
                $.getJSON('/application/document/preview/id/'+id+'/format/json',
                function (res) {
                    //btn.removeClass('fa-refresh').removeClass('fa-spin').addClass('fa-times');
                    _handle_preview_button("open");
                    preview.html(res.content).fadeIn('slow');
                });
            });
        } else {
            _handle_preview_button();
            editor.slideDown('fast');
            preview.fadeOut('fast');
        }
	}
	
	function loadFileList() {
		
	}
	
	function loadPreferences() {
		if (_supports_html5_storage()) {
         // TODO: save preferences in item "profile" and jsonify and stringify :)
			var theme = localStorage.getItem("collaby.editor.theme");
			if (theme !== null) {
				//doc.setOption("theme", theme);
			}
		}
	}
	
	function loadindText() {
		return '<i class="icon-spinner icon-spin"></i> Loading...';
	}
	
   /**
    * if something is selected
    *    replace the selection with the text surrounded by **
    * else
    *    insert **{cursor}**
    * @returns {void}
    */
	function bold() {
      var range = doc.getSelectionRange();
      if (range.isEmpty()) {
         var text = "****";
         doc.insert(text);
         var pos = range.end;
         pos.column += 2;
         doc.moveCursorToPosition(pos);
      } else {
         var selectedText = doc.getSession().getTextRange(range);
         var text = "**" + selectedText + "**";
         doc.getSession().replace(range, text);
      }
      doc.focus();
	}
	
   /**
    * if something is selected
    *    replace the selection with the text surrounded by _
    * else
    *    insert _{cursor}_
    * @returns {void}
    */
	function italic() {
      var range = doc.getSelectionRange();
      if (range.isEmpty()) {
         var text = "__";
         doc.insert(text);
         var pos = range.end;
         pos.column += 1;
         doc.moveCursorToPosition(pos);
      } else {
         var selectedText = doc.getSession().getTextRange(range);
         var text = "_" + selectedText + "_";
         doc.getSession().replace(range, text);
      }
      doc.focus();
	}

   /**
    * if something is selected
    *    if it's not the beginning of the line
    *       put the text 2 line under
    *    replace the selection starting with the level
    * else
    *    if it's not the beginning of the line
    *       put the text 2 line under
    *    insert level text
    * @param {string} level it can be '#', '##', '###' ...
    * @returns {void}
    */
	function header(level) {
      var range = doc.getSelectionRange();
      if (range.isEmpty()) {
         var pos = range.end;
         if (range.start.column > 0) {
            level = "\n\n" + level;
            pos.row += 2;
         }
         doc.insert(level);
         pos.column += level.length;
         doc.moveCursorToPosition(pos);
      } else {
         var selectedText = doc.getSession().getTextRange(range);
         var text = level + selectedText;
         if (range.start.column > 0) {
            text = "\n\n" + text;
         }
         doc.getSession().replace(range, text);
      }
      doc.focus();
	}

   /**
    * if something is selected
    *    if is multi line text
    *       surround text with ~~~
    *    else
    *       surround text with `
    *    replace selection
    * else
    *    if it's not the beginning of the line
    *       use `{text}`
    *    else
    *       use ~~~\n{text}\n~~~
    *    insert text
    * @returns {void}
    */
	function code() {
      var range = doc.getSelectionRange();
      if (range.isEmpty()) {
         var pos = range.end;
         var text;
         if (range.start.column > 0) {
            text = "``";
            pos.column += 1;
         } else {
            text = "~~~\n\n~~~";
            pos.row += 1;
         }
         doc.insert(text);
         doc.moveCursorToPosition(pos);
      } else {
         var selectedText = doc.getSession().getTextRange(range);
         var text;
         if (range.isMultiLine()) {
            text = "~~~\n" + selectedText + "\n~~~";
         } else {
            text = "`" + selectedText + "`";
         }
         doc.getSession().replace(range, text);
      }
      doc.focus();
	}

	function link(url, description) {
      var range = doc.getSelectionRange();
      if (range.isEmpty()) {
         var text;
         var pos = range.end;
         if (description === "") {
            text = "<" + url + ">";
         } else {
            text = "[" + description + "]("+ url + ")";
         }
         doc.insert(text);
         doc.moveCursorToPosition(pos);
      } else {
         var selectedText = doc.getSession().getTextRange(range);
         var text;
         if (description === "") {
            text = "<" + url + ">";
         } else {
            text = "[" + description + "]("+ url + ")";
         }
         doc.getSession().replace(range, text);
      }
      doc.focus();
	}

   /**
    * TODO: complicado fazer por hora, envolve upload e outras coisas!
    * @returns {undefined}
    */
	function picture() {
	}
	
	function setTheme(theme) {
//		doc.setOption("theme", theme);
//		$("#cursor-highlight").html(".CodeMirror-activeline-background {background: "
//			+ line_color + " !important;}");
//		if (_supports_html5_storage()) {
//			localStorage.setItem("collaby.editor.theme", theme);
//			localStorage.setItem("collaby.editor.color", line_color);
//		}
	}
	
	/* private functions */
	
	function _supports_html5_storage() {
		try {
			return 'localStorage' in window && window['localStorage'] !== null;
		} catch (e) {
			return false;
		}
	}
    
    function _handle_save_button(isSaving) {
        var button = $("#bt-save");
        if (isSaving) {
            button.html('<i class="fa fa-refresh fa-spin"></i> Saving...').addClass('btn-success');
        } else {
            button.html('<i class="fa fa-save"></i> Save').removeClass('btn-success');
            setTimeout(function() {
                button.removeClass('btn-success');
            }, 1000);
        }
    }
    
    /**
     * @param status String can be: previewing, open. Pass nothing for default.
     */
    function _handle_preview_button(status) {
        status = status || "default";
        var button = $("#bt-preview");
        if (status === "previewing") {
            button.html('<i class="fa fa-refresh fa-spin"></i> Generating...');
        } else if (status === "open") {
            button.html('<i class="fa fa-times"></i> Close');
        } else {
            button.html('<i class="fa fa-eye"></i> Preview');
        }
    }
	
	/* public functions and variables */
	return {
		load: load,
		save: save,
		preview: preview,
		loadindText: loadindText,
		bold: bold,
		italic: italic,
		header: header,
		code: code,
		link: link,
		picture: picture,
		setTheme: setTheme,
		loadFileList: loadFileList,
		loadPreferences: loadPreferences
	};
}();
