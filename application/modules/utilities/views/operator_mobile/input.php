<script type="text/javascript">
	$(document).ready(function(){
		setTitle('<?= $title?>');
		objDate('picker_expired_date');
		$("#fid_unit").select2({
				placeholder: "-- Pilih --",
				allowClear: true
			});
			
		$("#id_karyawan").select2({
			placeholder: "-- Pilih --",
			allowClear: true
		});
			
  	});	
	
	
	function save(){ 
		$.post(site_url+'utilities/operator_mobile/save'
				,$('#submitForm').serialize()
				,function(result) {
				if (result.error)
				{
					pesan_error(result.error);
				}else
				{
					pesan_success(result.message);
					$('#id_ms_operator').val(result.id_ms_operator);
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
			<input class="form-control" id="id_ms_operator" name="t_id_ms_operator" type="hidden" value="<?= encode($operator['id_ms_operator'])?>">
			<div class="innerB">
			
				<div class="row">
					<div class="col-xs-3">
						<label class="control-label">Nama Karyawan</label>
						<select style="width: 236px;" id="id_karyawan" name="t_id_karyawan" data-placeholder="Pilih">
							<!-- <option value="all">All</option> -->
								<?php
									foreach($karyawan->result_array() as $row)
									{?>
										<option value="<?= ($row['id_karyawan'])?>" <?=$row['id_karyawan']==$operator['id_karyawan']?'selected':'';?> ><?= $row['nik'].' - '.$row['nama_depan'].' '.$row['nama_belakang']?></option>
								<?php	} 									
								?>
						</select>
						
					</div>
					
				</div>
			
			
				<div class="row">
					<div class="col-xs-3">
						<label class="control-label">Username</label>
							<input class="form-control" id="username" name="t_username" type="text" value="<?= $operator['username']?>">
						
					</div>
					
				</div>
				<div class="row">
					<div class="col-xs-3">
						<label class="control-label">Password Baru</label>
							<input class="form-control" id="password" name="t_password" type="password" value="">
						
					</div>
					<div class="col-xs-3">
						<label class="control-label">Ulangi Password</label>
							<input class="form-control" id="password2" name="t_password2" type="password" value="">
						
					</div>
					
				</div>
				<div class="row">
					<div class="col-xs-3">
						<label class="col-xs-6 control-label" style="text-align:left">Unit</label>
							<select style="width: 172px;" id="fid_unit" name="t_fid_unit" data-placeholder="Pilih">
								<!--option value="all">All</option-->
								<?php
									foreach($unit->result_array() as $row)
									{?>
									
										<option value="<?= ($row['id_unit'])?>" <?=$row['id_unit']==$operator['fid_unit']?'selected':'';?>><?= $row['nama']?></option>
								<?php	} 
									
								?>
							</select>
					</div>
					
				</div>
				<div class="row">
					<div class="col-xs-3">
						<label class="control-label">Tgl. Expired</label>
						<div class="input-group date" id="picker_expired_date">
							<?php
								$tgl = date('d-m-Y');
								// if($sa['tgl_sa']){
									// $tgl = humanize_mdate($sa['tgl_sa'],'%d %M %Y');
								// }
							?>
							<input class="form-control" type="text" value="<?= $tgl?>" id="expired_date" name="t_expired_date">
							<span class="input-group-addon"><i class="fa fa-th"></i></span>
						</div>
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