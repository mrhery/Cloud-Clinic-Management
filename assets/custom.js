$(".sidebar-toggle-item").on("click", function(){
	$.ajax({
		url: PORTAL + "webservice/theme_setting",
		method: "POST",
		data: {
			action: "toggle_sidebar"
		}
	});
});

$(document).on("click", ".a-href", function(){
	window.location = $(this).attr("href");
});