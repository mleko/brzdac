$(document).ready(function() {

	console.log($('.recent_search_box'));

	$('.recent_search_box').cycle({
		pause: true,
		timeout: 1000
	});
});