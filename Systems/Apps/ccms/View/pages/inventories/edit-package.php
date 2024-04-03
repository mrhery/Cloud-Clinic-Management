<?php
$i = items::getBy(["i_key" => url::get(2), "i_type" => "package", "i_clinic" => Session::get("clinic")->c_id]);
		
if(count($i) > 0){
	$i = $i[0];
}else{
	$i = null;
}
?>
<style>

#search-box {
	display: none;
	position: absolute;
	background-color: #363636;
	width: 95%;
	overflow-y: auto;
}

.search-item {
	color: white;
	padding: 10px;
	cursor: pointer;
	font-size: 9pt;
}

.search-item:hover {
	background-color: black;
}

.close-search {
	color: white;
	padding: 10px;
	cursor: pointer;
	font-size: 9pt;
}

.close-search:hover {
	background-color: black;
}

</style>

<div class="card">
	<div class="card-header">
		<a href="<?= PORTAL ?>inventories" class="btn btn-sm btn-primary mr-2">
			<span class="fa fa-arrow-left"></span> Back
		</a>
		
		Edit Item: <?= is_null($i) ? "-" : $i->i_name ?>
	</div>
	
	<div class="card-body">
	<?php
		if(is_null($i)){
			new Alert("error", "No item were found.");
		}else{
	?>
		<div class="row">				
			<div class="col-md-6">
				Name:
				<input type="text" class="form-control" id="name" placeholder="Item name" value="<?= $i->i_name ?>" /><br />
				
				Description:
				<textarea class="form-control" id="description" placeholder="Description"><?= $i->i_description ?></textarea><br />
				
			</div>
			
			<div class="col-md-6">					
				Code:
				<input type="text" class="form-control" id="code" placeholder="Item code" value="<?= $i->i_code ?>" /><br />
				
				SKU:
				<input type="text" class="form-control" id="sku" placeholder="SKU(s)" value="<?= $i->i_sku ?>" /><br />
			</div>
			
			<div class="col-md-12 mb-5">
				<hr / >
				<h3 class="mb-2">
					Items
					
					<button type="button" class="btn btn-primary btn-sm" id="add-item" data-toggle="modal" data-target="#item-search">
						<span class="fa fa-plus"></span> Add Item
					</button>
				</h3>
				
				<table class="table table-hover table-fluid table-bordered">
					<thead>
						<tr>
							<th width="50%">Item</th>
							<th class="text-center" width="10%">Quantity</th>
							<th class="text-right" width="10%">Price (RM)</th>
							<!--<th class="text-right" width="10%">Total (RM)</th>-->
							<th class="text-right" width="5%">:::</th>
						</tr>
					</thead>
					
					<tbody id="item-list">
					<?php
						$id = 1;
						
						$ix = package_item::getBy(["pi_package" => $i->i_id]);
						
						foreach($ix as $iy){
							// echo  $iy->pi_item;
							// echo "|" . Session::get("clinic")->c_id;
							$in = items::getBy(["i_id" => $iy->pi_item, "i_clinic" => Session::get("clinic")->c_id]);
							
							if(count($in) > 0){
								$in = $in[0];
							}else{
								$in = null;
							}
						?>
						<tr id="row-<?= $id ?>" data-row="<?= $id ?>">
							<td>
								<input id="item-<?= $id ?>" value="<?= $iy->pi_name ?>" type="text" placeholder="Search Item" class="form-control" data-row="<?= $id ?>" />
								
							<?php
								if(!is_null($in)){
								?>
									<input id="item-id-<?= $id ?>" type="hidden" value="<?= $in->i_key ?>" data-row="<?= $id ?>" />
								<?php
								}else{
								?>
									<input id="item-id-<?= $id ?>" type="hidden" value="item_id" data-row="<?= $id ?>" />
								<?php
								}
							?>
							</td>
							<td class="text-center">
								<input class="form-control text-center" type="number" step="1" placeholder="0" id="quantity-<?= $id ?>" value="<?= $iy->pi_quantity ?>" />
							</td>
							<td class="text-right">
								<input class="form-control text-right" type="number" step="0.01" value="<?= $iy->pi_price ?>" placeholder="0.00" id="price-<?= $id ?>" />
							</td>
							<td class="text-right">
								<button id="remove-<?= $id ?>" data-row="<?= $id ?>" class="btn btn-sm btn-danger remove">
									<span class="fa fa-close"></span>
								</button>
							</td>
						</tr>
						<?php
							$id++;
						}
					?>
					</tbody>
					
					<tfoot>
						<tr>
							<td colspan="2" class="text-right pt-4">
								<h6>Total (RM)</h6>
							</td>
							
							<td>
								<input type="number" id="total" value="<?= $i->i_price ?>" class="form-control text-right" value="0.00" step="0.01" placeholder="0.00" />
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
			
			<div class="col-md-12 text-center">
				<button type="button" id="save" class="btn btn-success">
					<span class="fa fa-save"></span> Save
				</button>
			</div>
		</div>
	<?php
		}
	?>
	</div>
