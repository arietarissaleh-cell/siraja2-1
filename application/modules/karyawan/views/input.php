<script src="<?= base_url();?>/assets/components/modules/admin/forms/elements/uniform/assets/lib/js/jquery.uniform.min.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/modules/admin/forms/elements/uniform/assets/custom/js/uniform.init.js?v=v1.2.3"></script>
<script type="text/javascript">
	$(document).ready(function(){
		setTitle('<?= $title?>');
		objDate('tanggal_diangkat');
		$("#fid_unit").select2({
				placeholder: "-- Pilih --",
				allowClear: true
		});
		
		$("#jabatan").select2({
				placeholder: "-- Pilih --",
				allowClear: true
		});
		
		$("#jenis_karyawan").select2({
				placeholder: "-- Pilih --",
				allowClear: true
		});
		
		$("#golongan").select2({
				placeholder: "-- Pilih --",
				allowClear: true
		});
		
		$("#bidang").select2({
				placeholder: "-- Pilih --",
				allowClear: true
		});
		
		$("#bagian").select2({
				placeholder: "-- Pilih --",
				allowClear: true
		});
  	
	});	

function save(){ 
		$.post(site_url+'karyawan/save'
				,$('#submitForm').serialize()
				,function(result) {
				if (result.error)
				{
					pesan_error(result.error);
				}else
				{
					pesan_success(result.message);
					$('#id_karyawan').val(result.id_karyawan);
					// loadPageList(1);
				}
			}					
			,"json"
		);
	}
</script>

