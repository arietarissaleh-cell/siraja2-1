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
		
		$("#id_karyawan").select2({
			placeholder: "-- Pilih --",
			allowClear: true
		});
		
		
	});	

	function save(){ 
		$.post(site_url+'user/save'
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
			<input class="form-control" id="id_ms_operator" name="t_id_ms_operator" type="hidden" value="<?= ($user['id_ms_operator'])?>">
			<div class="innerB">
				
				<div class="row">
					<div class="col-xs-3">
						<label class="control-label" style="text-align:left">Unit</label><br>
						<select style="width: 236px;" id="fid_unit" name="t_fid_unit" data-placeholder="Pilih">
							<!-- <option value="all">All</option> -->
							<?php
							foreach($unit->result_array() as $row)
								{?>
									
									<option value="<?= ($row['id_unit'])?>" <?=$row['id_unit']==$user['fid_unit']?'selected':'';?> ><?= $row['nama']?></option>
									<?php	} 
									
									?>
								</select>
							</div>
							
						</div>
						
						<div class="row">
							<div class="col-xs-3">
								<label class="control-label" style="text-align:left">Nama Karyawan</label><br>
								<select style="width: 236px;" id="id_karyawan" name="t_id_karyawan" data-placeholder="Pilih">
									<!-- <option value="all">All</option> -->
									<?php
									foreach($karyawan->result_array() as $row)
										{?>
											
											<option value="<?= ($row['id_karyawan'])?>" <?=$row['id_karyawan']==$user['id_karyawan']?'selected':'';?> ><?= $row['nik'].' - '.$row['nama_depan'].' '.$row['nama_belakang']?></option>
											<?php	} 									
											?>
										</select>
									</div>					
								</div>
								
								<div class="row">
									<div class="col-xs-3">
										<label class="control-label" style="text-align:left">Username</label>
										<input class="form-control" id="username" name="t_username" type="text" value="<?= $user['username']?>">
									</div>
								</div>
								
								<div class="row">
									<div class="col-xs-3">
										<label class="control-label" style="text-align:left">Password</label>
										<input class="form-control" id="password" name="t_password" type="password" required>
									</div>
								</div><br>
								
								

								<div class="row">
									<div class="col-xs-3">
										<label class="control-label" style="text-align:left">Hak Akses Menu</label><br><br>
										<?php
										
										$no_induk	=0;
										$no_anak	=0;
										
										if($user['id_ms_operator']==0){
											
											$query ="SELECT
											apm.id_app_menu as id_app_menu,
											apm.title as title
											FROM hrms.app_menus apm 
											where fid_app_menu=0
											order by order_by";
											
											$parent = $this->db->query($query);
											
											if($parent->num_rows()>0){
												foreach($parent->result() as $parent){
													?>
													&nbsp;<input type="checkbox" 
													name="menu_induk<?php echo $no_induk;?>" value=<?php echo $parent->id_app_menu;?>> 
													<?php echo $parent->title; ;?><br>					
													
													<?php 
													$query2 = "
													SELECT
													apm.id_app_menu as id_app_menu,
													apm.title as title
													FROM hrms.app_menus apm 
													where fid_app_menu={$parent->id_app_menu}
													order by order_by";
													
													$child = $this->db->query($query2);
													
													if($child->num_rows()>0){
														foreach($child->result() as $child){													
															?>														
															&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" 
															name="menu_anak<?php echo $no_anak;?>" value=<?php echo $child->id_app_menu;?>> 
															<?php echo $child->title;?><br>					
															
															<?php 
															$no_anak++;
														}											
													}
													
													$no_induk++;
												} 
											}
										}
										else{
											
											$query ="SELECT
											menu.id_app_menu,
											menu.title,
											mop.fid_operator
											FROM
											(select * from hrms.app_menus where fid_app_menu=0) menu
											LEFT JOIN
											(select * from hrms.ms_operator_privilege where fid_operator={$user['id_ms_operator']}) mop
											ON menu.id_app_menu=mop.fid_app_menu";
											
											$parent = $this->db->query($query);
											
											if($parent->num_rows()>0){
												foreach($parent->result() as $parent){
													?>
													&nbsp;<input type="checkbox" 
													<?php if($parent->fid_operator!= null) :
													?>													
													checked 
												<?php endif;?>
												name="menu_induk<?php echo $no_induk;?>" value=<?php echo $parent->id_app_menu;?>> 
												<?php echo $parent->title; ?><br>					
												
												<?php 
												$query2 = "
												SELECT
												menu.id_app_menu,
												menu.title,
												mop.fid_operator
												FROM
												(select * from hrms.app_menus where fid_app_menu={$parent->id_app_menu}) menu
												LEFT JOIN
												(select * from hrms.ms_operator_privilege where fid_operator={$user['id_ms_operator']}) mop
												ON menu.id_app_menu=mop.fid_app_menu";
												
												$child = $this->db->query($query2);
												
												if($child->num_rows()>0){
													foreach($child->result() as $child){													
														?>
														
														&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" 
														<?php if($child->fid_operator!= null) :?>													
															checked 
														<?php endif;?>
														name="menu_anak<?php echo $no_anak;?>" value=<?php echo $child->id_app_menu;?>> 
														<?php echo $child->title; ?><br>					
														
														<?php 
														$no_anak++;
													}											
												}
												$no_induk++;
											} 
										}
									}	
									?>
								</div>
							</div>
							

							<input type="hidden" name="t_no_anak" value="<?php echo $no_anak;?>" />
							<input type="hidden" name="t_no_induk"  value="<?php echo $no_induk;?>" />
							
							

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