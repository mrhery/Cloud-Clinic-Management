<style>
#ic-search-list {
	display: none;
	position: absolute;
	background-color: #363636;
	width: 95%;
	overflow-y: auto;
	z-index: 1;
}

.ic-list-item {
	color: white;
	padding: 10px;
	cursor: pointer;
	font-size: 9pt;
}

.ic-list-item:hover {
	background-color: black;
}

.time-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding: 10px;
        }
        .time-box {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f4f4f4;
            text-align: center;
            min-width: 60px;
        }
</style>



<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.min.css">

    <!-- jQuery UI Timepicker Addon -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css">


<h3>Create appointment</h3>
<form autocomplete="off" method="POST">
	<div id="accordion" class="mb-3">
		<div class="card">
			<div class="card-header">
				<a class="card-link" data-toggle="collapse" href="#select-customer">
					1. Select Customer Information
				</a>
			</div>
				
			<div id="select-customer" class="collapse show" data-parent="#accordion">
				<div class="card-body p-2">
					<div class="row">
						<div class="col-md-6">
							<div class="input-group mb-3">
								<input type="text" autofocus class="form-control" id="search-ic" name="search-ic" placeholder="Keywords..." autofill="off" />
								
								<div class="input-group-append">
									<button class="btn btn-outline-primary" id="btn-customer-search" type="button"><span class="fa fa-search"></span> Search</button>
									<button class="btn btn-outline-danger" id="btn-customer-reset" type="button" style="display: none;"><span class="fa fa-close"></span> Reset</button>
								</div>
							</div>
							
							<div id="ic-search-list"></div>
						</div>
						
						<div class="col-md-6"></div>
						
						<div class="col-md-6">
							<input type="hidden" name="c_id" />
							Name:
							<input type="text" class="form-control" name="name" placeholder="Name" autofill="off" /><br />
							
							IC / Passport:
							<input type="text" class="form-control" name="ic" placeholder="IC / Passport" value="<?= Input::get("ic") ?>" /><br />
						</div>
						
						<!-- <div class="col-md-6">						
							Phone:
							<input type="tel" class="form-control" name="phone" placeholder="+60 1..." /><br />
							
							Email:
							<input type="email" class="form-control" name="email" placeholder="example@abc.com" /><br />
						</div> -->
					</div>
					
					<div class="row">
						<div class="col-6 text-right">
						</div>
						
						<div class="col-6 text-right">
							<button type="button" class="btn btn-sm btn-primary" data-toggle="collapse" href="#select-appointment">
								Next <span class="fa fa-arrow-right"></span>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="card">
			<div class="card-header">
				<a class="collapsed card-link" data-toggle="collapse" href="#select-appointment">
					2. Appointment
				</a>
			</div>
			
			<div id="select-appointment" class="collapse" data-parent="#accordion">
				<div class="card-body p-2">
					<div class="row">
						<div class="col-md-6">
						Clinic:
							<select class="form-control" name="clinic">
							
							<?php
								$q = DB::conn()->query("SELECT * FROM clinics WHERE c_id IN (SELECT cu_clinic FROM clinic_user WHERE cu_user = ?)", [Session::get("user")->u_id])->results();
								
								foreach($q as $s){
								?>
								<option value="<?= $s->c_ukey ?>"><?= $s->c_name ?></option>
								<?php
								}
							?>
							</select>
							
						Attendee:
							<select class="form-control" name="pic">
								<option value="0">Unset</option>
							<?php
								$q = DB::conn()->query("SELECT * FROM users WHERE u_id IN (SELECT cu_user FROM clinic_user WHERE cu_clinic = ?) AND u_admin = 0", [Session::get("clinic")->c_id])->results();
								
								foreach($q as $s){
								?>
								<option value="<?= $s->u_key ?>"><?= $s->u_name ?></option>
								<?php
								}
							?>
							</select>
							<div id="calendar"></div>
							<input type="hidden" name="date" class="form-control" value="<?= date("Y-m-d") ?>" required />
							
							Time:
							<input type="text" id="timepicker" class="form-control"><br /><br />


							<!-- <div class="col-md-6"> -->
						
						<br />
					<!-- </div> -->
				
						</div>
						
						<div class="col-md-6">
							<table class="table table-hover table-fluid">
								<tbody id="date-appointment">
									<tr>
										<td class="text-center"><i>Please select a date</i></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					
					<div class="row">
						<div class="col-6 text-left">
							<button type="button" class="btn btn-sm btn-primary" data-toggle="collapse" href="#select-customer">
								<span class="fa fa-arrow-left"></span> Prev 
							</button>
						</div>
						
						<div class="col-6 text-right">
							<button type="button" class="btn btn-sm btn-primary" data-toggle="collapse" href="#select-appointment-detail">
								Next <span class="fa fa-arrow-right"></span>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="card">
			<div class="card-header">
				<a class="collapsed card-link" data-toggle="collapse" href="#select-appointment-detail">
					3. Appointment Detail
				</a>
			</div>
			
			<div id="select-appointment-detail" class="collapse" data-parent="#accordion">
				<div class="card-body p-2">
					<div class="row">
						<div class="col-md-6">
							Status:
							<select class="form-control" name="status">
								<option value="0">Pending</option>
								<option value="1" selected>Approved</option>
								<option value="2">Cancelled</option>
							</select><br />
						</div>
						
						<div class="col-md-6">
							Description:
							<textarea class="form-control" name="reason" autofocus placeholder="Description"></textarea><br />
						</div>
					</div>
					
					<div class="row">
						<div class="col-6 text-left">
							<button type="button" class="btn btn-sm btn-primary" data-toggle="collapse" href="#select-appointment">
								<span class="fa fa-arrow-left"></span> Prev 
							</button>
						</div>
						
						<div class="col-6 text-right">
							<button type="button" class="btn btn-sm btn-primary" data-toggle="collapse" href="#select-history">
								Next <span class="fa fa-arrow-right"></span>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="card">
			<div class="card-header">
				<a class="collapsed card-link" data-toggle="collapse" href="#select-history">
					4. Visit History (optional)
				</a>
			</div>
			
			<div id="select-history" class="collapse" data-parent="#accordion">
				<div class="card-body p-2">
					<table class="table table-hover table-fluid table-bordered">					
						<tbody id="visit-history">
							<tr>
								<td class="text-center"><i>No Record</i></td>
							</tr>
						</tbody>
					</table>
					
					<div class="row">
						<div class="col-6 text-left">
							<button type="button" class="btn btn-sm btn-primary" data-toggle="collapse" href="#select-appointment-detail">
								<span class="fa fa-arrow-left"></span> Prev 
							</button>
						</div>
						
						<div class="col-6 text-right">
							<button type="button" class="btn btn-sm btn-primary" data-toggle="collapse" href="#select-billing">
								Next <span class="fa fa-arrow-right"></span>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>	
		
		<div class="card">
			<div class="card-header">
				<a class="collapsed card-link" data-toggle="collapse" href="#select-billing">
					5. Billing Information (optional)
				</a>
			</div>
			
			<div id="select-billing" class="collapse" data-parent="#accordion">
				<div class="card-body p-2">
					<table class="table table-hover table-fluid table-bordered">					
						<tbody id="billing-history">
							<tr>
								<td class="text-center"><i>No Record</i></td>
							</tr>
						</tbody>
					</table>
					
					<div class="row">
						<div class="col-6 text-left">
							<button type="button" class="btn btn-sm btn-primary" data-toggle="collapse" href="#select-history">
								<span class="fa fa-arrow-left"></span> Prev 
							</button>
						</div>
						
						<div class="col-6 text-right"></div>
					</div>
				</div>
			</div>
		</div>
	</div> 

	<div class="text-center">
	<?php
		Controller::form("appointment", [
			"action"	=> "create"
		]);
	?>
		<button class="btn btn-success">
			<span class="fa fa-rocket"></span> Submit
		</button>
	</div>
