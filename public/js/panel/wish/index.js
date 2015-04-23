$(document).ready(function() {
	$('#make-a-wish').click(function() {
		$('#make-a-wish').fadeOut(400, function() {
			$('#wish-form').fadeIn(400);
		});
	});

});