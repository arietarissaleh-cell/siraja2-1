<script>
function save(){ 
		
			//CKEDITOR.instances[instance].updateElement();
			let pembuat = document.forms["submitForm"]["pembuat"].value;
			let nik_pembuat = document.forms["submitForm"]["nik_pembuat"].value;
			let atasan = document.forms["submitForm"]["atasan"].value;
			let nik_atasan = document.forms["submitForm"]["nik_atasan"].value;
			let katagori = document.forms["submitForm"]["katagori"].value;
			let tipe = document.forms["submitForm"]["tipe"].value;
			let keterangan = document.forms["submitForm"]["keterangan"].value;
			
			
				var formData = new FormData($('#submitForm')[0]);
				//formData.append('t_lampiran', $('input[type=file]')[0].files[0]);
				$.ajax({
					url:'<?php echo base_url();?>ajuan_tm/ajuan_tm/save',
					type:"post",
					data: formData,
					processData:false,
					contentType:false,
					cache:false,
					async:false,
					dataType: "json",
					beforeSend: function() {
						Swal.fire({
							title: 'Menyimpan',
							html: 'Mohon Menunggu ... ',
							allowEscapeKey: false,
							allowOutsideClick: false,
							didOpen: () => {
								Swal.showLoading()
							}
						});
					}, 

					success: function(data){
						if(data['sukses'] == 1){
							setTimeout(function(){
								swal.close();
								Swal.fire('Berhasi Simpan', '', 'success');
								loadMainContent('ajuan_tm');
							},1000);
						}

						else if(data['sukses'] == 0){
							setTimeout(function(){
								swal.close();
								Swal.fire('Gagal Upload', data['fail'], 'error');
							},1000);
						}
					},
					error: function(data){
						setTimeout(function(){
							swal.close();
							Swal.fire('Gagal Simpan', '', 'error');
						},1000);
					}	
				});
			
		
	}
	</script>

	<form class="form-horizontal margin-none" id="submitForm" method="POST" autocomplete="off" novalidate="novalidate">		
    <div class="page-content">
        <div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-sm-flex align-items-center justify-content-between">
						<h4 class="mb-sm-0 font-size-18">Input Task Management</h4>
							<div class="page-title-right">
								<ol class="breadcrumb m-0">
									<li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
									<a href="#" onclick="loadMainContent('task_manager/task_manager/index')" class="image-link"><li class="breadcrumb-item active">/ Task Management</li></a>
									<a href="#" onclick="loadMainContent('ajuan_tm/ajuan_tm/index')" class="image-link"><li class="breadcrumb-item active">/ List</li></a>
								</ol>
							</div>
					</div>
				</div>
			</div>
						
			<div class="row">
                <div class="col-xl-9 col-lg-8">
                    <div class="card">
                        <div class="card-body">
							<div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Kode </label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="<?=$data_tm['kode_tm']?>" id="kode" name="kode" readonly>
                                </div>
                            </div>
							<div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Pembuat</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="<?=$data_tm['nama_depan']?>" id="pembuat" name="pembuat" readonly>
                                    <input class="form-control" type="hidden" value="<?=$data_tm['id_tm']?>" id="id_tm" name="id_tm" readonly>
                                    
                                   
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-search-input" class="col-md-2 col-form-label">Atasan</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="<?=$data_tm['nama_atasan']?>" id="atasan" name="atasan" readonly>
                                   
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-email-input" class="col-md-2 col-form-label">Katagori</label>
                                 <div class="col-md-10">
                                    <input class="form-control" type="text" value="<?=$data_tm['katagori']?>" id="katagori" name="katagori" readonly>
                                   
                                </div>
                            </div>
                           
                            <div class="mb-3 row">
                                <label for="example-tel-input" class="col-md-2 col-form-label">Merk/Tipe/Spesifikasi</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="<?=$data_tm['tipe']?>" placeholder="" id="tipe" name="tipe" readonly>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-password-input" class="col-md-2 col-form-label">Ringkasan Permintaan / Permasalahan</label>
                                <div class="col-md-10">
                                   <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="" readonly><?=$data_tm['keterangan']?></textarea>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-number-input" class="col-md-2 col-form-label">Lampiran</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="<?=$data_tm['nama_file']?>"  placeholder="" id="lampiran" name="lampiran" readonly>
                                </div>
                            </div>
							
							 <div class="mb-3 row">
                                <label for="example-password-input" class="col-md-2 col-form-label">Catatan Atasan</label>
                                <div class="col-md-10">
                                   <textarea class="form-control" id="catatan_atasan" name="catatan_atasan" rows="3" placeholder="" readonly><?=$data_tm['catatan_atasan']?></textarea>
                                </div>
                            </div>
							
							<div class="mb-3 row">
                                <label for="example-password-input" class="col-md-2 col-form-label">Catatan Kabag IT</label>
                                <div class="col-md-10">
                                   <textarea class="form-control" id="catatan_atasan" name="catatan_atasan" rows="3" placeholder="" readonly><?=$data_tm['catatan_kabag_it']?></textarea>
                                </div>
                            </div>
							
							<div class="mb-3 row">
                                <label for="example-tel-input" class="col-md-2 col-form-label">PIC</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="<?=$data_tm['nama_pic']?>" placeholder="" id="tipe" name="tipe" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
           
			
				<div class="col-xl-3 col-lg-4">
                    <div class="card">
						<div class="card-body">
                            <h4 class="card-title mb-5">Timeline</h4>
                                <div class="">
                                    <ul class="verti-timeline list-unstyled">
                                        <li class="event-list">
											<div class="event-timeline-dot">
												<i class="bx bx-right-arrow-circle"></i>
											</div>
											<div class="media">
												<div class="me-3">
													<i class="bx bx-copy-alt h2 text-primary"></i>
												</div>
												<div class="media-body">
													<div>
														<h5>Dibuat</h5>
														<p class="bx bxs-user-pin"><?=$data_tm['nama_depan']?></p><br>
														<p class="bx bxs-time"><?=$data_tm['create_date']?></p>
													</div>
												</div>
											</div>
                                        </li>
                                        <li class="event-list">
                                            <div class="event-timeline-dot">
                                                <i class="bx bx-right-arrow-circle"></i>
                                            </div>
                                            <div class="media">
                                                <div class="me-3">
                                                    <i class="bx bx-user-check h2 text-primary"></i>
                                                </div>
                                                <div class="media-body">
                                                    <div>
                                                        <h5>Approve Atasan</h5>
                                                        <p class="bx bxs-user-pin"><?=$data_tm['nama_atasan']?></p><br>
														<p class="bx bxs-time"><?=$data_tm['atasan_approve_date']?></p>
														</div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="event-list active">
                                            <div class="event-timeline-dot">
                                                <i class="bx bx-right-arrow-circle"></i>
                                            </div>
                                            <div class="media">
                                                <div class="me-3">
                                                    <i class="bx bxs-user-check h2 text-primary"></i>
                                                </div>
                                                <div class="media-body">
                                                    <div>
                                                        <h5>Approve Kabag IT</h5>
														<p class="bx bxs-user-pin"><?=$data_tm['nama_kbg_it']?></p><br>
														<p class="bx bxs-time"><?=$data_tm['kabag_it_approve_date']?></p>
													</div>
                                                </div>
                                            </div>
                                        </li>
                                       
										<li class="event-list">
                                            <div class="event-timeline-dot">
                                                <i class="bx bx-right-arrow-circle"></i>
                                            </div>
                                            <div class="media">
                                                <div class="me-3">
                                                    <i class="bx bxs-wrench h2 text-primary"></i>
                                                </div>
                                                <div class="media-body">
                                                    <div>
                                                        <h5>Sedang Di Tindaklajuti</h5>
                                                        <p class="bx bxs-user-pin"><?=$data_tm['nama_pic']?></p><br>
														<p class="bx bxs-time"><?=$data_tm['estimasi_selesai']?></p>
													</div>
                                                </div>
                                            </div>
                                        </li>
										<li class="event-list">
                                            <div class="event-timeline-dot">
                                                <i class="bx bx-right-arrow-circle"></i>
                                            </div>
                                            <div class="media">
                                                <div class="me-3">
                                                    <i class="bx bx-check-circle h2 text-primary"></i>
                                                </div>
                                                <div class="media-body">
                                                    <div>
                                                        <h5>Selesai</h5>
                                                        <p class="bx bxs-user-pin"><?=$data_tm['nama_pic']?></p><br>
														<p class="bx bxs-time"><?=$data_tm['tgl_selesai']?></p>
													</div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                        </div>
                                    
                    </div>
                </div>
             </div>
        </div>
    </form>
	</div>
    