// Create a jquery style modal confirm dialog
// Usage:
//    $.confirm(
//        "message",
//        "title",
//        function() { /* Ok action here*/
//        });
$.extend({
	confirm : function(message, title, okAction) {
		$("").dialog({
			// Remove the closing 'X' from the dialog
			open : function(event, ui) {
				$(".ui-dialog-titlebar-close").hide();
			},
			buttons : {
				"Ok" : function() {
					$(this).dialog("close");
					okAction();
				},
				"Cancel" : function() {
					$(this).dialog("close");
				}
			},
			close : function(event, ui) {
				$(this).remove();
			},
			resizable : false,
			title : title,
			modal : true
		}).text(message);
	}
});

$.extend({
	alert : function(message, title) {

		var element = "<div>";
		element += "<br />";
		element += "<div align='center'>";
		element += "<div><img src='res/img/failed.gif'/></div>";
		element += "</div>";
		element += "<br />";
		element += "<div align='center' id='status'>"+message+"</div>";
		element += "</div>";

		$(element).dialog({
			buttons : {
				"Ok" : function() {
					$(this).dialog("close");
				}
			},
			close : function(event, ui) {
				$(this).remove();
			},
			resizable : false,
			title : title,
			modal : true
		});
	}
});