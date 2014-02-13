var editor = function() {
	
   /* constants, do not modify! */
	var DEF_TEXT = {
			save: '<i class="icon-save"></i> Save',
			view: '<i class="icon-eye-open"></i> View',
		};
	
	function load(file) {
		
	}
	
	function save() {
		
	}
	
	function preview() {
		
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

	function code() {
	}

	function link() {
	}

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
