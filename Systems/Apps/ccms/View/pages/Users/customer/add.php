<style>
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

.radio-spacing {
    margin-right: 20px; /* Adjust spacing */
}
</style>

<div class="card">
    <div class="card-header">
        <a href="<?= PORTAL ?>dashboard" class="btn btn-sm btn-primary mr-2">
            <span class="fa fa-arrow-left"></span> Back
        </a>
        Add New Patient
    </div>
    
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    Name:
                    <input type="text" placeholder="Name" name="name" class="form-control" required /> <br>
                </div>

                <div class="col-md-6">
                    Email:
                    <input type="email" placeholder="Email" name="email" class="form-control" required /> <br>
                </div>

				<div class="col-md-6">
					Phone:
					<input type="text" placeholder="Phone" name="phone" class="form-control" pattern="\d{11,12}" required oninput="validatePhone(this)" /><br />
				</div>


                <div class="col-md-6">
                    IC:
                    <input type="text" placeholder="IC / Passport" name="ic" class="form-control" required /> <br>
                </div>

                <div class="col-md-6">
                    Address:
                    <textarea type="text" placeholder="Address" name="address" rows="3" class="form-control" required></textarea>
                    <br>
                </div>

                <div class="col-md-6">
                    <label>Citizenship Status:</label>
                    <div class="form-check d-flex align-items-center justify-content-start ms-1">
                        <div class="d-flex align-items-center me-4" style="margin-right: 28px;">
                            <input class="form-check-input me-2" type="radio" name="citizenship" value="citizen" required>
                            <label class="form-check-label">Citizen</label>
                        </div>
                        <div class="d-flex align-items-center">
                            <input class="form-check-input me-2" type="radio" name="citizenship" value="non_citizen" required>
                            <label class="form-check-label">Non-Citizen</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 text-center">
					<?php
						Controller::form(
						"customer",
						[
							"action" => "create"
						]
					);
					?>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <span class="fa fa-save"></span> Save
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
function validatePhone(input) {
    let value = input.value.replace(/\D/g, ''); // Remove non-numeric characters

    // Check prefix and set the max length accordingly
    if (value.startsWith('011')) {
        input.setAttribute("maxlength", "11"); // 011 numbers must have 11 digits
    } else if (/^01[2-9]/.test(value)) {
        input.setAttribute("maxlength", "10"); // Other 01X numbers must have 10 digits
    } else {
        input.setAttribute("maxlength", "11"); // Default case
    }

    // Ensure input is trimmed to the correct length
    if (value.startsWith('011') && value.length > 11) {
        value = value.substring(0, 11);
    } else if (/^01[2-9]/.test(value) && value.length > 10) {
        value = value.substring(0, 10);
    }

    input.value = value; // Update the field
}
</script>