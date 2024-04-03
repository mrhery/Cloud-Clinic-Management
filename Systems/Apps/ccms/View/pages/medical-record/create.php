<?php
$c = customers::getBy(["c_ic" => Input::get("ic")]);

if(count($c) > 0){
	$c = $c[0];
	
	$doc = Input::get("doc");
	
	if(empty($doc)){
		$doc = "doc-" . date("Ymd") . Session::get("clinic")->c_id . "-" . F::UniqId(6);
	}
	
	$d = customer_record::getBy(["cr_key" => $doc, "cr_clinic" => Session::get("clinic")->c_id, "cr_customer" => $c->c_id]);
	
	if(count($d) > 0){
		$d = $d[0];
	}else{
		$d = null;
	}
}else{
	$c = null;
}
?>
<style>
#search-pres-box {
	position: absolute; 
	width: 95%; 
	background-color: #363636;
	overflow-y: auto;
}

.search-pres-item {
	color: white; 
	padding: 10px; 
	cursor: pointer;
}

.search-pres-item:hover {
	background-color: black;
}

#ic-search-list {
	display: none;
	position: absolute; 
	background-color: #363636; 
	width: 95%; 
	overflow-y: auto;
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
</style>

<div class="card">
	<div class="card-header">
		<a href="<?= PORTAL ?>medical-record" class="btn btn-sm btn-primary mr-2">
			<span class="fa fa-arrow-left"></span> Back
		</a>
		
		Create new Record
	</div>
	
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#home"><span class="fa fa-user"></span> 
							Customer Information
						</a>
					</li>
				
				<?php
					if(!is_null($c)){
				?>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#menu1"><span class="fa fa-file"></span> Service Notes</a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#menu2"><span class="fa fa-folder"></span> History</a>
					</li>
				<?php
					}
				?>
				</ul>
				
				<div class="tab-content">
					<div class="tab-pane active mt-2" id="home">
						<div class="row">
							<div class="col-md-5">
								<div class="card">
									<div class="card-header">
										<span class="fa fa-search"></span> Search Info
									</div>
									
									<div class="card-body">
										<input type="text" class="form-control" id="search-ic" placeholder="Search..." />
										
										<div id="ic-search-list"></div>
									</div>
								</div>
							</div>
							
							<div class="col-md-7">
							<?php
								if(!is_null($c)){
							?>
								<a href="<?= PORTAL ?>medical-record/create" class="btn btn-sm btn-danger mb-3">
									<span class="fa fa-close"></span> Reset
								</a><br />
								
								Name:
								<input type="text" class="form-control" name="name" placeholder="Name" value="<?= $c->c_name ?>" disabled /><br />	
								
								Phone:
								<input type="tel" class="form-control" name="phone" placeholder="+60 1..." value="<?= $c->c_phone ?>" disabled /><br />
								
								Email:
								<input type="email" class="form-control" name="email" placeholder="example@abc.com" value="<?= $c->c_email ?>" disabled /><br />
							<?php
								}else{
							?>
								<form action="" method="POST">
									Name:
									<input type="text" class="form-control" name="name" placeholder="Name" /><br />	
									<div class="col-md-6">
									IC:
									<input type="text" placeholder="IC / Passport" name="ic" class="form-control" /> <br>
									
									Phone:
									<input type="tel" class="form-control" name="phone" placeholder="+60 1..." /><br />
									
									Email:
									<input type="email" class="form-control" name="email" placeholder="example@abc.com" /><br />
									
									<button class="btn btn-success btn-sm">
										<span class="fa fa-save"></span> Add Customer
									</button>
								<?php
										Controller::form("medical-record", ["action" => "create"]);
								?>
								</form>
							<?php
								}
							?>
							</div>
						</div>
					</div>
				
				<?php
					if(!is_null($c)){
				?>
					<div class="tab-pane fade mt-2" id="menu1">
					<?php
						if(!is_null($d)){
						?>
						<h4>
							Service Notes
						</h4>
						
						<small id="saved-status">(last saved at <?= date("d M Y H:i:s\ ", $d->cr_time) ?>)</small><br >
						<hr />
						
						Remarks:
						<textarea class="form-control" id="illness" Placeholder="Underlying Illness..."><?= $d->cr_illness ?></textarea><br />
						
						<!--History of Presenting Illness / Examination:
						<textarea class="form-control" id="examination" Placeholder="History of Presenting Illness..."><?= $d->cr_examination ?></textarea><br />
						
						Investigations:
						<textarea class="form-control" id="investigation" Placeholder="Investigations..."><?= $d->cr_investigation ?></textarea><br />
						
						Diagnosis:
						<textarea class="form-control" id="diagnosis" Placeholder="Diagnosis..."><?= $d->cr_diagnosis ?></textarea><br />
						
						Plans:
						<textarea class="form-control" id="plan" Placeholder="Plans..."><?= $d->cr_plan ?></textarea><br />-->
						
						Prescriptions: 
						<button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#add-prescription">
							<span class="fa fa-plus"></span> Add Prescription
						</button>
						
						<table class="table table-hover table-fluid table-bordered mt-2">
							<thead>
								<tr>
									<th>Details</th>
									<th class="text-center" width="10%">Quantity</th>
									<th class="text-right" width="25%">Price (RM)</th>
									<th class="text-right" width="20%">Total (RM)</th>
									<th class="text-right" width="5%">::</th>
								</tr>
							</thead>
							
							<tbody id="list-pres">
							<?php
								$rps = record_prescription::getBy(["rp_record" => $d->cr_id]);
								
								foreach($rps as $rp){
									$i = items::getBy(["i_id" => $rp->rp_item]);
									
									if(count($i) > 0){
										$i = $i[0];
									}else{
										$i = null;
									}
								?>
								<tr id="pres-<?= $rp->rp_id ?>" data-id="<?= $rp->rp_id ?>">
									<td>
										<?= is_null($i) ? "<i>Item not found</i>" : $i->i_name ?><br />
										<?= $rp->rp_remarks ?>
										<input type="hidden" value="<?= is_null($i) ? "" : $i->i_key ?>" class="pres-<?= $rp->rp_id ?>-id" />
									</td>
									
									<td class="text-center pres-<?= $rp->rp_id ?>-quantity" contenteditable="true">
										<?= $rp->rp_quantity ?>
									</td>
									
									<td class="text-center pres-<?= $rp->rp_id ?>-freq" contenteditable="true">
										<?= $rp->rp_frequency ?>
									</td>
									
									<td class="text-center pres-<?= $rp->rp_id ?>-remarks" contenteditable="true">
										<?= $rp->rp_quantity * $rp->rp_frequency  ?>
									</td>
									
									<td class="text-center">
										<button class="btn btn-sm btn-danger del-prescription" type="button">
											<span class="fa fa-trash"></span>
										</button>
									</td>
								</tr>
								<?php
								}
							?>
							</tbody>
						</table>
						<?php
						}else{
						?>
						<h4>
							Service Notes
						</h4>
						
						<small id="saved-status">(not saved yet - <?= $doc ?>)</small><br >
						<hr />
						
						Description:
						<textarea class="form-control" id="illness" Placeholder="Description"></textarea><br />
						
						<!--History of Presenting Illness / Examination:
						<textarea class="form-control" id="examination" Placeholder="History of Presenting Illness..."></textarea><br />
						
						Investigations:
						<textarea class="form-control" id="investigation" Placeholder="Investigations..."></textarea><br />
						
						Diagnosis:
						<textarea class="form-control" id="diagnosis" Placeholder="Diagnosis..."></textarea><br />
						
						Plans:
						<textarea class="form-control" id="plan" Placeholder="Plans..."></textarea><br />-->
						
						Service Item: 
						<button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#add-prescription">
							<span class="fa fa-plus"></span> Item
						</button>
						
						<table class="table table-hover table-fluid table-bordered mt-2">
							<thead>
								<tr>
									<th>Details</th>
									<th class="text-center" width="10%">Quantity</th>
									<th class="text-right" width="25%">Price (RM)</th>
									<th class="text-right" width="20%">Total (RM)</th>
									<th class="text-right" width="5%">::</th>
								</tr>
							</thead>
							
							<tbody id="list-pres">
							</tbody>
						</table>
						<?php
						}
					?>
						<div style="height: 140px; border: 1px solid #ced4da; margin-bottom: 20px; overflow-y: scroll; padding: 10px; white-space: nowrap;" id="list-attachment">							
							<div style="border: 1px solid #ced4da; height: 115px; width: 150px; cursor: pointer; position: relative; margin-right: 10px; margin-bottom: 10px; float: left;">
								<label for="upload-attachment" style="width: 100%; height: 100%; position: absolute; text-align: center; top: 50%; left: 50%;  transform: translate(-50%, -50%); cursor: pointer;">	
									<input id="upload-attachment" onchange="upload_attachment()" type="file" name="attachment[]" accept="image/*,application/pdf" multiple style="visibility: hidden;" />
									
									<div style="">
										<span class="fa fa-plus"></span><br />
										Upload File(s)
									</div>
								</label>
							</div>							
						</div>
					</div>
					
					<div class="tab-pane fade mt-2" id="menu2">
						<h4>History</h4>
						
						<table class="table table-hover table-fluid table-bordered dataTable">
							<thead>
								<tr>
									<th class="text-center" width="15%">Date</th>
									<th class="text-center" width="20%">Dr / User</th>
									<th class="">Details</th>
									<th class="text-right" width="10%">:::</th>
								</tr>
							</thead>
							
							<tbody>
							<?php
								$crs = customer_record::getBy(["cr_customer" => $c->c_id, "cr_clinic" => Session::get("clinic")->c_id], ["order" => "cr_id DESC", "limit" => 10]);
								
								foreach($crs as $cr){
									$u = users::getBy(["u_id" => $cr->cr_user]);	
									
									if(count($u) > 0){
										$u = $u[0];
									}else{
										$u = null;
									}
								?>
								<tr>
									<td class="text-center" width="15%">
									<?= $cr->cr_date ?><br />
									<?= date("H:i:s\ ", $cr->cr_time) ?>
									</td>
									<td class="text-center" width="20%"><?= !is_null($u) ? $u->u_name : "NIL" ?></td>
									<td class=""><?= $cr->cr_illness ?></td>
									<td class="text-right">
										<a href="#show-record" data-toggle="modal" class="btn btn-sm btn-warning show-record" data-doc="<?= $cr->cr_key ?>" data-customer="<?= $c->c_ukey ?>">
											<span class="fa fa-eye"></span> View
										</a>
									</td>
								</tr>
								<?php
								}
							?>
							</tbody>
						</table>
					</div>
				<?php
					}
				?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="show-record">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><span class="fa fa-eye"></span> View Record</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			
			<div class="modal-body" id="record-content"></div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="add-prescription">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><span class="fa fa-plus"></span> Add Item</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			
			<div class="modal-body">
				Search Item:
				<input type="text" class="form-control" id="pres-add-name" placeholder="Search" />
				<div id="search-pres-box" style="display: none;"></div>
				<br />
				
				<input type="hidden" id="pres-add-id" />
				
				Quantity:
				<input type="number" id="pres-add-quantity" class="form-control" value="1" /><br />
				
				Price:
				<input type="number" id="pres-add-freq" step="0.01" class="form-control" placeholder="0.00" /><br />
				
				Remarks:
				<input type="text" id="pres-add-remarks" class="form-control" placeholder="Remarks" /><br />
				
				<button class="btn btn-sm btn-success" id="add-to-list-pres">
					<span class="fa fa-plus"></span> Add List
				</button>
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div id="image-viewer" style="display: none; position:fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 1050; background-color: rgba(0, 0, 0, 0.8)">
	<img id="image-viewer-image" src="" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); height: auto; max-height: 100%; width: auto; max-width: 100%;" />