<form class="form-horizontal margin-none" id="submitForm" method="get" autocomplete="off" novalidate="novalidate">
	
	<div class="widget widget-inverse"  id="main-list">
		<div class="widget-head">
			<h4 class="heading"><i class="fa fa-fw fa-user"></i><?=$title?></h4>
			<div class="btn-group btn-group-xs pull-right">
				<a href="javascript:void(0);" class="btn btn-inverse" onClick="backToList();"title="Kembali"><i class="fa fa-arrow-left"></i></a>
			</div>
		</div>
		<div class="widget-body">
			<input class="form-control" id="id_karyawan" name="t_id_karyawan" type="hidden" value="<?= encode($karyawan['id_karyawan'])?>">
			<div class="innerB">
			
				<div class="row">
					<div class="col-xs-3">
						<label class="control-label" style="text-align:left">Unit</label><br>
							<select style="width: 236px;" id="fid_unit" name="t_fid_unit" data-placeholder="Pilih">
								<!-- <option value="all">All</option> -->
								<?php
									foreach($unit->result_array() as $row)
									{?>
									
										<option value="<?= ($row['id_unit'])?>" <?=$row['id_unit']==$karyawan['fid_unit']?'selected':'';?> ><?= $row['nama']?></option>
								<?php	} 
									
								?>
							</select>
					</div>
					
				</div>
				
				
				
				<div class="row">
					<div class="col-xs-3">
					<label class="control-label" style="text-align:left">NIK</label>
							<input class="form-control" id="nik" name="t_nik" type="text" value="<?= $karyawan['nik']?>">
					</div>
				</div>
				
				
				
				<div class="row">
					<div class="col-xs-3">
						<label class="control-label" style="text-align:left">Nama Depan</label>
							<input class="form-control" id="nama_depan" name="t_nama_depan" type="text" value="<?= $karyawan['nama_depan']?>">
					</div>					
				</div>
				
				<div class="row">
					<div class="col-xs-3">
						<label class="control-label" style="text-align:left">Nama Belakang</label>
							<input class="form-control" id="nama_belakang" name="t_nama_belakang" type="text" value="<?= $karyawan['nama_belakang']?>">
						
					</div>
				</div>
				
				<div class="row">
					<div class="col-xs-3">
						<label class="control-label" style="text-align:left">Jenis Kelamin</label><br>
							<input id="gender" name="t_gender" type="radio" value="L"> Laki- Laki
							<input id="gender" name="t_gender" type="radio" value="P"> Perempuan						
					</div>
				</div>
				
				<div class="row">
					<div class="col-xs-3">
						<label class="control-label" style="text-align:left">Jabatan</label><br>
							<select style="width: 236px;" id="jabatan" name="t_jabatan" data-placeholder="Pilih">
								<!-- <option value="all">All</option> -->
								<?php
									foreach($jabatan->result_array() as $row)
									{?>
									
									<option value="<?= ($row['id_jabatan'])?>" <?=$row['id_jabatan']==$karyawan['id_jabatan']?'selected':'';?>><?= $row['nama_jabatan']?></option>
								<?php	} 
									
								?>
							</select>
					</div>
				</div>
				
				
				
				<div class="row">
					<div class="col-xs-3">
						<label class="control-label" style="text-align:left">Golongan</label><br>
							<select style="width: 236px;" id="golongan" name="t_golongan" data-placeholder="Pilih">
								<!-- <option value="all">All</option> -->
								<?php
									foreach($golongan_karyawan->result_array() as $row)
									{?>									
									<option value="<?= ($row['id_golongan_karyawan'])?>" <?=$row['id_golongan_karyawan']==$karyawan['id_golongan_karyawan']?'selected':'';?>><?= $row['nama_golongan_karyawan']?></option>
								<?php	} 
									
								?>
							</select>
					</div>
				</div>
				
				
				<div class="row">
					<div class="col-xs-3">
						<label class="control-label">Tanggal Diangkat</label>
						<div class="input-group date" id="tanggal_diangkat">
							<?php
								$tgl = date('d-m-Y');
								// if($sa['tgl_sa']){
									// $tgl = humanize_mdate($sa['tgl_sa'],'%d %M %Y');
								// }
							?>
							<input class="form-control" type="text" value="<?= $tgl?>" id="tanggal_diangkat" name="t_tanggal_diangkat">
							<span class="input-group-addon"><i class="fa fa-th"></i></span>
						</div>
					</div>
				</div>
				
				
				<div class="row">
					<div class="col-xs-3">
						<label class="control-label" style="text-align:left">Bidang</label><br>
							<select style="width: 236px;" id="bidang" name="t_bidang" data-placeholder="Pilih">
								<!-- <option value="all">All</option> -->
								<?php
									foreach($bidang->result_array() as $row)
									{?>									
									<option value="<?= ($row['id_bidang'])?>" <?=$row['id_bidang']==$karyawan['id_bidang']?'selected':'';?>><?= $row['nama_bidang']?></option>
								<?php	} 
									
								?>
							</select>
					</div>
				</div>
				
				
				<div class="row">
					<div class="col-xs-3">
						<label class="control-label" style="text-align:left">Bagian</label><br>
							<select style="width: 236px;" id="bagian" name="t_bagian" data-placeholder="Pilih">
								<!-- <option value="all">All</option> -->
								<?php
									foreach($bagian->result_array() as $row)
									{?>									
									<option value="<?= ($row['id_bagian'])?>" <?=$row['id_bagian']==$karyawan['id_bagian']?'selected':'';?>><?= $row['nama_bagian']?></option>
								<?php	} 
									
								?>
							</select>
					</div>
				</div>
								
				<div class="row">
					<div class="col-xs-3">
						<label class="control-label" style="text-align:left">Email</label>
							<input class="form-control" id="email" name="t_email" type="email" value="<?= $karyawan['email']?>">
					</div>					
				</div>
				
				<div class="row">
					<div class="col-xs-3">
						<label class="control-label" style="text-align:left">No Master Absensi</label>
							<input class="form-control" id="nomaster" name="t_nomaster" type="email" value="<?= $karyawan['nomaster']?>">
					</div>					
				</div>
				
				
							
				<div class="row">
					<div class="form-actions pull-right">
						<a href="javascript:void(0);" class="btn btn-success" onClick="save();"><i class="fa fa-floppy-o"></i> Simpan</a>
					</div>
				
				</div>
				
			</div>
		</div>
	</div>
	<!-- // Widget END -->
	
</form>
<!--
Author: Rickytarius
Author URL: http://www.bayssl.com
28052016
-->