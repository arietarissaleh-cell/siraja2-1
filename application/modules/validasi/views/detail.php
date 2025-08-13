<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
		<h2 class="mb-3"><?=$title?> Tanggal : <?=$tanggal?></h2> 	
		<div class="table-responsive" style="margin-top: 20px;">
			<table class="table table-striped mb-0" >
				<thead class="table-light">
					<tr>
						<th>No</th>
						<th>Nama Unit</th>
						<th>No Petak</th>
						<th>Nama Kebun</th>
						<th>Foto</th>
						<th colspan="2">Status</th>
						
					</tr>
				</thead>
				<tbody>
				
					<?php
					$no = 0;
					foreach ($drone as $key) {
					$no++;
					$foto ='http://e-siraja.rajawali2.co.id/siRajaDrone/doc_drone/'.$key['foto'];
					$dokumen ='http://e-siraja.rajawali2.co.id/siRajaDrone/doc_drone/viewerjs-0.5.8/ViewerJS/#../../'.$key['foto'];
					?>
						<tr>
							<td><?=$no;?></td>
							<td><input class="form-control span12" id="fid_unit" name="t_fid_unit[]" type="hidden" value="<?=$key['fid_unit']; ?>"><?=$key['nama_unit'];?></td>
							<td><input class="form-control span12" id="no_petak" name="t_no_petak[]" type="hidden" value="<?=$key['no_petak']; ?>"><?=$key['no_petak'];?></td>
							<td><input class="form-control span12" id="nama_kebun" name="t_nama_kebun[]" type="hidden" value="<?=$key['nama_kebun']; ?>"><?=$key['nama_kebun'];?></td>
							<td>
							<a href='<?=$foto?>' data-lightbox='<?=$foto?>' data-title='<?=$key['nama_kebun'];?>'>
  								<img class='example-image img-thumbnail img-fluid' src='<?=$foto?>' alt='desc' style='width: 100px; height: 100px;'>
  							</a>
							<!--<img src="<?=$foto?>" width="20%" height="20%" onclick="openZoomModal('<?=$foto?>')"><br>
								-->
							</td>
							<td>
							
							<a href="#" type="button" id="btn_slik_<?=$key['id_drone']?>" onclick="panggil_debitur(<?=$key['id_drone']?>)" class="btn btn-success waves-effect waves-light btn-sm"><?= ($key['status_kerapatan'])?></a>
							<!--<button type="button" class="btn btn-primary btn-lg"  data-toggle="modal" data-target="#staticBackdrop1" >
							  
							</button>-->

							</td>
							<td>
							<input class="form-control span12" id="rayon" name="t_rayon[]" type="hidden" value="<?=$key['kode_rayon_ecadong']; ?>">
							<input class="form-control span12" id="id_drone" name="t_id_drone[]" type="hidden" value="<?=$key['id_drone']; ?>">
							<input class="form-control span12" id="wilayah" name="t_wilayah[]" type="hidden" value="<?=$key['kode_wilayah_ecadong']; ?>">
							</td>
						</tr>
					
					<?php } ?>
				</tbody>
			</table>
			<br>
			<br>
			
			<form class="form-horizontal margin-none" enctype="multipart/form-data"   id="submit_approve" method="get" autocomplete="off" novalidate="novalidate">
			<p align="right">
				<?php $tgl = str_replace("-","_",$tanggal); ?>
				<input class="form-control" id="tanggal" name="t_tanggal" type="text" value="<?=$tgl?>">
				<a  id="approve" type="submit" class="btn btn-info btn-rounded waves-effect waves-light"> Accept All <i class="fas fa-check-circle "></i></a>
						
			</form>
			<br>
			<br>
			<br>
			<br>
		</div>
	</div>
</div>

<script>
 
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


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        
        
		
				<h5 class="modal-title" id="staticBackdropLabel">Nama Kebun</h5>
				<br>
				<input class="form-control" id="nama_kebun_modal" name="t_nama_kebun" type="text" value="" readonly>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			
	  </div>
	  
      <div class="modal-body">
       <form class="form-horizontal margin-none" id="submit_modal" autocomplete="off" novalidate="novalidate" enctype="multipart/form-data"> 
				<div class="modal-body"> 
					<div class="row">
						<input class="form-control" id="id_drone_modal" name="t_id_drone" type="text" >
						<input class="form-control" id="tanggal_modal" name="t_tanggal_modal" type="text" value="<?=$tanggal?>" >
						<label>Status Kerapatan</label>
						<div class="col-md-12">
							<select class="form-control select2" id="status_kualitas" name="status_kerapatan" style="width: 100%;">
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
      </div>
      <div class="modal-footer">
	  <button type="button" class="btn btn-light"  data-dismiss="modal" aria-hidden="true">Close</button>
        
				<a href="javascript:void(0);" class="btn btn-success" onClick="status_update();"><i class="fa fa-floppy-o"></i> Simpan</a>
      </div>
    </div>
  </div>
</div>		
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
				url1 = "<?php echo site_url('validasi/validasi/approve')?>";
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
								loadMainContent('validasi');
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



 function openZoomModal(imgSrc) {
        var zoomedImg = document.getElementById('zoomedImg');
        zoomedImg.src = imgSrc;

        var zoomModal = new bootstrap.Modal(document.getElementById('zoomModal'));
        zoomModal.show();
    }
	
	 
	function status_update(){
		alert('Hai');
		//$('#submit_modal').submit();
		var status_kerapatan = $('#status_kualitas');
			var id_drone = $('#id_drone_modal');
			var tanggal_modal = $('#tanggal_modal');
			//alert("Status Harus DIpilih");
			
			if (status_kerapatan.val() == "") {
				alert("Status Harus DIpilih");
				return false;
			}else{
				 var formData = new FormData($('#submit_modal')[0]);
				// formData.append('lampiran', $('input[type=file]')[0].files[0]);
				//e.preventDefault(); 
				$.ajax({
					url:'<?php echo base_url();?>validasi/validasi/update_status',
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
							
							$('#myModal').modal('hide');
							$(".modal-backdrop").remove();
							//swal.close();
							Swal.fire(data['pesan'], '', 'success');
						//	loadMainContent('validasi/detail/'+tanggal_modal);
						}
					}
				});
			}
	}

	
	$(document).ready(function(){
		$('#submit_modal').submit(function(e){
			var status_kerapatan = $('#status_kualitas');
			var id_drone = $('#id_drone_modal');
			
			alert("Status Harus DIpilih");
			
			if (status_kerapatan.val() == "") {
				alert("Status Harus DIpilih");
				return false;
			}else{
				 var formData = new FormData($('#submit_modal')[0]);
				// formData.append('lampiran', $('input[type=file]')[0].files[0]);
				e.preventDefault(); 
				$.ajax({
					url:'<?php echo base_url();?>validasi/validasi/update_status',
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
							//loadMainContent('validasi');
						}
					}
				});
			}
		}); 
	});
	

function panggil_debitur(id) {
		url = "<?php echo site_url('validasi/validasi/get_by_id')?>";
		$.ajax({
			url : url,
			type: "POST",
			data: {id:id},
			dataType: "JSON",
			success: function(data){ 
			console.log(data);
				// $('#id_drone').val("");
				//$('#nama_kebun').val("");
				//$('#status_kualitas').val("");
				//$('#keterangan').val("");
				
				$('#myModal').modal('show');
				$('#id_drone_modal').val(data[0].id_drone);
				$('#nama_kebun_modal').val(data[0].nama_kebun); 
				

				// data[0].id_debitur
				// data[0].nama_debitur
			}
		});
		
	}
</script>