// usp-jquery v1.0

function uspLoadUrl(){
	$("[data-usp-load-url]").each(function(){
		let url = $(this).data("usp-load-url");
		let container = $(this);
		$.ajax({
			url: url,
			method: "POST",
			data:{
				contentOnly: true
			},
			dataType: "text"
		}).done(function(res){
			console.log("usp load url");
			container.html(res);
		});
	});
}

(function(){
	if($ == undefined){
		alert("Fail loading jquery.");
	}else{
		$(document).on("click", ".usp-trigger-load-url", function(){
			uspLoadUrl();
		});
		
		$(document).on("click", "[data-usp-tab-url]", function(){
			let url = $(this).data("usp-tab-url");
			let container = $(this).attr("href");
			
			$.ajax({
				url: url,
				method: "POST",
				data:{
					contentOnly: true
				},
				dataType: "text"
			}).done(function(res){
				$(container).html(res);
			});
		});
		
		$(document).on("click", ".usp-right-sheet", function(e){
			e.preventDefault();
			
			let id;
			let url = $(this).attr("href");
			let random = Math.ceil(Math.random() * 1000000);
			id = "right-sheet-" + random;
			
			$(this).attr("data-right-sheet", id);
			
			$("body").append('\
				<div class="usp-overlay usp-right-sheet-overlay" data-right-sheet="'+ id +'"></div>\
				<div class="usp-right-sheet-container p-3 animate__animated" id="'+ id +'">\
					<div class="text-right">\
						<span class="fa fa-close cursor-pointer usp-right-sheet-close-this" data-right-sheet="'+ id +'"></span> \
					</div>\
					\
					<div class="usp-right-sheet-content" data-right-sheet="'+ id +'">wdfsdfsdf</div>\
				</div>\
			');
			
			$(".usp-overlay[data-right-sheet="+ id +"]").show();
			$("#"+ id).removeClass("animate__bounceOutRight");
			$("#"+ id).addClass("animate__bounceInRight");
			$("#"+ id).show();
			
			$(".usp-right-sheet-content[data-right-sheet="+ id +"]").html("");
			
			let callback = $(this).data("usp-callback");
			
			$.ajax({
				method: "POST",
				data: {
					contentOnly: true
				},
				url: url,
				dataType: "text"
			}).done(function(res){
				$(".usp-right-sheet-content[data-right-sheet="+ id +"]").html(res);
				
				if(callback != undefined && callback != null && callback.length > 0){
					if(typeof window[callback] === 'function'){
						window[callback](res);
					}
				}
			}).fail(function(){
				$(".usp-right-sheet-content[data-right-sheet="+ id +"]").html("Fail getting content from:" + url);
			});
		});
		
		////////////////////////////////////////////////////
		/// Popup Window
		$(document).on("click", ".usp-popup-window", function(e){
			e.preventDefault();
			
			let id;
			let url = $(this).attr("href");
			let title = $(this).data("usp-popup-window-title");
			let random = Math.ceil(Math.random() * 1000000);
			id = "popup-window-" + random;
			
			$(this).attr("data-popup-window", id);
			
			$("body").append('\
				<div class="usp-popup-window-container border-dark animate__animated card" id="'+ id +'">\
					<div class="card-header bg-dark text-light">\
						'+ title +'\
						<div class="float-right">\
							<span class="fa fa-window-minimize cursor-pointer text-light usp-popup-window-minimize-this mr-2" data-popup-window="'+ id +'"></span> \
							<span class="fa fa-window-maximize cursor-pointer text-light usp-popup-window-maximize-this mr-2" data-popup-window="'+ id +'"></span> \
							<span class="fa fa-close cursor-pointer text-light usp-popup-window-close-this" data-popup-window="'+ id +'"></span> \
						</div>\
					</div>\
					\
					<div class="usp-popup-window-content card-body" data-popup-window="'+ id +'">wdfsdfsdf</div>\
				</div>\
			');
			
			$("#"+ id).removeClass("animate__bounceOut");
			$("#"+ id).addClass("animate__bounceIn");
			//$("#"+ id).show();
			
			
			$(".usp-popup-window-content[data-popup-window="+ id +"]").html("");
			
			let callback = $(this).data("usp-callback");
			
			$.ajax({
				method: "POST",
				data: {
					contentOnly: true
				},
				url: url,
				dataType: "text"
			}).done(function(res){
				$(".usp-popup-window-content[data-popup-window="+ id +"]").html(res);
				$("#"+ id).show();
				
				if(callback != undefined && callback != null && callback.length > 0){
					if(typeof window[callback] === 'function'){
						window[callback](res);
					}
				}
			}).fail(function(){
				$(".usp-popup-window-content[data-popup-window="+ id +"]").html("Fail getting content from:" + url);
			});
		});
		
		$(document).on("click", ".usp-popup-window-minimize-this", function(){
			let id = $(this).closest(".usp-popup-window-container").attr("id");
			
			$("#" + id + " > .card-body").removeClass("animate__bounceIn");
			$("#" + id + " > .card-body").addClass("animate__bounceOut");
			$("#" + id + " > .card-body").hide();
			
			$("#" + id).css("height", "auto");
			$("#" + id).css("width", "300px");
			$("#" + id).css("bottom", "0px");
			$("#" + id).prop("minimized", true);
		});
		
		$(document).on("click", ".usp-popup-window-maximize-this", function(){
			let id = $(this).closest(".usp-popup-window-container").attr("id");
			
			$("#" + id + " > .card-body").removeClass("animate__bounceOut");
			$("#" + id + " > .card-body").addClass("animate__bounceIn");
			$("#" + id).css("height", "90%");
			$("#" + id).css("width", "90%");
			$("#" + id).css("left", "5%");
			$("#" + id).css("top", "5%");
			$("#" + id + " > .card-body").show();
		});
		
		$(document).on("click", ".usp-popup-window-close-this", function(){
			let id = $(this).closest(".usp-popup-window-container").attr("id");
			
			$("#" + id).removeClass("animate__bounceIn");
			$("#" + id).addClass("animate__bounceOut");
			
			setTimeout(function(){
				$("#" + id).remove();
			}, 1000);
		});
		
		var isDragging = false;
		var offsetX, offsetY, $currentCard;

		$(document).on("mousedown", ".card-header", function(e) {
			if ($(this).closest(".usp-popup-window-container").length) {
				$currentCard = $(this).closest(".usp-popup-window-container");

				isDragging = true;
				
				offsetX = e.clientX - $currentCard.offset().left;
				offsetY = e.clientY - $currentCard.offset().top;

				$currentCard.addClass("dragging");
			}
		});

		$(document).on("mousemove", function(e) {
			if (isDragging) {
				var newLeft = e.clientX - offsetX;
				var newTop = e.clientY - offsetY;
				var windowWidth = $(window).width();
				var cardWidth = $currentCard.outerWidth();
				
				newLeft = Math.max(0, Math.min(newLeft, windowWidth - cardWidth));
				
				$currentCard.css({
					top: newTop,
					left: newLeft
				});
			}
		});

		$(document).on("mouseup", function() {
			if (isDragging) {
				isDragging = false;
				$currentCard.removeClass("dragging");
				$currentCard = null;
			}
		});

		$(document).on("touchstart", ".card-header", function(e) {
			if ($(this).closest(".usp-popup-window-container").length) {
				$currentCard = $(this).closest(".usp-popup-window-container");

				isDragging = true;
				var touch = e.touches[0];
				offsetX = touch.clientX - $currentCard.offset().left;
				offsetY = touch.clientY - $currentCard.offset().top;
			}
		});

		$(document).on("touchmove", function(e) {
			if (isDragging) {
				var touch = e.touches[0];
				var newLeft = touch.clientX - offsetX;
				var newTop = touch.clientY - offsetY;
				var windowWidth = $(window).width();
				var cardWidth = $currentCard.outerWidth();
				
				newLeft = Math.max(0, Math.min(newLeft, windowWidth - cardWidth));
				
				$currentCard.css({
					top: newTop,
					left: newLeft
				});
			}
		});

		$(document).on("touchend", function() {
			if (isDragging) {
				isDragging = false;
				$currentCard.removeClass("dragging");
				$currentCard = null;
			}
		});

		
		///// End Popup Window
		///////////////////////////////////////////
		
		$(document).on("click", ".usp-right-sheet-close-this", function(){
			let id = $(this).closest(".usp-right-sheet-container").attr("id");
			
			$("#" + id).removeClass("animate__bounceInRight");
			$("#" + id).addClass("animate__bounceOutRight");
			// $(".usp-overlay").remove();
			//$("#"+ id).hide();
			
			setTimeout(function(){
				$(".usp-right-sheet-overlay[data-right-sheet="+ id +"]").remove();
				$("#" + id).remove();
			}, 1000);
		});
		
		$(document).on("click", ".usp-right-sheet-close", function(){
			rightSheetClose();
		});
		
		$(document).on("click", ".usp-overlay", function(){
			let id = $(this).data("right-sheet");
			
			$("#" + id).removeClass("animate__bounceInRight");
			$("#" + id).addClass("animate__bounceOutRight");
			
			setTimeout(function(){
				$(".usp-overlay[data-right-sheet="+ id +"]").remove();
				$("#" + id).remove();
			}, 1000);
		});
		
		$(document).on("click", ".usp-menu", function(e){
			if(window.history){
				e.preventDefault();
				$(".usp-menu").removeClass("active");
			
				$(this).addClass("active");
			
				let url = $(this).data("usp-menu");
								
				if($(this).data("page-title-holder") != undefined && $(this).data("page-title-holder").length > 0){
					let holder = $(this).data("page-title-holder");
					let title = $(this).data("page-title");
					
					$(holder).text(title);
				}
				
				navigate(PORTAL + url, 1, function(){
					uspLoadUrl();
				});
			}else{
				// for browser didn't support window.history will server the side as normal
			}
		});
		
		$(document).on("click", ".usp-navigate", function(e){
			if(window.history){
				e.preventDefault();
				
				let menu = $(this).data("usp-menu");
				
				if(menu != undefined && menu.length > 0){
					$(".usp-menu").removeClass("active");
					$(".usp-menu[data-usp-menu="+ menu +"]").addClass("active");
				}
				
				if($(this).data("page-title-holder") != undefined && $(this).data("page-title-holder").length > 0){
					let holder = $(this).data("page-title-holder");
					let title = $(this).data("page-title");
					
					$(holder).text(title);
				}
				
				navigate($(this).attr("href"));
			}else{
				// none
			}
		});
		
		$(document).on("click", ".usp-form-submit", function(e){
			e.preventDefault();
			let form = $(this).closest('form');
			
			if(form.length > 0){
				let f = form[0];
				let formData = new FormData(f);
				formData.append("asApi", 1);
					
				let url = form.attr("action");
				let method = form.attr("method");
				
				let callback = form.attr("usp-form-callback");
				
				$.ajax({
					url: url,
					method: method,
					data: formData,
					processData: false,
					contentType: false,
					dataType: "json"
				})
				.done(function(res){					
					if(callback != undefined && callback.length > 0){						
						if(typeof window[callback] === 'function'){
							window[callback](res);
						}
					}else{
						if(res["redirect"] != undefined){
							if(res["reload"] == undefined){
								navigate(res.redirect, 1);
							}else{
								window.location = res.redirect;
							}
						}
					}
					
					if(form.hasClass("usp-right-sheet-close")){
						rightSheetClose();
					}
				}).fail(function(){
					console.log("Form request error");
				});
			}else{
				alert("Form is not correctly loaded.");
			}
		});
		
		function rightSheetClose(){
			
			$(".usp-right-sheet-container").removeClass("animate__bounceInRight");
			$(".usp-right-sheet-container").addClass("animate__bounceOutRight");
			
			setTimeout(function(){
				$(".usp-overlay").remove();
				$(".usp-right-sheet-container").remove();
			}, 1000);
		}
		
		function navigate(url, contentOnly = 1, callback = null){
			window.history.pushState(null, null, url);
			
			$.ajax({
				url: url,
				method: "POST",
				data: {
					contentOnly: contentOnly
				},
				dataType: "text"
			}).done(function(res){
				$("#main-content").html(res);
				
				if(callback != null){
					callback();
				}
			});
		}
	}
})();
uspLoadUrl();