</div>

<button id="image-viewer-close" style="display: none; position:fixed; top: 10px; right: 10px; z-index: 1051;" class="btn btn-outline-danger">
	<span class="fa fa-close"></span> Close
</button>

<?php
if(!isset($doc)){
	$doc = "";
}

Page::append(<<<HTML
<script>
$("#search-ic").on("keyup", function(){
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
		
		var o = JSON.parse(res);
		
		if(o.status == "success"){
			$("#ic-search-list").html("");
			
			o.data.forEach(function(c){
				$("#ic-search-list").append('\
					<div class="ic-list-item" data-ic="'+ c.ic +'">\
						<strong>'+ c.name +' ('+ c.ic +')</strong><br />\
						'+ c.phone +' <br /> '+ c.email +'\
					</div>\
				');
			});
		}
	});
});

$(document).on("click", ".ic-list-item", function(){
	var ic = $(this).data("ic");
	
	window.location = PORTAL + "medical-record/create?ic=" + ic + "&doc=$doc";
});
</script>
HTML
);

if(!is_null($c)){
	if(!isset($doc)){
		$doc = "doc-" . date("Ymd") . Session::get("clinic")->c_id . "-" . F::UniqId(6);
		
		Page::append(<<<HTML
<script>

</script>	
HTML
);
	}

Page::append(<<<SCRIPT
<script>
$(document).on("click", ".attachment-file", function(){
	if(!$(this).data("pdf")){
		var src = $(this).children("img").attr("src");
		$("#image-viewer").show();
		$("#image-viewer-image").prop("src", src);
		$("#image-viewer-close").show();
	}
	
});

$(document).on("click", "#image-viewer-close", function(){
	$("#image-viewer").hide();
	$("#image-viewer-image").prop("src", null);
	$("#image-viewer-close").hide();
});

function upload_attachment(){
	var files = $("#upload-attachment")[0].files;
	
	for(var i = 0; i < files.length; i++){
		var file = files[i];
		
		load_file(file);
	}
}

function load_file(file) {
    var reader = new FileReader();
    reader.readAsDataURL(file);

    reader.onload = function () {
        console.log('reader.result',reader.result);

        var isPdf = file.type === 'application/pdf';
		let uniqFileId = "file_" + Math.floor(Math.random() * 100000000);
		
        $("#list-attachment").append('\
            <div class="attachment-file" style="margin-bottom: 10px; border: 1px solid #ced4da; height: 115px; width: 150px; cursor: pointer; position: relative; margin-right: 10px; overflow: hidden; float: left;" '+ (isPdf ? 'data-pdf="true"' : '') +'>\
                ' + (isPdf ? '<a href="'+ PORTAL +'file_viewer/'+ uniqFileId +'" target="_blank" > <img src="'+ PORTAL +'assets/images/pdf_icon.png" style="height: 70px; width: 70px; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" />' : '<img src="' + reader.result + '" style="height: auto; width: 100%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" /></a>') + '\
            </div>');
		
        if (isPdf) {
            // Handle PDF file upload, e.g., display PDF-specific actions
            console.log('PDF file uploaded');
        } else {
            // Handle other file types
            console.log('Image file uploaded');
        }

        $.ajax({
            url: PORTAL + "webservice/records",
            method: "POST",
            data: {
                action: "update_image",
                doc: "$doc",
                customer: "$c->c_ukey",
                data: reader.result,
				ufid: uniqFileId,
				name: file.name
            },
            dataType: "text"
        }).done(function (res) {
            console.log(res);
        });
    };

    reader.onerror = function (error) {
        console.log('Error: ', error);
    };
}

$(".show-record").on("click", function(){
	$("#record-content").html("");
	var doc = $(this).data("doc");
	var cus = $(this).data("customer");
	
	$.ajax({
		url: PORTAL + "webservice/records",
		method: "POST",
		data: {
			action: "view",
			doc: doc,
			customer: cus
		},
		dataType: "text"
	}).done(function(res){
		$("#record-content").html(res);
	});
});

function update_note(){
	var illness = $("#illness").val();
	var examination = $("#examination").val();
	var investigation = $("#investigation").val();
	var diagnosis = $("#diagnosis").val();
	var plan = $("#plan").val();
	
	var prescriptions = [];
	
	$("#list-pres").children("tr").each(function(){
		var id = $(this).data("id");
		var iid = $(".pres-" + id + "-id").val();
		var quantity = $(".pres-" + id + "-quantity").text();
		var freq = $(".pres-" + id + "-freq").text();
		var remarks = $(".pres-" + id + "-remarks").text();
		
		prescriptions.push({
			item: iid,
			quantity: quantity,
			freq: freq,
			remarks: remarks
		});
	});
	
	// console.log({
		// action: "update",
		// doc: "$doc",
		// illness: illness,
		// examination: examination,
		// investigation: investigation,
		// diagnosis: diagnosis,
		// plan: plan,
		// prescription: JSON.stringify(prescriptions)
	// });
	
	$.ajax({
		url: PORTAL + "webservice/records",
		method: "POST",
		data: {
			action: "update",
			doc: "$doc",
			illness: illness,
			examination: examination,
			investigation: investigation,
			diagnosis: diagnosis,
			plan: plan,
			prescription: JSON.stringify(prescriptions),
			customer: "$c->c_ukey"
		},
		dataType: "text"
	}).done(function(res){
		console.log(res);
		
		var o = JSON.parse(res);
		
		if(o.status == "success"){
			$("#saved-status").text("(last saved at "+ o.data +")");
		}else{
			alert(o.message);
		}
	});
}

$("#illness, #examination, #investigation, #diagnosis, #plan").on("keyup", function(){
	update_note();
});

$("#add-to-list-pres").on("click", function(){
	var name = $("#pres-add-name").val();
	var quantity = $("#pres-add-quantity").val();
	var freq = $("#pres-add-freq").val();
	var remarks = $("#pres-add-remarks").val();
	var iid = $("#pres-add-id").val();
	
	var rid = Math.ceil(Math.random() * 10000);
	
	var total = parseInt(quantity) * parseFloat(freq);
	
	$("#list-pres").append('\
		<tr id="pres-'+ rid +'" data-id="'+ rid +'">\
			<td>\
				'+ name +'<br />\
				'+ remarks +'\
				<input type="hidden" class="pres-'+ rid +'-id" value="'+ iid +'" />\
			</td>\
			<td class="text-center pres-'+ rid +'-quantity" contenteditable="true">'+ quantity +'</td>\
			<td class="text-center pres-'+ rid +'-freq" contenteditable="true">'+ freq +'</td>\
			<td class="text-center pres-'+ rid +'-remarks" contenteditable="true">'+ (total) +'</td>\
			<td class="text-center">\
				<button class="btn btn-sm btn-danger del-prescription" type="button">\
					<span class="fa fa-trash"></span>\
				</button>\
			</td>\
		</tr>\
	');
	
	$("#pres-add-name").val("");
	$("#pres-add-quantity").val("1");
	$("#pres-add-freq").val("");
	$("#pres-add-remarks").val("");
	
	update_note();
});

$(document).on("click", ".del-prescription", function(){
	$(this).parent("td").parent("tr").remove();
	
	update_note();
});

$("#pres-add-name").on("keyup", function(){
	$("#search-pres-box").show();
	
	var skey = $(this).val();
	
	$.ajax({
		url: PORTAL + "webservice/prescriptions",
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
			$("#search-pres-box").html("");
			
			if(o.data.length > 0){
				o.data.forEach(function(p){
					$("#search-pres-box").append('\
						<div class="search-pres-item" data-price="'+ p.price +'" data-name="'+ p.name +'" data-id="'+ p.id +'">\
							<strong>'+ p.name +'</strong><br />\
							Available Quantity Balance: '+ p.quantity +'\
						</div>\
					');
				});
			}else{
				$("#search-pres-box").html("<div class='text-center text-light'>No records found.</div>");
			}
		}
	});
});

$(document).on("click", ".search-pres-item", function(){
	$("#search-pres-box").hide();
	
	$("#pres-add-name").val($(this).data("name"));
	$("#pres-add-freq").val($(this).data("price"));
	$("#pres-add-id").val($(this).data("id"));
});
</script>
SCRIPT
);
}