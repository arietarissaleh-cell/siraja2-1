<script src="<?= base_url();?>assets/js/upclick.js" type="text/javascript"></script> 
<script type='text/javascript'>
	$(document).ready(function(){

		$("#unit").select2({
			placeholder: "-- Pilih --",
			allowClear: true
		});
		$("#tahun_awal").select2({
				placeholder: "-- Pilih --",
				allowClear: true
			});
		$("#tahun_akhir").select2({
				placeholder: "-- Pilih --",
				allowClear: true
			});
		objDate('photo_date');
		<?php if($file_upload['kode_kebun']){?>
			lookupSelectKodeKebun('<?=$file_upload['kode_kebun']?>');
		<?php }?>
	});
	function uploadImage(obj)
	{
		var tahun_awal = $('#tahun_awal').val();
		var tahun_akhir = $('#tahun_akhir').val();
		var note = $('#remark').val();
			remark = note.replace(/ /g,'_');
		var unit = $('#unit').val();
		var no_petak = $('#no_petak').val();
		var kode_kebun = $('#kode_kebun').val();
		var tgl_pemotretan = $('#tgl_pemotretan').val();
		if(!unit){
			pesan_error('Unit tidak boleh kosong');
			return false;
		}
		if(!tahun_awal){
			pesan_error('Tahun Awal tidak boleh kosong');
			return false;
		}
		if(!tahun_akhir){
			pesan_error('Tahun Akhir tidak boleh kosong');
			return false;
		}
		if(!no_petak){
			pesan_error('Petak tidak boleh kosong');
			return false;
		}
		if(!kode_kebun){
			pesan_error('Kebun tidak boleh kosong');
			return false;
		}
		if(!tgl_pemotretan){
			pesan_error('Tanggal Pemotretan tidak boleh kosong');
			return false;
		}
		upclick(
		{
			element: obj,
			action: site_url+'utilities/file_upload/upload/<?= encode($file_upload['id_file_upload'])?:0?>/'+tahun_awal+'/'+tahun_akhir+'/'+unit+'/'+remark+'/'+kode_kebun+'/'+no_petak+'/'+tgl_pemotretan, 
			onstart:
				function(filename)
				{
					//alert('Start upload: '+filename);
				},
			oncomplete:
				function(response_data) 
				{
					// location.reload();
					loadPageList(1);
				}
		});
	}
	
	function removeImage(id)
	{
		$.post(site_url+'admin/produk/image_remove/'+id
				,{}
				,function(result) {
					if (result.error)
					{
						alert(result.error);
					}else
					{
						alert(result.message);
						location.reload();
					}
				}					
				,"json"
			);
	}
	function pageLookupKodeKebun(pg)
	{
		// showProgres();
		$.post(site_url+"kebun/page_kebun/"+pg
					,{lookup_key : $('#lookup_key').val()
						,t_fid_unit : $('#unit').val()
						,t_unit_type : $('#unit_type').val()
						,t_tahun_awal : $('#tahun_awal').val()
						,t_tahun_akhir : $('#tahun_akhir').val()
					}
					,function(result) {
						$('#kodeKebunContentShow').html(result);
						// hideProgres();
					}					
					,"html"
				);
		
	}
	function lookupSelectKodeKebun(no)
	{
		$('#kode_kebun').val(no);
		lookupDataKodeKebun(no,'kebun/kode_kebun','resultContentKodeKebun');
	}
	function lookupDataKodeKebun(key,url,objResult)
	{
		$.post(site_url+url
				,{t_kode_kebun:key
					,t_fid_unit : $('#unit').val()
					,t_tahun_awal : $('#tahun_awal').val()
					,t_tahun_akhir : $('#tahun_akhir').val()
				}
				,function(result){
					$('#'+objResult).html(result);
					
				}
				,'json'
		);
	}
</script>
<div class="modal fade" id="myModalKodeKebun" scrolllock="true"  tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h3 id="myModalLabel1">Search</h3>
			</div>
			<div class="modal-body">
			<input type="hidden" id="unit_type" value="single">
				<div class="innerAll">
					<div class="innerLR">
							<div class="form-group">
								<label class="col-sm-1 control-label">Key</label>
								<div class="col-sm-10">
									<input class="form-control span8" type="text" value="" id="lookup_key" name="t_lookup_key" onkeydown="if (event.keyCode == 13) pageLookupKodeKebun(1)">
								</div>
							</div>
							<div id="kodeKebunContentShow">
											
							</div>
					</div>
				</div>
				
			</div>
			<!-- // Modal body END -->
	
		</div>
	</div>
	
