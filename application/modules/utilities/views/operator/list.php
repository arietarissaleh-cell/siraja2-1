<div class="container-fluid">
	<div class="block-header">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-12">
				<h2>Administrator User (Setting User)</h2>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.html"><i class="fa fa-dashboard"></i></a></li>
					<li class="breadcrumb-item">Utility</li>
					<li class="breadcrumb-item active">Administrator User (Setting User)</li>
				</ul>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-12">
				<div class="d-flex flex-row-reverse">
					<div class="page_action">
						<button type="button" class="btn btn-secondary"><i class="fa icon-reload"></i></button>
						<button type="button" class="btn btn-secondary"><i class="fa icon-plus"></i></button>
						<button type="button" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Export Excel</button>
					</div>
					<div class="p-2 d-flex">

					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row clearfix">
		<div class="col-lg-12">
			<div class="card">
				<div class="header">
					<h2>List User</h2>
				</div>
				<div class="body">
					<div class="table-responsive">
						<table class="table table-striped mb-0" id="tabelnya" style="width: 100%;">
							<thead class="table-light">
								<tr>
									<th>#</th>
									<th>Username</th>
									<th>NIK</th>
									<th>Unit</th>

									<th>Action</th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		var table = $('#tabelnya').DataTable({
			language: {
				url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/id.json'
			},
			// "lengthMenu": [ 1, 2, 3, 4, 5 ],
			"processing": true,
			"serverSide": true,
			"order": false,
			"ajax": {
				"url": "<?php echo site_url('utilities/operator/ajax_list') ?>",
				"type": "POST"
			},

			"columnDefs": [{
					"targets": [0, 3, 1],
					"orderable": false,
				},
				{
					"targets": [1],
					"orderData": [1, 3],
				},
				{
					"targets": [3],
					"orderData": [3, 1],
				}
			],
		});


	});
</script>
<!--
Author: Gifar ALFAQIH
Author URL: 
19/03/21
-->