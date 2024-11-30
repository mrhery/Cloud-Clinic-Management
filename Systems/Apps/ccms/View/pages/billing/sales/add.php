<style>
.pos-rel {
	position: relative;
}

.item-search-container {
	position: absolute;
	width: 100%;
	background-color: rgba(0, 0, 0, 0.8);
	z-index: 1001;
}

.item-search-row {
	padding: 10px;
	color: white;
	cursor: pointer;
}

.item-search-row:hover {
	background-color: black;
}

.close-search {
	cursor: pointer;
}

#customer-search-container{
	position: absolute;
	width: 100%;
	background-color: rgba(0, 0, 0, 0.8);
	z-index: 1001;
	display: none;
}

.customer-search-row {
	padding: 10px;
	color: white;
	cursor: pointer;
}

.customer-search-row:hover {
	background-color: black;
}

.close-customer-search {
	cursor: pointer;
}
</style>
<?php

$ts = DB::conn()->query("SELECT COUNT(*) as total FROM sales")->results();

$run = 0;

if(count($ts) > 0){
	$run = $ts[0]->total;
}

$run = $run + 1;

$no = "HIT-" . date("Y") . "" . str_pad($run, 4, "0", STR_PAD_LEFT);

?>
<div class="card">
    <div class="card-header">
       <a href="<?= PORTAL ?>billing/sales" class="btn btn-primary btn-sm">
			<span class="fa fa-arrow-left"></span> Back
		</a>

		New Sales Invoice
    </div>

    <div class="card-body">
		<div class="row">
			<div class="col-md-6 pos-rel">
				To (Patient) 
				<a href="#about-customer" data-toggle="modal">
					<span class="fa fa-info"></span>
				</a>: 
				<input type="text" class="form-control" id="customer-search" placeholder="Search Patient" />
				<input type="hidden" id="customer" />
				
				<div id="customer-search-container"></div>
				
				<br />
				Document No:
				<input type="text" class="form-control" id="doc-no" placeholder="Doc. No" value="<?= $no ?>" disabled /><br />
				
				Remarks:
				<textarea class="form-control" id="remark" placeholder="Remarks"></textarea><br />
			</div>
			
			<div class="col-md-6">
				Date:
				<input type="date" class="form-control" id="date" value="<?= date("Y-m-d") ?>" /> <br />
				
				<div class="row">
					<div class="col-md-6">
						Total (RM):
						<input type="number" placeholder="0.00" id="total" step="0.01" class="form-control" /><br />
					</div>
					
					<div class="col-md-6">
						Paid (RM):
						<input type="number" placeholder="0.00" id="paid" step="0.01" class="form-control" /><br />
					</div>
				</div><br />
				
				Doc. Type 
				<a href="#about-doc-type" data-toggle="modal">
					<span class="fa fa-info"></span>
				</a>:
				<select class="form-control" id="type">
					<option value="debit_note">Debit Note</option>
					<option value="invoice">Invoice / Bill</option>
					<option value="credit_note">Credit Note</option>
				</select>
			</div>
			
			<div class="col-md-12 mb-3">
				<hr />
				<button class="btn btn-info mb-2 float-right" id="add-item">
					<span class="fa fa-plus"></span> Add Item
				</button>
				
				<table class="table table-hover table-bordered table-fluid">
					<thead>
						<tr>
							<th>Item</th>
							<th class="text-right" width="15%">Cost</th>
							<th class="text-center" width="15%">Qty</th>
							<th class="text-right" width="20%">Total</th>
							<th class="text-right" width="5%">:::</th>
						</tr>
					</thead>
					
					<tbody id="item-list">
					<?php
						$id = 1;
					?>
						<tr id="row-<?= $id ?>" data-row="<?= $id ?>" class="item-row">
							<td class="pos-rel">
								<input type="text" class="form-control search-item" id="search-item-<?= $id ?>" data-row="<?= $id ?>" placeholder="Search item" />
								<input type="hidden" id="item-<?= $id ?>" />
								<br />
								
								Remark:
								<textarea class="form-control" placeholder="Remarks" id="remark-<?= $id ?>"></textarea>
							</td>
							<td>
								<input type="number" id="cost-<?= $id ?>" class="form-control" step="0.01" placeholder="0.00" />
							</td>
							<td>
								<input type="number" id="qty-<?= $id ?>" class="form-control" step="1" placeholder="0" />
							</td>
							<td>
								<input type="number" id="total-<?= $id ?>" class="form-control" step="0.01" placeholder="0.00" />
							</td>
							<td class="text-right" width="5%">
								<button class="btn btn-sm btn-danger delete" data-row="<?= $id ?>">
									<span class="fa fa-trash"></span>
								</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			
			<div class="col-md-12 text-center">
				Please make sure all information is correct. This document cannot be update/edit. To deduct any amount can be done credit/debit note.
				
				<br /><br />
				<button class="btn btn-success" id="save-doc">
					Confirm & Save
				</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="about-doc-type">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">
					<span class="fa fa-info"></span> Document Type?
				</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			
			<div class="modal-body">
				<strong>Invoice / Bill</strong> - Default document for cash/credit pruchase. Increasing item inventory.<br /><br />
				<strong>Credit Note</strong> - Credit note from patient are purchase return. Decreasing item inventory.<br /><br />
				<strong>Invoice / Bill</strong> - Debit not from patient are additional purchase. Increasing item inventory.<br /><br />
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="about-customer">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">
					<span class="fa fa-info"></span> About patient
				</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			
			<div class="modal-body">
				<strong>patients</strong> are mostly your <strong>suppliers, vendors or contractors</strong> which whom send you products or services. Some time patients <strong>can be your special patient</strong> for <strong>personal</strong> or <strong>specific orginization</strong>.
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<?php
Page::append(<<<SCRIPT
<script>
var id = $id;

$(document).on("click", ".delete", function(){
	$("#row-" + $(this).data("row")).remove();
});

$("#add-item").on("click", function(){
	id += 1;
	
	$("#item-list").append('\
		<tr id="row-'+ id +'" data-row="'+ id +'" class="item-row">\
			<td class="pos-rel">\
				<input type="text" class="form-control search-item" id="search-item-'+ id +'" data-row="'+ id +'" placeholder="Search item" />\
				<input type="hidden" id="item-'+ id +'" />\
				<br />\
				\
				Remark:\
				<textarea class="form-control" placeholder="Remarks" id="remark-'+ id +'"></textarea>\
			</td>\
			<td>\
				<input type="number" id="cost-'+ id +'" class="form-control" step="0.01" placeholder="0.00" />\
			</td>\
			<td>\
				<input type="number" id="qty-'+ id +'" class="form-control" step="1" placeholder="0" />\
			</td>\
			<td>\
				<input type="number" id="total-'+ id +'" class="form-control" step="0.01" placeholder="0.00" />\
			</td>\
			<td class="text-right" width="5%">\
				<button class="btn btn-sm btn-danger delete" data-row="'+ id +'">\
					<span class="fa fa-trash"></span>\
				</button>\
			</td>\
		</tr>\
	');
});

$(document).on("keyup", ".search-item", function(){
	var keyword = $(this).val();
	var elem = $(this);
	$("#item-search-result").remove();
	
	$.ajax({
		url: PORTAL + "webservice/items/search",
		method: "POST",
		data: {
			keyword: keyword
		}
	}).done(function(response){
		var obj = JSON.parse(response);
		
		if(obj.status == "success"){
			var html = "";
			
			if(obj.data.length < 1){
				html += '<div class="item-search-row">\
					<strong>No item found</strong>\
				</div>';
			} 
			
			obj.data.forEach(function(a){
				html += '<div class="item-search-row" data-row="'+ elem.data("row") +'" data-item="'+ a.id +'">\
					<strong>'+ a.name +'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+ a.code +'</strong>\
				</div>';
			});
			
			html += '<div class="p-2 close-search text-center bg-dark">\
				<strong class="text-danger"><span class="fa fa-close"></span> Close</strong>\
			</div>';
			
			elem.after('\
				<div class="item-search-container" id="item-search-result">\
					'+ html +'\
				</div>\
			');
		}else{
			elem.after('\
				<div class="item-search-container" id="item-search-result">\
					<div class="p-2 close-customer-search text-center bg-dark">'+ obj.message +'</div>\
				</div>\
			');
		}		
	});
});

$(document).on("click", ".close-search", function(){
	$("#item-search-result").remove();
});

$(document).on("click", ".item-search-row", function(){
	var row = $(this).data("row");
	var item = $(this).data("item");
	
	$("#item-" + row).val(item);
	$("#search-item-" + row).val($(this).text().trim());
	
	$("#item-search-result").remove();
});

$("#customer-search").on("keyup", function(){
	var keyword = $(this).val();
	
	$.ajax({
		url: PORTAL + "webservice/customers1/search",
		method: "POST",
		data: {
			keyword: keyword
		}
	}).done(function(response){
		// console.log("AJAX response:", response);
		var obj = JSON.parse(response);
		
		if(obj.status == "success"){
			var html = "";
			
			if(obj.data.length < 1){
				html += '<div class="customer-search-row">\
					<strong>No customer found</strong>\
				</div>';
			} 
			
			obj.data.forEach(function(a){
				html += '<div class="customer-search-row" data-customer="'+ a.id +'">\
					<strong>'+ a.name +' (Phone : '+ a.phone +') (No IC : '+ a.ic +')</strong>\
				</div>';
			});
			
			html += '<div class="p-2 close-customer-search text-center bg-dark">\
				<strong class="text-danger"><span class="fa fa-close"></span> Close</strong>\
			</div>';
			
			$("#customer-search-container").html(html);
		}else{
			$("#customer-search-container").html('\
				<div class="p-2 close-customer-search text-center bg-dark">'+ obj.message +'</div>\
			');
		}
		
		$("#customer-search-container").show();
	});
});

$(document).on("click", ".close-customer-search", function(){
	$("#customer-search-container").html('');
	$("#customer-search-container").hide();
});

$(document).on("click", ".customer-search-row", function(){
	$("#customer-search").val($(this).text().trim());
	
	$("#customer").val($(this).data("customer"));
	
	$("#customer-search-container").html('');
	$("#customer-search-container").hide();
});

$("#save-doc").on("click", function(){
	var doc = {
		customer: $("#customer").val(),
		no: $("#doc-no").val(),
		remark: $("#remark").val(),
		date: $("#date").val(),
		total: $("#total").val(),
		paid: $("#paid").val(),
		doc_type: $("#type").val(),
		items: []
	};
	
	if($(".item-row").length < 1){
		alert("Please insert at least one item");
	}else{
		$(".item-row").each(function(){
			var row = $(this).data("row");
			
			var item_name = $("#search-item-" + row).val();
			var item = $("#item-" + row).val();
			var remark = $("#remark-" + row).val();
			var cost = $("#cost-" + row).val();
			var qty = $("#qty-" + row).val();
			var total = $("#total-" + row).val();
			
			if(item_name.length > 0){
				doc.items.push({
					id: item,
					item_name: item_name,
					remark: remark,
					cost: cost,
					qty: qty,
					total: total
				});
			}
		});
		
		$.ajax({
			url: PORTAL + "webservice/sales/create",
			method: "POST",
			data: {
				data: JSON.stringify(doc)
			},
			dataType: "text"
		}).done(function(res){
			// console.log(res);
			var obj = JSON.parse(res);
			
			if(obj.status == "success"){
				window.location = PORTAL + "billing/sales/view/" + obj.data.pid
			}else{
				alert(obj.message);
			}
		});
	}
});

</script>
SCRIPT
);