</div>
<div class="widget widget-inverse">
		
	<!-- Widget heading -->
	<div class="widget-head">
		<h4 class="heading">File controls</h4>
	</div>
	<!-- // Widget heading END -->
	
	<div class="widget-body">
		<div class="row">
			<div class="col-md-6">
				<h4 class="separator bottom">Unit</h4>
				<div class="innerB">
					<select style="width: 80%;" placeholder="Pilih Unit...." id="unit" name = "t_unit">
						<option value="0"></option>
						<?php 
						$kode_usaha = '';
						$i = 0;
						foreach($unit_list->result_array() as $unit) 
						{
							if ($kode_usaha <> $unit['kode_usaha'])
							{
								if ($i > 0)
								{
									echo '</optgroup>';
								}
								echo '<optgroup label="'.$unit['nama_usaha'].'">';
							}
							?>
						<option value="<?= $unit['id_unit']?>" <?= $unit['id_unit']==18?'selected':''?>><?= $unit['id_unit'].' - '.$unit['nama']?></option>
						<?php 
						$kode_usaha = $unit['kode_usaha'];
						$i = $i + 1;
						}?>
						</optgroup>
					</select>
				</div>
			</div>
			<div class="col-md-6">
				<h4 class="separator bottom">Musim Tanam Awal/akhir</h4>
				<div class="innerB">
					<select  id="tahun_awal" name="t_tahun_tanam_awal" data-placeholder="Pilih">
							<?php
								for($i=2010;$i <= date('Y')+6;$i++){
							?>
								<option value="<?=$i?>" <?=$i==date('Y')?'selected':''?>><?=$i?></option>
							<?php }?>				
					</select>
					<label>&nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;</label>
					<select id="tahun_akhir" name="t_tahun_tanam_akhir" data-placeholder="Pilih">
						<?php
							for($i=2010;$i <= date('Y')+6;$i++){
						?>
							<option value="<?=$i?>" <?=$i==(date('Y')+1)?'selected':''?>><?=$i?></option>
						<?php }?>
						
						
					</select>
				</div>
			</div>
			<div class="col-md-6">
				<h4 class="separator bottom">Petak Kebun</h4>
				<div class="innerB">
					<div class="input-group" style="width: 40%;">
						<input placeholder='Kode Kebun....' style="" class="form-control" type="text" value="<?=$file_upload['kode_kebun']?>" id="kode_kebun" name="t_kode_kebun" onkeydown="if (event.keyCode == 13) lookupSelectKodeKebun(this.value)">
						<span class="input-group-addon">
							<a href="#myModalKodeKebun" placeholder="Cari..." onClick="pageLookupKodeKebun(1);" data-toggle="modal" data-backdrop="static">
								<i class="fa fa-search"></i>
							</a>
						
						</span>
					</div>
					<div id="resultContentKodeKebun"></div>
				</div>
				
			</div>
			
			<div class="col-md-4">
				<label class="control-label">Tgl. Pemotretan</label>
				<div class="input-group date" id="photo_date">
					<?php
						$tgl = date('d-m-Y');
					?>
					<input class="form-control" type="text" value="<?= humanize_mdate($file_upload['tgl_pemotretan'])?:$tgl?>" id="tgl_pemotretan" name="t_tgl_pemotretan">
					<span class="input-group-addon"><i class="fa fa-th"></i></span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<h4 class="separator bottom">Catatan</h4>
				<div class="innerB">
					<textarea class="form-control span8" type="text" id="remark" name="t_remark" rows="3"><?=$file_upload['remark']?></textarea>
				</div>
			</div>
		</div>
		
		<br></br>
		<div class="row">
			<div class="col-md-6">
				<button class="btn btn-primary btn-mini pull-right" onclick="uploadImage(this)">
					<i class="icon-picture"></i> &nbsp; Attach File
				</button>
			</div>
			
		</div>
	</div>
</div>