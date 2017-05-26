$(document).ready(function(){
	
	// show first panel
	$("#panel-1").fadeIn();
	
	// navigation
	$(".nav").click(function(){
		var href = $(this).attr("href");
		$(this).parents("section").fadeOut(function(){
			$(href).fadeIn();
		});
	});
	
});