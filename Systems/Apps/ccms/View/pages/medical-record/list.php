<?php
$show = Input::get("show");
$search = Input::get("search");
$page = (int)Input::get("page");
$npage = 1;

if ($page < 1) {
    $page = 1;
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

</style>

<a href="<?= PORTAL ?>medical-record/pre-create" class="bg-primary text-light fab fab-right-bottom usp-right-sheet">
	<span class="fa fa-plus"></span>
</a>
		
<a href="<?= PORTAL ?>print-list-medical-record" class="fab bg-warning text-dark fab-right-bottom" style="bottom: 110px; width: 60px; height: 60px; right: 30px;">
	<span class="fa fa-print"></span>
</a>

<div class="row mb-3">
	<div class="col-md-4 col-sm-6">
		<div class="input-group mb-3">
			<input type="text" class="form-control" name="search" placeholder="Search">
			<div class="input-group-append">
				<button class="btn btn-success" type="submit"><span class="fa fa-search"></span></button>
			</div>
		</div>
	</div>
	
	<div class="col-md-8 col-sm-6">
		<form action="" method="GET" class="text-right">
			<a href="<?= PORTAL ?>appointments?page=<?= $page - 1 ?>&search=<?= $search ?>" class="btn btn-sm btn-primary">
				<span class="fa fa-arrow-left"></span>
			</a>
			
			<input type="number" name="page" class="form-control text-center pagination-input" value="<?= $page ?>" /> / <?= $npage ?>
			<input type="hidden" value="<?= $search ?>" name="search" />
			
			<a href="<?= PORTAL ?>appointments?page=<?= $page + 1 ?>&search=<?= $search ?>" class="btn btn-sm btn-primary">
				<span class="fa fa-arrow-right"></span>
			</a>
		</form>
	</div>
</div>

<div class="row">
<?php
$no = 1;

if(Session::get("admin")){
	$q = customers::list();
}else{
	$q = DB::conn()->query("SELECT * FROM customers WHERE c_id IN (SELECT cc_customer FROM clinic_customer WHERE cc_clinic = ?)", [Session::get("clinic")->c_id])->results();
}

foreach ($q as $c) {
?>
	<div class="col-md-6 col-sm-12 col-xs-12">
		<div class="card mb-3 shadow xa-href usp-right-sheet" href="<?= PORTAL ?>medical-record/view/<?= $c->c_ukey ?>">
			<div class="card-body">
				<div class="row">
					<div class="col-2">
						<img src="<?= PORTAL ?>assets/images/user-default.png" class="img img-fluid" />
					</div>
					
					<div class="col-10">
						<b><?= $c->c_name ?> (<?= $c->c_ic ?>)</b><br />
						Tel: <?= empty($c->c_phone) ? "-" : $c->c_phone ?> | Email: <?= empty($c->c_email) ? "-" : $c->c_email ?>
						<hr />
						<span class="badge badge-dark">Records: <?= count(customer_record::getBy(["cr_customer" => $c->c_id])) ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php 
} 
?>
</div>
<?php
Page::append(<<<HTML
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
					<div class="ic-list-item usp-popup-window usp-right-sheet-close-this" data-usp-popup-window-title="+ Add Medical Record" href="'+ PORTAL +'medical-record/create?ic='+ c.ic +'&doc=" data-ic="'+ c.ic +'">\
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
	
	//window.location = PORTAL + "medical-record/create?ic=" + ic + "&doc=";
});

$(document).on("click", ".attachment-file", function(){
	var src = $(this).children("img").attr("src");
	$("#image-viewer").show();
	$("#image-viewer-image").prop("src", src);
	$("#image-viewer-close").show();
});

$(document).on("click", "#image-viewer-close", function(){
	$("#image-viewer").hide();
	$("#image-viewer-image").prop("src", null);
	$("#image-viewer-close").hide();
});

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
                doc: selected_doc,
                customer: selected_customer_id,
                data: reader.result,
				ufid: uniqFileId,
				name: file.name
            },
            dataType: "text"
        }).done(function (res) {
            // console.log(res);
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

var selected_doc = "";
var selected_customer_id = "";

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
	
	$.ajax({
		url: PORTAL + "webservice/records",
		method: "POST",
		data: {
			action: "update",
			doc: selected_doc,
			illness: illness,
			examination: examination,
			investigation: investigation,
			diagnosis: diagnosis,
			plan: plan,
			prescription: JSON.stringify(prescriptions),
			customer: selected_customer_id
		},
		dataType: "text"
	}).done(function(res){
		// console.log(res);
		
		var o = JSON.parse(res);
		
		if(o.status == "success"){
			$("#saved-status").text("(last saved at "+ o.data +")");
		}else{
			alert(o.message);
		}
	});
}

$(document).on("keyup", "#illness, #examination, #investigation, #diagnosis, #plan", function(){
	update_note();
});

$(document).on("click", "#add-to-list-pres", function(){
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

$(document).on("keyup", "#pres-add-name", function(){
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
HTML
);