<!--<script type="text/javascript" src="/path/to/jquery-latest.js"></script> 
<script type="text/javascript" src="/path/to/jquery.tablesorter.js"></script> -->
<script src="<?= base_url();?>assets/js/bootbox.js"></script>
<script src="<?= base_url();?>assets/js/bootbox.min.js"></script>
<!--<script src="https://cdn.jsdelivr.net/gh/makeusabrew/bootbox@f3a04a57877cab071738de558581fbc91812dce9/bootbox.js"></script>
-->

<script>
	/* 	$(document).ready(function(){
		$("#unit").select2({
			placeholder: "-- Pilih --",
			allowClear: true
		});
	
	}); */
	
	/* function contentFilterShow()
	{
		//-------- baris scrip yg lama ------
		//contentHide();
		//$('#tabFilter').show();
		//$('#content-filter').show();
		//$('#lbl_title').text('Filter');
		//-----------------------------------
		
		showProgres();
		$.post(site_url+'mon_qc_st/mon_qc_st/filter'
				,{}
				,function(result) {
					//contentHide();
					$('#tabFilter').show();
					$('#lbl_title').text('Filter');
					$('#content-filter').html(result);
					
				}					
				,"html"
			);
		
		hideProgres();	
		
	} */
	
	
	
</script>

<div class="page-content">
	<div class="container-fluid">
        <div class="card-body">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-body">
						<div class="row mb-2">
                            <div class="col-sm-4">
                                <div class="row">
									<h2 class="mb-3">List In Progress</h2> 
								</div>
                            </div>
                            <div class="col-sm-8">
                                <div class="text-sm-end">
								
									<div class="btn-group me-2 mb-2 mb-sm-0">
										<button type="button" class="btn btn-primary waves-light waves-effect dropdown-toggle" onClick="loadMainContent('task_manager/task_manager/index')">
											<i class="fas fa-arrow-alt-circle-left"></i>  
										</button>
									</div>
									
                                    <div class="btn-group me-2 mb-2 mb-sm-0">
										<button type="button" class="btn btn-primary waves-light waves-effect dropdown-toggle" onClick="loadMainContent('proses_tl/proses_tl/index')">
											<i class="fas fa-undo-alt"></i>  
										</button>
									</div>
									
									<div class="btn-group me-2 mb-2 mb-sm-0">
										
									</div>
								</div>
                            </div><!-- end col-->
                        </div>
										
						<div id="tabFilter" class="widget-body padding-bottom-none">
											
						</div>


						<div class="table-responsive" style="margin-top: 20px;">
							<table class="table table-striped mb-0" id="tabelnya">
								<thead class="table-light">
									<tr>
										<th>No</th>
										<th>Kode</th>
										<th>Tanggal</th>
										<th>User</th>
										<th>Permintaan/Permasalahan</th>
										
										
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
</div> 

	<script type="text/javascript">
			$(document).ready(function(){
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
						"url": "<?php echo site_url('proses_tl/ajax_list')?>",
						"type": "POST",
						"data": function (data) {
							var unit = $('#unit').val();
							data.unit = unit;
							var mt = $('#mt').val();
							data.mt = mt;
						},
					},
					"lengthMenu": [
						[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]
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



