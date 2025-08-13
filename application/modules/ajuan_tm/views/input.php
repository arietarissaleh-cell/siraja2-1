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
						<h4 class="mb-sm-0 font-size-18">Input Task Manager</h4>
							<div class="page-title-right">
								<ol class="breadcrumb m-0">
									<li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
									<a href="#" onclick="loadMainContent('task_manager/task_manager/index')" class="image-link"><li class="breadcrumb-item active">/ Task Manager</li></a>
									<a href="#" onclick="loadMainContent('ajuan_tm/ajuan_tm/index')" class="image-link"><li class="breadcrumb-item active">/ List</li></a>
								</ol>
							</div>
					</div>
				</div>
			</div>
						
			<div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
							<div class="text-sm-end">
							<div class="btn-group me-2 mb-2 mb-sm-0 ">
								<a href="javascript:void(0);" class="btn btn-primary waves-light waves-effect dropdown-toggle" onClick="loadMainContent('ajuan_tm/ajuan_tm/index')" > 
								<i class="fas fa-arrow-alt-circle-left"></i>  </a>
							</div>
							</div>
							<br>
									
							<div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Kode </label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="" id="kode" name="kode" readonly>
                                </div>
                            </div>
							<div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Pembuat</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="<?=$nama_depan?>" id="pembuat" name="pembuat" readonly>
                                    <input class="form-control" type="hidden" value="<?=$nik_karyawan?>" id="nik_pembuat" name="nik_pembuat" readonly>
                                    <input class="form-control" type="hidden" value="<?=$data_tm['id_tm']?>" id="id_tm" name="id_tm" readonly>
                                    <input class="form-control" type="hidden" value="<?=$kode_bagian?>" id="kode_bagian" name="kode_bagian" readonly>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-search-input" class="col-md-2 col-form-label">Atasan</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="<?=$atasan?>" id="atasan" name="atasan" readonly>
                                    <input class="form-control" type="hidden" value="<?=$nik_atasan?>" id="nik_atasan" name="nik_atasan" readonly>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-email-input" class="col-md-2 col-form-label">Katagori</label>
                                <div class="col-md-10">
                                    <select class="form-control select2" title="Country" id="katagori" name="katagori">
                                        <option value="0">Pilih Katagori</option>
                                        <option value="Aplikasi">Aplikasi</option>
                                        <option value="Hardware">Hardware</option>
                                        <option value="Internet">Internet</option>
                                        <option value="Data">Data</option>
                                        <option value="Pemetaan">Pemetaan</option>
                                    </select>
                                </div>
                            </div>
                           
                            <div class="mb-3 row">
                                <label for="example-tel-input" class="col-md-2 col-form-label">Merk/Tipe/Spesifikasi</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="" placeholder="" id="tipe" name="tipe">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-password-input" class="col-md-2 col-form-label">Ringkasan Permintaan / Permasalahan</label>
                                <div class="col-md-10">
                                   <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder=""></textarea>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-number-input" class="col-md-2 col-form-label">Lampiran</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="file" value=""  placeholder="" id="lampiran" name="lampiran">
                                </div>
                            </div>
							<div class="mb-3 row">
                                <div class="text-end">
                                    <a href="javascript:void(0);" class="btn btn-success" onClick="save();"><i class="mdi mdi-send me-1"></i> Kirim</a>
                                </div>
                            </div> 
							
							<div class="mb-3 row">
                               <label for="example-number-input" class="col-md-2 col-form-label">Disclaimer :</label>
                               <br><p><i>* Setiap Pengajuan akan di Proses Sesuai SLA</i></p>
                               <p><i>* Pengajuan yang tidak melibatkan pihak ke-3 akan di proses kurang dari 7hari kerja</i></p>
                               <p><i>* Pengajuan yang melibatkan pihak ke-3 akan di proses kurang-lebih dari 7hari kerja</i></p>
                               <p><i>* Permintaan barang akan di sesuaikan dengan anggaran yang ada</i></p>
                               <p><i>* Permintaan barang yang di proses yang nilai nya dibawah 500.000</i></p>
                               <p><i>* Permintaan barang yang diatas 500.000 disarankan membuat memo</i></p>
                            </div> 
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
        </div>
    </form>
	</div>
    