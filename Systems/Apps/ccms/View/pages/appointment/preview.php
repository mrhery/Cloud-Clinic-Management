<?php
$a = appointments::getBy(["a_ukey" => url::get(3)]);
?>

<style>
.modal-content {
    padding: 20px;
}
</style>

<div class="card">
    <div class="card-header">
       <a href="<?= PORTAL ?>appointment/list" class="btn btn-primary btn-sm">
            <span class="fa fa-arrow-left"></span> Back
        </a>
        Appointment Records
    </div>
    <div class="card-body">
    <?php
        if(count($a) > 0){
            $a = $a[0];
        ?>
        <div class="text-right">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#previewModal">
                Preview
            </button>
        </div>

        <!-- Preview Modal -->
        <div class="modal fade" id="previewModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Appointment Preview</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <strong>Patient:</strong><br />
						<?php
							$c = customers::getBy(["c_id" => $c->a_customer]);
							
							if(count($c) > 0){
								$c = $c[0];
						?>
                        <strong>Doctor:</strong> <?= $c->a_attendee ?><br />
                        <strong>Date:</strong> <?= $c->a_date ?><br />
                        <strong>Time:</strong> <?= $c->a_time ?><br />
                        <strong>Clinic:</strong> <?= $c->a_clinic ?><br />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <?php
        } else {
            new Alert("error", "No appointment record found.");
        }
    ?>
	<?php
		}else{
			new Alert("error", "No appointment record found.");
		}
	?>
    </div>
</div>

<!-- Bootstrap and jQuery scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