</div>

<div class="modal fade" id="item-search">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">
					<span class="fa fa-plus"></span> Add Item
				</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			
			<div class="modal-body">
				Search Item:
				<input type="text" class="form-control" id="search-item" placeholder="Search..." />
				
				<div id="search-box">
					<div id="search-box-items">
					
					</div>
					
					<div class="close-search">
						<strong>
							<span class="fa fa-close"></span> 
							Close Search
						</strong>
					</div>
				</div>
				
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<?php
if(!is_null($i)){
Page::append(<<<SCRIPT
<script>
var id = $id;
$("#add-itemx").on("click", function(){
	
});

$(document).on("click", ".remove", function(){
	var row = $(this).data("row");
	
	$("#row-" + row).remove();
});

$("#search-item").on("keyup", function(){
	$("#search-box").show();
	
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
			$("#search-box-items").html("");
			
			if(o.data.length > 0){
				o.data.forEach(function(p){
					$("#search-box-items").append('\
						<div class="search-item" data-price="'+ p.price +'" data-name="'+ p.name +'" data-id="'+ p.id +'">\
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

$(document).on("click", ".close-search", function(){
	$("#search-box").hide();
});

$(document).on("click", ".search-item", function(){
	var item_id = $(this).data("id");
	var item_price = $(this).data("price");
	var item_name = $(this).data("name");
	
	$("#item-list").append('\
		<tr id="row-'+ id +'" data-row="'+ id +'">\
			<td>\
				<input id="item-'+ id +'" value="'+ item_name +'" type="text" placeholder="Search Item" class="form-control" data-row="'+ id +'" />\
				<input id="item-id-'+ id +'" type="hidden" value="'+ item_id +'" data-row="'+ id +'" />\
				\
			</td>\
			<td class="text-center">\
				<input class="form-control text-center" type="number" step="1" placeholder="0" id="quantity-'+ id +'" value="1" />\
			</td>\
			<td class="text-right">\
				<input class="form-control text-right" type="number" step="0.01" value="'+ item_price +'" placeholder="0.00" id="price-'+ id +'" />\
			</td>\
			<!--<td class="text-right">\
				<input class="form-control text-right" type="number" step="0.01" placeholder="0.00" id="total-'+ id +'" value="'+ item_price +'" />\
			</td>-->\
			<td class="text-right">\
				<button id="remove-'+ id +'" data-row="'+ id +'" class="btn btn-sm btn-danger remove">\
					<span class="fa fa-close"></span>\
				</button>\
			</td>\
		</tr>\
	');
	
	id += 1;
	
	$("#search-box-items").html("");
	$("#search-box").hide();
	$("#search-item").val("");
});

var package = {};

function sum_up(){
	var total = 0;
	package = {
		name: $("#name").val(),
		description: $("#description").val(),
		price: $("#total").val(),
		code: $("#code").val(),
		sku: $("#sku").val(),
		items: []
	};
	
	if(package.name.length < 1){
		alert("Package name & code is required.");
		return;
	}
	
	if(package.code.length < 1){
		alert("Package name & code is required.");
		return;
	}
	
	$("#item-list").children("tr").each(function(x){
		var row = $(this).data("row");
		var item_name = $("#item-" + row).val();
		var item_id = $("#item-id-" + row).val();
		var item_price = parseFloat($("#price-" + row).val());
		var item_quantity = parseInt($("#quantity-" + row).val());
		
		package["items"].push({
			name: item_name,
			id: item_id,
			price: item_price,
			quantity: item_quantity
		});
		
		// total += (item_price * item_quantity);
	});
	
	// $("#total").val(total);
}

$("#save").on("click", function(){
	sum_up();
	
	// console.log(package);
	
	// return;
	$.ajax({
		url: PORTAL + "webservice/items/update-package/$i->i_key",
		method: "POST",
		data: {
			json: JSON.stringify(package)
		},
		dataType: "text"
	}).done(function(res){
		// console.log(res);
		
		var o = JSON.parse(res);
		
		if(o.status == "success"){
			alert(o.message);
			window.location = PORTAL + "inventories/edit-package/" + o.data.id
		}else{
			alert(o.message);
		}
	});
});
</script>
SCRIPT
);
}
