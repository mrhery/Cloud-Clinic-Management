<div class="card">
	<div class="card-header">
		<span class="fa fa-calendar"></span> Appointments 
		
		<a href="<?= PORTAL ?>appointments/create" class="btn btn-sm btn-primary">
			<span class="fa fa-plus"></span> Create new Appointment
		</a>
	</div>
	
	<div class="card-body">
		<button class="btn btn-sm btn-dark">
			Today
		</button>
		
		<button class="btn btn-sm btn-secondary">
			Now
		</button>
		
		<button class="btn btn-sm btn-secondary">
			Tomorrow
		</button>
		
		<button class="btn btn-sm btn-secondary">
			This Week
		</button>
		
		<button class="btn btn-sm btn-secondary">
			Pending
		</button>
		
		<table class="table table-hover">
			<thead>
				<tr>
					<th class="text-center">No</th>
					<th class="text-center">Datetime</th>
					<th class="">Appointment</th>
					<th class="text-center">Status</th>
					<th class="text-right">:::</th>
				</tr>
			</thead>
			
			<tbody>
				<tr>
					<td class="text-center">No</td>
					<td class="text-center">14 Jun 2023 10:30 AM</td>
					<td>
						<strong>Customer</strong><br />
						Ahmad Khairi Aiman Mohammad Zaki (950724-01-5603)<br /><br />
						
						<strong>Description</strong><br />
						Fever
					</td>
					<td class="text-center">Approved</td>
					<td class="text-right">
						<button class="btn btn-sm btn-warning">
							<span class="fa fa-edit"></span> Edits
						</button>	
					</td>
				</tr>
				
				<tr>
					<td class="text-center">No</td>
					<td class="text-center">14 Jun 2023 12:30 AM</td>
					<td>
						<strong>Customer</strong><br />
						Khairul Anwar Sulaiman (900422-01-7605)<br /><br />
						
						<strong>Description</strong><br />
						Covid Test
					</td>
					<td class="text-center">Pending</td>
					<td class="text-right">
						<button class="btn btn-sm btn-warning">
							<span class="fa fa-edit"></span> Edits
						</button>	
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>