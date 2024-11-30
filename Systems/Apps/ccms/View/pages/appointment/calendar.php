<h3>Appointment Calendar</h3>
<hr />
<div class="row">
	<div class="col-md-7">
		<div id="appointment-calendar"></div>
	</div>
	
	<div class="col-md-5">
		<table class="table table-hover table-fluid">
			<tbody id="date-appointment">
				<tr>
					<td class="text-center"><i>Please select a date</i></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<script>
let calendar = prepareCalendar("#appointment-calendar", {
	singleDate: true,
	onSelectDate: function(date, selected_dates){
		$("[name=date]").val(selected_dates.join(","));
		
		$.ajax({
			method: "POST",
			url: PORTAL + "webservice/appointment/date",
			data: {
				date: selected_dates.join(",")
			},
			dataType: "text"
		}).done(function(res){
			console.log(res);
			
			res = JSON.parse(res);
			$("#date-appointment").html("");
			
			if(res.status == "success"){
				if(res.data.length > 0){
					
					res.data.forEach(function(a){
						let badgeStatus = "dark";
						let statusText = "Cancelled";
						
						switch(a.status){
							case 0:
								badgeStatus = "warning";
								statusText = "Pending";
							break;
							
							case 1:
								badgeStatus = "success";
								statusText = "Approved";
							break;
							
							case 2:
								badgeStatus = "dark";
								statusText = "Cancelled";
							break;
						}
						
						$("#date-appointment").append('\
							<tr>\
								<td class="p-2">\
									<b>'+ a.bookedTime +'</b> '+ a.customer +'<br />\
									<b>Attendee: </b> '+ a.attendee +'<br />\
									registered on '+ a.a_date +' | <span class="badge badge-'+ badgeStatus +'">'+ statusText +'</span>\
								</td>\
							</tr>\
						');
					});
				}else{
					$("#date-appointment").html('\
						<tr>\
							<td class="text-center"><i>No appointment</i></td>\
						</tr>\
					');
				}
			}
		});
	}
});
calendar.manipulate();
</script>