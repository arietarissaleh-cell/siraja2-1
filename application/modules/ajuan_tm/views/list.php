<div class="container-fluid">
	<div class="block-header">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-12">
				<h2>Permintaan</h2>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.html"><i class="fa fa-dashboard"></i></a></li>
					<li class="breadcrumb-item">Teknologi Informasi</li>
					<li class="breadcrumb-item active">Permintaan</li>
				</ul>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-12">
				<div class="d-flex flex-row-reverse">
					<div class="page_action">
						<button type="button" class="btn btn-secondary" onClick="loadMainContent('task_manager/task_manager/index')"><i class="fa fa-arrow-left"></i></button>
						<button type="button" class="btn btn-secondary" onClick="loadMainContent('ajuan_tm/ajuan_tm/index')"><i class="fa icon-reload"></i></button>
						<button type="button" class="btn btn-secondary" onClick="loadInput('ajuan_tm/input')"><i class="fa icon-plus"></i></button>
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
					<h2>List Task Request</h2>
				</div>
				<div class="body">
					<div class="table-responsive" style="margin-top: 20px;">
						<table class="table table-striped mb-0" id="tabelnya" style="width: 100%;">
							<thead class="table-light">
								<tr>
									<th>No</th>
									<th>Kode</th>
									<th>Tanggal</th>
									<th>User</th>
									<th>Permintaan/Permasalahan</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
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
			responsive: true,
			"processing": true,
			"searchable": true,
			"Paginate": true,
			"serverSide": true,
			"ordering": false,
			"ajax": {
				"url": "<?php echo site_url('ajuan_tm/ajax_list') ?>",
				"type": "POST",
				"data": function(data) {
					var unit = $('#unit').val();
					data.unit = unit;
					var mt = $('#mt').val();
					data.mt = mt;
				},
			},
			"lengthMenu": [
				[10, 25, 50, 100, -1],
				[10, 25, 50, 100, "All"]
			],

		});

		$('#unit').select2();
		$('#mt').select2();

		$('#unit').on('change', function() {
			var selectedValues = $(this).val();
			table.draw();
		});

		$('#unit').on('select2:unselect', function() {
			$('#unit').val(null).trigger('change');
		});

		$('#mt').on('change', function() {
			var selectedValues = $(this).val();
			table.draw();
		});

		$('#mt').on('select2:unselect', function() {
			$('#mt').val(null).trigger('change');
		});
	});
</script>










<!--
Author: Ade
Author URL: 
19/03/21
-->