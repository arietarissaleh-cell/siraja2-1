<style>
  #image-container {
            position: relative;
        }
        
        #zoom-button {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 5px 10px;
            background-color: #333;
            color: #fff;
            cursor: pointer;
        }
</style>
<script>

$(document).ready(function() {
		$("#approve").click(function(){
			proses_approve();

		});
	});



	function proses_approve() {
		Swal.fire({
			title: 'Approve ?',
			showDenyButton: false,
			showCancelButton: true,
			confirmButtonText: 'Approve',
		}).then((result) => {
			if (result.isConfirmed) {
				var pesan = 'Proses Penyimpanan';
				$('#save_data').hide();
				url1 = "<?php echo site_url('validasi_it/validasi_it/approve')?>";
				$.ajax({
					url : url1,
					type: "POST",
					data: $('#submit_approve').serialize(),
					dataType: "JSON",
					beforeSend: function() {
						Swal.fire({
							title: 'Proses Approve',
							html: 'Mohon Menunggu ... ',
							allowEscapeKey: false,
							allowOutsideClick: false,
							didOpen: () => {
								Swal.showLoading()
							}
						});
					}, 
					success: function(data){
						console.log();
						if (data['sukses'] == 1){
							setTimeout(function(){
								swal.close();
								Swal.fire(data['pesan'], '', 'success');
								loadMainContent('validasi_it');
							},1000);
						}else if(data['sukses'] == 0){
							setTimeout(function(){
								swal.close();
								Swal.fire(data['pesan'], '', 'error');
							},1000);
						}
					},
					error: function(data){
						setTimeout(function(){
							swal.close();
							Swal.fire(data['pesan'], '', 'error');
						},1000);
					}	
				});
			} else if (result.isDenied) {
				Swal.fire('Changes are not saved', '', 'info')
				$('#approve_data').show();
			}
		})
	}




</script>

<div class="card">
	<div class="row mb-2">
       <div class="col-sm-4">
            <div class="row">
				<h2 class="mb-3"><?=$title?></h2> 
			</div>
       </div>
       <div class="col-sm-8">
            <div class="text-sm-end">
                <div class="btn-group me-2 mb-2 mb-sm-0">
					<button type="button" class="btn btn-primary waves-light waves-effect dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
						<i class="fas fa-undo-alt"></i>  
					</button>
				</div>
			</div>
       </div><!-- end col-->
    </div>

    <div class="card-body">		
		<h2 class="mb-3"><?=$title?></h2> 	
		
		
		<div class="table-responsive" style="margin-top: 20px;">
			<table class="table table-striped mb-0" id="tabelnya" style="width: 100%;">
									
				<thead class="table-light">
					<tr>
						<th>No</th>
						<th>Tanggal</th>
						<th>Jumlah Foto</th>
						<th>Status</th>
						<th>Detail</th>
						
					</tr>
				</thead>
				
			</table>
			<br>
			<br>
			
			
			<br>
			<br>
			<br>
			<br>
		</div>
	</div>
</div>

<script>
  function openZoomModal(imgSrc) {
        var zoomedImg = document.getElementById('zoomedImg');
        zoomedImg.src = imgSrc;

        var zoomModal = new bootstrap.Modal(document.getElementById('zoomModal'));
        zoomModal.show();
    }
	

	function status_update(){
		$('#submit').submit();
	}

	
	$(document).ready(function(){
		$('#submit').submit(function(e){
			var status_kerapatan = $('#status_kerapatan');
			var id_drone = $('#id_drone');
			
			if (status_kerapatan.val() == "") {
				alert("Status Harus DIpilih");
				return false;
			}else{
				 var formData = new FormData($('#submit')[0]);
				// formData.append('lampiran', $('input[type=file]')[0].files[0]);
				e.preventDefault(); 
				$.ajax({
					url:'<?php echo base_url();?>validasi_it/validasi_it/update_status',
					type:"POST",
					data: formData, 
					processData:false,
					contentType:false,
					cache:false,
					async:false,
					dataType: "json",
					success: function(data){
						if (data['sukses']==1){
							Swal.fire('GAGAL', '', 'warning')
						}else{
							
							Swal.fire(data['pesan'], '', 'success')
						}
					}
				});
			}
		}); 
	});
	
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
						"url": "<?php echo site_url('validasi/ajax_list')?>",
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
		
		
<div class="modal fade" id="zoomModal" tabindex="-1" role="dialog" aria-labelledby="zoomModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="zoomModalLabel">Zoom Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="zoomedImg" src="" alt="Foto" style="width: 100%;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Nama Kebun</h5>
				<br>
				<input class="form-control" id="nama_kebun" name="t_nama_kebun" type="text" value="" readonly>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form class="form-horizontal margin-none" id="submit" autocomplete="off" novalidate="novalidate" enctype="multipart/form-data"> 
				<div class="modal-body"> 
				<div class="row">
					<input class="form-control" id="id_kebun_problem" name="t_id_kebun_problem" type="hidden" >
					<label>Unit : </label>
					<input class="form-control" id="nama_unit" name="t_nama_unit" type="text" value="" readonly>
					<label>Status Kerapatan</label>
					<label>Status Kerapatan</label>
					<div class="col-md-12">
						<select class="form-control select2" id="status_kerapatan" name="status_kerapatan" style="width: 100%;">
							<option value=""> - Pilih - </option>
							<option value="1">Baik</option>
							<option value="2">Sedang</option>
							<option value="3">Kurang</option>
						</select>
					</div>
					<br>
					<br>
					<label>Keterangan</label>
					<div class="col-md-12">
						<textarea class="form-control" id="keterangan" name="t_keterangan" type="text" rows="5"></textarea><br>
					</div>
				</div>
											
										</div>
									</form>
									<div class="modal-footer">
										<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
										<a href="javascript:void(0);" class="btn btn-success" onClick="status_update();"><i class="fa fa-floppy-o"></i> Simpan</a>
									</div>
								</form>
							</div>
						</div>
					</div>			
