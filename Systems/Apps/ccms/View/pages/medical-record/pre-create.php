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
</style>

<h4>Create new Medical Record</h4>


<div class="row mt-3">
	<div class="col-md-6">
		<b>Search patient information:</b>
		<input type="text" class="form-control" id="search-ic" placeholder="Search..." />
						
		<div id="ic-search-list"></div>
	</div>
</div>