</form>

<script>
	$(document).on("keyup", "#search-ic", function(){
	var skey = $(this).val();
	$("#ic-search-list").show();
	
	$.ajax({
		url: PORTAL + "webservice/customers",
		method: "POST",
		data: {
			action: "search",
			skey: skey
		},
		dataType: "text"
	}).done(function(res){
		// console.log(res);
		var o = JSON.parse(res);
		
		if(o.status == "success"){
			$("#ic-search-list").html("");
			
			o.data.forEach(function(c){
				$("#ic-search-list").append('\
					<div class="ic-list-item" data-id="'+ c.id +'">\
						<strong>'+ c.name +' ('+ c.ic +')</strong><br />\
						'+ c.phone +' <br /> '+ c.email +'\
					</div>\
				');
			});
		}
	});
});


var calendar = prepareCalendar("#calendar", {
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
			// console.log(res);
			
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
<script>
      var twintyfour=true, $inputbox=$('.timepicker');

var setTimearea=function(meridian){
    var $div=$('<div/>'), $input=$('<input type="text"/>');
    var lists=['hour', 'min', 'sec'];
    $div.clone().addClass('timepicker_wrap').insertAfter($inputbox);
    for(var i=0; i< lists.length; i++){
        $div.clone().addClass(lists[i]).appendTo('.timepicker_wrap');
        $div.clone().addClass('btn prev').appendTo('.'+lists[i]);
        $div.clone().addClass('ti_tx').append($input.clone().addClass('in_txt')).appendTo('.'+lists[i]);
        $div.clone().addClass('btn next').appendTo('.'+lists[i]);
    }
    if(meridian){
        twintyfour=false;
        $div.clone().addClass('meridian').appendTo('.timepicker_wrap');
        $div.clone().addClass('btn prev').appendTo('.meridian');
        $div.clone().addClass('ti_tx').append($input.clone().addClass('in_txt')).appendTo('.meridian');
        $div.clone().addClass('btn next').appendTo('.meridian');
    }
};
var checkTime=function(tnum, place){
    var $area=$(place.parentElement.parentElement).find('.in_txt'), m, h;
    switch(place.parentElement.className){
        case 'hour':
            if(place.classList[1] === 'prev') {
                h=resuceNum(tnum);
                $area.eq(0).val(addZero(h, true));
            }
            else if(place.classList[1] === 'next'){
                h=addNum(tnum);
                $area.eq(0).val(addZero(h, true));
            }
            break;
        case 'min':
            if(place.classList[1] === 'prev') {
                m=resuceNum(tnum);
                $area.eq(1).val(addZero(m));
            }
            else if(place.classList[1] === 'next'){
                m=addNum(tnum);
                $area.eq(1).val(addZero(m));
            }
            break;
        case 'sec':
            if(place.classList[1] === 'prev') {
                sec=resuceNum(tnum);
                $area.eq(2).val(addZero(sec));
            }
            else if(place.classList[1] === 'next'){
                sec=addNum(tnum);
                $area.eq(2).val(addZero(sec));
            }
            break;
        case 'meridian':
            if($area.eq(3).val() === 'AM') $area.eq(3).val('PM');
            else $area.eq(3).val('AM');
            break;
        default:
            alert('get fail');
    }
};
function addZero(i, hours) {
    if(hours){
        if(i>24) i=1;
        else if (i<1) i=24;
        !twintyfour ? i>12 ? i-=12 : '':'';
    }
    else{
        if(i>59) i=0;
        else if(i < 0) i=59;
    }
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}
function setInit(inputbox){
    var $area=$(inputbox[0].nextElementSibling).find('.in_txt');
    var date=new Date(), tz='AM';
    var list=[addZero(date.getHours(), true), addZero(date.getMinutes()), addZero(date.getSeconds()), tz];
    if(inputbox.val().length===0){
        for(var i=0; i<$area.length; i++)	$($area[i]).val(list[i]);
        setValue(inputbox, $area);
    }else {
        var formateTime=inputbox.val().split(':');
        for(var i=0; i<$area.length; i++)   $($area[i]).val(formateTime[i]);
    }
}
function isSetTimeArea(dom){
    var open=false;
    if($('body').find('.timepicker_wrap')[1] !==undefined)
        open=$.contains($('body').find('.timepicker_wrap')[0],dom)|| $.contains($('body').find('.timepicker_wrap')[1],dom)
    else open=$.contains($('body').find('.timepicker_wrap')[0],dom)
    return open;
}
function setValue(inputbox, area){
    area.eq(3).val()===undefined ?
        inputbox.val(area.eq(0).val()+':'+area.eq(1).val()+':'+area.eq(2).val()) :
        inputbox.val(area.eq(0).val()+':'+area.eq(1).val()+':'+area.eq(2).val()+':'+area.eq(3).val());
}
function addNum(i){
    return ++i;
}
function resuceNum(i){
    return --i;
}
function closeIt() {
    $tab=$('.timepicker_wrap');
    $tab.stop().fadeOut(1000);
}

window.onLoad=setTimearea(false); //show merdian or not; Empty to hide merdian select

!function (){
    'use strict';
    var $submit=$('input[type=submit]');
    $inputbox.on('focus', function(){
        var input = $(this),$tab=$(this.nextElementSibling);
        if (input.is($inputbox)) input.select();
        $tab.stop().fadeIn(1000);
        setInit(input);
    });
    $(document).on('click', function(e){
        var _this=e.target;
        setTimeout(function(){
            var focused_element = $(document.activeElement);
            if (!focused_element.is(':input') && !isSetTimeArea(_this)){
                for(var i= 0, l=focused_element.find('.in_txt:visible').length; i<l; i++){
                    if(focused_element.find('.in_txt:visible')[i].value!== 'AM' && focused_element.find('.in_txt:visible')[i].value!=='PM'){
                        if(focused_element.find('.in_txt:visible')[i].value!==undefined){
                            $(focused_element.find('.in_txt:visible')[i]).val((addZero(parseInt(focused_element.find('.in_txt:visible')[i].value))));
                        }
                    }
                }
                focused_element.find('.timepicker_wrap:visible')[0] !==undefined ? setValue($(focused_element.find('.timepicker_wrap:visible')[0].parentElement).find('.timepicker'),  $(focused_element.find('.in_txt:visible'))): '';
                closeIt();
            }
        }, 0);
    });
    $('.prev').on('click', function(e){
        var $area=$(this.parentElement.parentElement).find('.in_txt');
        checkTime($(e.target.nextElementSibling.children).val(), e.target);
        setValue($(this.parentNode.parentElement.previousElementSibling), $area);
    });
    $('.next').on('click', function(e){
        var $area=$(this.parentElement.parentElement).find('.in_txt');
        checkTime($(e.target.previousElementSibling.children).val(), e.target);
        setValue($(this.parentNode.parentElement.previousElementSibling), $area);
    });
}(window, document);

    </script>

