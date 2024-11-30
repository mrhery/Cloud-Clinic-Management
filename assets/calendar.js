function prepareCalendar(id, action = {}){
	
	$(id).addClass("calendar-container");
	$(id).html('\
		<header class="calendar-header">\
			<p class="calendar-current-date"></p>\
			<div class="calendar-navigation">\
				<span class="calendar-calendar-prev">\
					<span class="fa fa-chevron-left"></span>\
				</span>\
				\
				<span class="calendar-calendar-next">\
					<span class="fa fa-chevron-right"></span>\
				</span>\
			</div>\
		</header>\
		\
		<table class="table table-hover table-fluid table-bordered">\
			<thead class="calendar-dates-header">\
				<tr>\
					<th>Sun</th>\
					<th>Mon</th>\
					<th>Tue</th>\
					<th>Wed</th>\
					<th>Thu</th>\
					<th>Fri</th>\
					<th>Sat</th>\
				</tr>\
			</thead>\
			\
			<tbody class="calendar-dates-item"></tbody>\
		</table>\
	');
	
	let date = new Date();
	let year = date.getFullYear();
	let month = date.getMonth();
	let selected_dates = {};

	const $day = $(id + " > table > .calendar-dates-item");
	
	if(action["selectStart"] != undefined) {
		action["disableBackDated"] = true;
	}
	
	if(action["year"] != undefined) {
		year = parseInt(action["year"]);
	}
	
	if(action["selectedDates"] != undefined) {
		action["selectedDates"].forEach(function(sD){
			selected_dates[sD] = true;
		});
	}
	
	if(action["enabledStart"] != undefined && action["enabledEnd"] != undefined){
		action["enabledDates"] = getDatesInRange(action["enabledStart"], action["enabledEnd"]);
	}
	
	if(action["month"] != undefined){
		month = parseInt(action["month"]);
		
		if(month < 1){
			month = 12;
			year -= 1;
		}
		
		if(month > 12) {
			month = 1;
			year += 1;
		}
		
		month -= 1;
	}
	
	const months = [
		"January",
		"February",
		"March",
		"April",
		"May",
		"June",
		"July",
		"August",
		"September",
		"October",
		"November",
		"December"
	];
	
	let tYear = new Date().getFullYear();
	let tMonth = new Date().getMonth();
	let tDate = new Date().getDate();
	let tInt = parseInt(tYear + "" + (tMonth < 10 ? "0" + tMonth : tMonth) + "" + (tDate < 10 ? "0" + tDate : tDate));
	
	var obj = {
		manipulate: function(_action){
			for(let k in _action){
				if(action[k] != undefined){
					action[k] = _action[k];
				}
			}
			
			let dayone = new Date(year, month, 1).getDay();
			let lastdate = new Date(year, month + 1, 0).getDate();
			let dayend = new Date(year, month, lastdate).getDay();
			let monthlastdate = new Date(year, month, 0).getDate();
			
			let lit = "";
			let cDay = 0;
			
			for (let i = dayone; i > 0; i--) {
				if(cDay == 0){
					lit += "<tr>";
				}
				
				cDay++;
				
				let cDate =  year + '-' + (month < 2 ? 12 : (month - 1)) + '-' + (monthlastdate - i + 1);
				
				let runningYear = year;
				let runningMonth = month;
				let runningDay = monthlastdate - i + 1;
				let runningDate = year + "-" + (runningMonth < 10 ? "0" + runningMonth : runningMonth) + "-" + (runningDay < 10 ? "0" + runningDay : runningDay);
				
				let cDateActive = "";
				let disabledDate = "";
				let rXd = (monthlastdate - i + 1);
				let rXm = month - 1;
				let tC = parseInt(year+""+ (rXm < 10 ? "0" + rXm : rXm) + "" + (rXd < 10 ? "0" + rXd : rXd));
				
				if(selected_dates[runningDate] != undefined){
					cDateActive = "selected";
				}
				
				if(action["disabledDates"] != undefined){
					if(action["disabledDates"].indexOf(runningDate) > -1){
						disabledDate = "disabled aa";
					}
				}
				
				if(action["disableBackDated"] != undefined){				
					if(action["disableBackDated"]){
						if(tC < tInt){
							disabledDate = "disabled bb";
						}
					}
				}
				
				if(action["enabledDates"] != undefined){
					if(action["enabledDates"].indexOf(runningDate) < 0){
						disabledDate = "disabled cc";
					}
				}
				
				lit +=
					'<td class="inactive select-date lm '+ cDateActive +' '+ disabledDate +'" data-date="'+ cDate +'" data-real-date="'+ runningDate +'">' + (monthlastdate - i + 1) +'</td>';
					
				if(cDay == 7){
					lit += "</tr>";
					cDay = 0;
				}
			}
			
			for (let i = 1; i <= lastdate; i++) {
				if(cDay == 0){
					lit += "<tr>";
				}
				
				cDay++;
				
				let cDate =  year +'-'+ month +'-'+ i;
				let cDateActive = "";
				let disabledDate = "";
				
				let runningYear = year;
				let runningMonth = month + 1;
				let runningDay = i;
				let runningDate = year + "-" + (runningMonth < 10 ? "0" + runningMonth : runningMonth) + "-" + (runningDay < 10 ? "0" + runningDay : runningDay);
				
				let tC = parseInt(year + "" + (month < 10 ? "0" + month : month) + "" + (i < 10 ? "0" + i : i))
				
				if(action["disableBackDated"] != undefined){
					if(action["disableBackDated"]){					
						if(tC < tInt){
							disabledDate = "disabled";
						}
					}
				}
				
				if(selected_dates[runningDate] != undefined){
					cDateActive = "selected";
				}
				
				let isToday = "";
				
				if(date.getDate() == i && month === new Date().getMonth() && year === new Date().getFullYear()){
					isToday = "active";
				}else{
					isToday = "";
				}
				
				if(action["selectStart"] != undefined){
					let selectStart = parseInt(action["selectStart"]);

					if(tC < (tInt + selectStart)){
						disabledDate = "disabled";
					}
				}	

				if(action["disabledDates"] != undefined){
					if(action["disabledDates"].indexOf(runningDate) > -1){
						disabledDate = "disabled";
					}
				}
				
				if(action["enabledDates"] != undefined){
					if(action["enabledDates"].indexOf(runningDate) < 0){
						disabledDate = "disabled";
					}
				}
				
				lit += '<td class="'+ isToday +' select-date cm '+ cDateActive +' '+ disabledDate +'" data-date="'+ cDate +'" data-real-date="'+ runningDate +'">' + i + '</td>';
				
				if(cDay == 7){
					lit += "</tr>";
					cDay = 0;
				}
			}
			
			for (let i = dayend; i < 6; i++) {
				if(cDay == 0){
					lit += "<tr>";
				}
				
				cDay++;
				let cDate =  year +'-'+ (month == 12 ? 1 : (month + 1)) +'-'+ (i - dayend + 1);
				let cDateActive = "";
				let disabledDate = "";
				let nextMonth = month + 1;
				let dD = (i - dayend + 1);
				let cY = year;
				
				let runningYear = year;
				let runningMonth = (month == 12 ? 1 : (month + 1)) + 1;
				let runningDay = i - dayend + 1;
				let runningDate = year + "-" + (runningMonth < 10 ? "0" + runningMonth : runningMonth) + "-" + (runningDay < 10 ? "0" + runningDay : runningDay);
				
				if(nextMonth > 11) {
					nextMonth = 1;
					cY += 1;
				}
				
				let tC = parseInt(cY +""+ (nextMonth < 10 ? "0" + nextMonth : nextMonth) +""+ (dD < 10 ? "0" + dD : dD));
				
				if(selected_dates[runningDate] != undefined){
					cDateActive = "selected";
				}
				
				if(action["disabledDates"] != undefined){
					if(action["disabledDates"].indexOf(runningDate) > -1){
						disabledDate = "disabled";
					}
				}
				
				if(action["disableBackDated"] != undefined){
					if(action["disableBackDated"]){
						if(tC < tInt) {
							disabledDate = "disabled";
						}
					}
				}
				
				if(action["enabledDates"] != undefined){
					if(action["enabledDates"].indexOf(runningDate) < 0){
						disabledDate = "disabled";
					}
				}
				
				lit += '<td class="inactive select-date nm '+ cDateActive +' '+ disabledDate +'" data-date="'+ cDate +'" data-real-date="'+ runningDate +'">'+ (i - dayend + 1) +'</td>';
				
				if(cDay == 7){
					lit += "</tr>";
					cDay = 0;
				}
			}
			
			lit += "</tr>";
			$(id + " > header > .calendar-current-date").text(`${months[month]} ${year}`);
			$day.html(lit);
		}
	};
	
	// obj.manipulate();

	$(document).on("click", id + " > table > tbody > tr > .select-date", function(){
		if(action["viewOnly"] != undefined){
			if(action["viewOnly"]){
				return;
			}
		}
		
		if($(this).hasClass("disabled")){
			alert("This date is disabled. Please pick another date.");
		}else{
			if(action["singleDate"] != undefined){
				$(id + " > table > tbody > tr > .select-date").removeClass("selected");
				selected_dates = {};
				
				if($(this).hasClass("selected")){
					
				}else{
					$(this).addClass("selected");
					selected_dates[$(this).data("real-date")] = true;
				}				
			}else{
				if($(this).hasClass("selected")){
					$(this).removeClass("selected");
					
					delete selected_dates[$(this).data("real-date")];
				}else{
					$(this).addClass("selected");
					selected_dates[$(this).data("real-date")] = true;
				}
			}
			
			
			if(action["onSelectDate"] != undefined){
				action["onSelectDate"]($(this).data("real-date"), Object.keys(selected_dates))
			}
		}
	});

	$(document).on("click", id + " > header > .calendar-navigation > .calendar-calendar-prev", function(){
		month--;
		
		if(month < 0){
			month = 11;
			year -= 1;
		}
		
		obj.manipulate();
	});

	$(document).on("click", id + " > header > .calendar-navigation > .calendar-calendar-next", function(){
		month++;
		
		if(month > 11){
			month = 1;
			year += 1;
		}
		
		obj.manipulate();
	});
	
	function getDatesInRange(startDate, endDate) {
		let start = new Date(startDate);
		let end = new Date(endDate);
		let dateArray = [];
		
		while (start <= end) {
			let year = start.getFullYear();
			let month = (start.getMonth() + 1).toString().padStart(2, '0');
			let day = start.getDate().toString().padStart(2, '0');
			dateArray.push(`${year}-${month}-${day}`);
			
			start.setDate(start.getDate() + 1);
		}

		return dateArray;
	}
	
	return obj;
}