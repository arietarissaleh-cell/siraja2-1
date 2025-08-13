<script>
$("#funit").select2({
	placeholder: "-- Pilih --",
	allowClear: true
});
$("#ftahun_awal").select2({
	placeholder: "-- Pilih --",
	allowClear: true
});
$("#ftahun_akhir").select2({
	placeholder: "-- Pilih --",
	allowClear: true
});

</script>
<div class="innerB">
	<div class="row">
		<!--div class="col-xs-3">
			<label class="control-label">Nama File
			<input type="text" id="freal_name" name="f_real_name" class="form-control" placeholder="Nama File......"></label>
		</div-->
		<div class="col-md-3">
			<h4 class="separator bottom">No.Petak</h4>
			<div class="innerB">
				<input class="form-control" type="text" id="fno_petak" name="f_no_petak"/>
			</div>
		</div>
		<div class="col-md-3">
			<h4 class="separator bottom">Kode/Nama Kebun</h4>
			<div class="innerB">
				<input class="form-control" type="text" id="fkode_kebun" name="f_kode_kebun"/>
			</div>
		</div>
		
	</div>
	<div class="row">
		<div class="col-md-6">
			<h4 class="separator bottom">Unit</h4>
			<div class="innerB">
				<select style="width: 80%;" placeholder="Pilih Unit...." id="funit" name = "f_unit">
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
				<select  id="ftahun_awal" name="f_tahun_tanam_awal" data-placeholder="Pilih">
						<?php
							for($i=2010;$i <= date('Y')+6;$i++){
						?>
							<option value="<?=$i?>" <?=$i==date('Y')?'selected':''?>><?=$i?></option>
						<?php }?>				
				</select>
				<label>&nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;</label>
				<select id="ftahun_akhir" name="f_tahun_tanam_akhir" data-placeholder="Pilih">
					<?php
						for($i=2010;$i <= date('Y')+6;$i++){
					?>
						<option value="<?=$i?>" <?=$i==(date('Y')+1)?'selected':''?>><?=$i?></option>
					<?php }?>
					
					
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<h4 class="separator bottom">Catatan</h4>
			<div class="innerB">
				<textarea class="form-control span8" type="text" id="fremark" name="f_remark" rows="3"></textarea>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-actions pull-right">
			<a href="javascript:void(0);" class="btn btn-success" onClick="contentListShow(1);"><i class="fa fa-search"></i> Tampilkan...</a>
		</div>
	
	</div>
	
</div>