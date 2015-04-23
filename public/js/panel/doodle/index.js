$(document).ready(function() {
	$('#date-start').datepicker({"dateFormat": "yy-mm-dd"});
	$('#date-end').datepicker({"dateFormat": "yy-mm-dd"});


	$('span[data-image]').simpletip({
		content: "",
		fixed: true,
		persistent: true,
		onBeforeShow: function() {
			if (this.loaded) return;
			var el = "<img src='/img/doodle/" + this.getParent().attr('data-image') + "'/>";
			this.getTooltip().html(el);
			this.loaded = true;
		}
	});
	$('span[data-image]').mouseenter(function() {
		$(this).simpletip().show();
	});
	$('span[data-image]').mouseleave(function() {
		$(this).simpletip().hide();
	});
	$('span[data-image]').children('img').click(function() {
		$(this).parent().click();
	});

});