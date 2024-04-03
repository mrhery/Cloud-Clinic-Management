<?php

switch(url::get(2)){
	case "create":
		$data = Input::post("data", false);
		
		try {
			$obj = json_decode($data);
			
			if(isset(
				$obj->customer,
				$obj->no,
				$obj->remark,
				$obj->date,
				$obj->total,
				$obj->paid,
				$obj->doc_type,
				$obj->items
			)){
				$c = customers::getBy(["c_ukey" => $obj->customer]);

				if(count($c)){
					$c = $c[0];
					
					if(is_array($obj->items) && count($obj->items) > 0){
						$skey = F::uniqKey("sale_");
						
						$status = "nil";
						
						if((double)$obj->paid < (double)$obj->total){
							$status = "partial";
						}
						
						if((double)$obj->paid >= (double)$obj->total){
							$status = "paid";
						}
						
						if((double)$obj->paid < 1 && (double)$obj->total > 0){
							$status = "unpaid";
						}
						
						$summary = "";
						$type = "";
						
						switch($obj->doc_type){
							default:
							case "invoice":
								$type = "in";
								$obj->doc_type = "invoice";
							break;
							
							case "credit_note":
								$type = "in";
								$obj->doc_type = "credit_note";
							break;
							
							case "debit_note":
								$type = "out";
								$obj->doc_type = "debit_note";
							break;
						}
						
						sales::insertInto([
							"s_client"	=> $c->c_id,
							"s_doc"		=> $obj->no,
							"s_date"	=> date("d-M-Y", strtotime($obj->date)),
							"s_time"	=> F::GetTime(),
							"s_key"		=> $skey,
							"s_clinic"	=> Session::get("clinic")->c_id,
							"s_user"	=> Session::get("user")->u_id,
							"s_paid"	=> (double)$obj->paid,
							"s_total"	=> (double)$obj->total,
							"s_remark"	=> $obj->remark,
							"s_status"	=> $status,
							"s_summary"	=> $summary,
							"s_type"	=> $obj->doc_type
						]);
						
						$s = sales::getBy(["s_key" => $skey, "s_clinic" => Session::get("clinic")->c_id]);
						
						if(count($s) > 0){
							$s = $s[0];
							
							foreach($obj->items as $item){
								$i = items::getBy(["i_key" => $item->id, "i_clinic" => Session::get("clinic")->c_id]);
								
								if(count($i) > 0){
									$i = $i[0];
								}else{
									$ikey = F::uniqKey("item_");
									$type = "product";
									
									if($item->qty <= 1){
										$type = "service";
									}
									
									items::insertInto([
										"i_key"			=> $ikey,
										"i_name"		=> $item->item_name,
										"i_cost"		=> (double)$item->cost,
										"i_quantity"	=> $item->qty,
										"i_clinic"		=> Session::get("clinic")->c_id,
										"i_user"		=> Session::get("user")->u_id,
										"i_type"		=> $type
									]);
									
									$i = items::getBy(["i_key" => $ikey]);
									
									if(count($i) > 0){
										$i = $i[0];
										define("NEW", true);
									}else{
										unset($i);
									}
								}
								
								if(isset($i)){
									$summary .= $i->i_name . " x" . $item->qty . "<br />";
									
									if($type == "in"){
										item_inventory::insertInto([
											"ii_item"		=> $i->i_id,
											"ii_date"		=> date("d-M-Y", strtotime($obj->date)),
											"ii_time"		=> F::GetTime(),
											"ii_quantity"	=> $item->qty,
											"ii_description"=> $item->remark,
											"ii_cost"		=> $item->cost,
											"ii_user"		=> Session::get("user")->u_id,
											"ii_clinic"		=> Session::get("clinic")->c_id
										]);
										
										if(!defined("NEW")){
											$ntotal = $i->i_quantity + $item->qty;
											
											items::updateBy(["i_key" => $i->i_key], ["i_quantity" => $ntotal]);
										}
									}else{
										item_inventory::insertInto([
											"ii_item"		=> $i->i_id,
											"ii_date"		=> date("d-M-Y", strtotime($obj->date)),
											"ii_time"		=> F::GetTime(),
											"ii_quantity"	=> (-1 * $item->qty),
											"ii_description"=> $item->remark,
											"ii_cost"		=> $item->cost,
											"ii_user"		=> Session::get("user")->u_id,
											"ii_clinic"		=> Session::get("clinic")->c_id
										]);
										
										if(!defined("NEW")){
											$ntotal = $i->i_quantity - $item->qty;
											
											items::updateBy(["i_key" => $i->i_key], ["i_quantity" => $ntotal]);
										}
									}
									
									sale_item::insertInto([
										"si_purchase"		=> $s->s_id,
										"si_clinic"			=> Session::get("clinic")->c_id,
										"si_item"			=> $i->i_id,
										"si_quantity"		=> $item->qty,
										"si_cost"			=> (double)$item->cost,
										"si_total_cost"		=> (double)$item->total,
										"si_remark"			=> $item->remark
									]);
								}
							}
							
							sales::updateBy(["s_key" => $s->s_key], ["s_summary" => $summary]);
							
							die(json_encode([
								"status"	=> "success",
								"message"	=> "Sale record has been created.",
								"data"		=> [
									"pid"	=> $s->s_key
								]
							]));
						}else{
							die(json_encode([
								"status" 	=> "error",
								"message"	=> "Fail creating Sale records."
							]));
						}
					}else{
						die(json_encode([
							"status" 	=> "error",
							"message"	=> "Sale items is not valid."
						]));
					}
				}else{
					die(json_encode([
						"status" 	=> "error",
						"message"	=> "Client information is not valid."
					]));
				}
			}else{
				die(json_encode([
					"status"	=> "error",
					"message"	=> "Insufficient request parameters."
				]));
			}
		} catch(Exception $ex) {
			die(json_encode([
				"status"	=> "error",
				"message"	=> "Failed processing request from server." . $ex->getMessage()
			]));
		}
	break;

	case "print":

	 $s = sales::getBy(["s_key" => url::get(3), "s_clinic" => Session::get("clinic")->c_id]);

?>
		<!DOCTYPE html>
			<html lang="en">
			<head>
				<meta charset="UTF-8">
				<meta name="viewport" content="width=device-width, initial-scale=1.0">
				<title>Print Document</title>
				<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
				<style>
					@page {
						size: A4 portrait;
						margin: 0;
					}
					body {
						margin: 0;
						font-family: Arial, sans-serif;
					}
					.container {
						width: 21cm;
						height: 29.7cm;
						margin: auto;
						padding: 1cm;
						background-color: white;
					}
					.table th,
					.table td {
						border-width: 1px;
						border-color: black;
					}
				</style>
			</head>
			<body>
				<div class="container">
					<?php
						if(count($s) > 0){
							$s = $s[0];
					?>
						<div class="row">
							<div class="col-md-3 mx-auto text-center">
								<img src="<?= PORTAL ?>assets/images/clinic/<?= Session::get("clinic")->c_logo ?>" class="img img-responsive" width="100%" alt="Tiada Gambar dijumpai" /><br />
							</div>
							<div class="col-md-9 mx-auto">
								<h1><?= Session::get("clinic")->c_name ?></h1>
								<?= Session::get("clinic")->c_regno ?> <br>
								<?= Session::get("clinic")->c_address ?> <br>
								NO. Phone : <?= Session::get("clinic")->c_phone ?> | E-mail : <?= Session::get("clinic")->c_email ?>
							</div>
							<div class="col-md-6 pos-rel mt-4">
								<strong>For (Customer):</strong><br />
								<?php
									$c = customers::getBy(["c_id" => $s->s_client]);

									if(count($c) > 0){
										$c = $c[0];
									?>
									<strong><?= $c->c_name ?></strong><br />
									<span><?= $c->c_address ?></span><br />
									<span><?= $c->c_phone ?> | <?= $c->c_email ?></span><br />
									<?php
									}else{
										unset($c);
										echo "-";
									}
								?>

								<br />
								<strong>Document No:</strong><br />
								<?= $s->s_doc ?><br /><br />

								<strong>Remarks:</strong>
								<?= $s->s_remark ?><br />
							</div>

							<div class="col-md-6 mt-4">
								<div class="row">
									<div class="col-md-6">
										<strong>Doc. Type:</strong>
										<?php
											switch($s->s_type){
												default:
												case "invoice":
													echo "Invoice";
												break;

												case "credit_note":
													echo "Credit Note";
												break;

												case "debit_note":
													echo "Debit Note";
												break;
											}
										?><br />
									</div>
									<div class="col-md-6">
										<strong>Date:</strong> <?= $s->s_date ?><br />
										<br />
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<strong>Total (RM):</strong><br />
										<?= number_format($s->s_total, 2) ?><br /><br />
									</div>

									<div class="col-md-6">
										<strong>Paid (RM):</strong><br />
										<?= number_format($s->s_paid, 2) ?><br /><br />
									</div>
								</div><br />

								<strong>Status:</strong> <?= $s->s_status ?><br />
								<br />

							</div>

							<div class="col-md-12 mb-3">
								<hr />

								<table class="table table-hover table-bordered table-fluid">
									<thead>
										<tr>
											<th>Item</th>
											<th class="text-right" width="10%">Cost</th>
											<th class="text-center" width="10%">Qty</th>
											<th class="text-right" width="10%">Total</th>
											<th class="text-right" width="30%">Remark</th>

										</tr>
									</thead>

									<tbody>
									<?php
										foreach(sale_item::getBy(["si_purchase" => $s->s_id]) as $si){
											$i = items::getBy(["i_id" => $si->si_item]);

											if(count($i) > 0){
												$i = $i[0];
									?>
										<tr>
											<td class="pos-rel">
												<?= $i->i_name ?>
											</td>

											<td>
											<?= number_format($si->si_cost, 2) ?>
											</td>

											<td>
												<?= $si->si_quantity ?>
											</td>

											<td>
											<?= number_format($si->si_total_cost, 2) ?>
											</td>

											<td>
												<?= $si->si_remark ?>
											</td>
										</tr>
									<?php
											}
										}
									?>
									</tbody>
								</table>
							</div>
						</div>
						<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
						<script src="https://cdn.jsdelivr.net/npm/pdf-lib/dist/pdf-lib.min.js"></script>
						<script>
							window.addEventListener('load', async function() {
								const container = document.querySelector('.container');
								const canvas = await html2canvas(container, {
									scale: 3,
									logging: true,
									dpi: 90000,
								});

								// Create a new PDF document
								const pdfDoc = await PDFLib.PDFDocument.create();

								// Add a new page to the document
								const page = pdfDoc.addPage([canvas.width, canvas.height]);

								// Draw the canvas onto the PDF page
								const pngImage = await pdfDoc.embedPng(canvas.toDataURL('image/png'));
								page.drawImage(pngImage, {
									x: 0,
									y: 0,
									width: canvas.width,
									height: canvas.height,
								});

								const pdfBytes = await pdfDoc.save();

								// Convert bytes to a Blob
								const pdfBlob = new Blob([pdfBytes], {
									type: 'application/pdf'
								});

								// Create a temporary URL for the Blob
								const pdfUrl = URL.createObjectURL(pdfBlob);

								// Open the PDF in a new tab
								window.open(pdfUrl, '_blank');
							});
						</script>

						<!-- <script>
							// Add event listener to "Print PDF" button
							document.getElementById('print-pdf').addEventListener('click', function () {
								// Capture content inside the <div class="container"> and convert to PNG
								html2canvas(document.querySelector('.container'), {
									scale: 2 // Adjust scale factor if needed
								}).then(function(canvas) {
									// Convert canvas to PNG image data
									var imgData = canvas.toDataURL('image/png');
									
									// Create a new anchor element
									var downloadLink = document.createElement('a');
									downloadLink.href = imgData;
									downloadLink.download = 'document.png'; // Set the filename
									downloadLink.click(); // Trigger the download
								});
							});
						</script> -->

					<?php
						}else{
							new Alert("error", "No purchase record found.");
						}
					?>
				<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
			</body>
			</html>
<?php
	break;
}