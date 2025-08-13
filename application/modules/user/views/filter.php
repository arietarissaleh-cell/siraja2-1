<script type="text/javascript">
	$(document).ready(function(){
		$("#unit").select2({
				placeholder: "-- Pilih --",
				allowClear: true
			});
		$("#tahun").select2({
				placeholder: "-- Pilih --",
				allowClear: true
			});
		
	});
</script>	
<div class="innerB">
	
	<div class="row">
		<div class="col-xs-3">
			<label class="control-label">Unit
				<select style="width: 300px;" id="unit" name="t_unit[]" data-placeholder="Pilih" multiple="multiple">
					<option value="all">All</option>
					<?php
						foreach($unit->result_array() as $row)
						{?>
						
							<option value="<?= ($row['id_unit'])?>"><?= $row['nama']?></option>
					<?php	} 
						
					?>
				</select>
			</label>
		</div>
		
	</div>
	
	
	
	<div class="row">	
		<div class="col-xs-3">
			<label class="control-label">Username
			<input type="text" id="username" name="t_username" class="form-control" placeholder="Username......">
		</label>
		</div>
	
	</div>
	
	<div class="row">
		<div class="form-actions pull-left">
			<br>&nbsp;&nbsp;<a href="javascript:void(0);" class="btn btn-success" onClick="contentListShow(1);"><i class="fa fa-search"></i> Tampilkan...</a>
		</div>
	
	</div>
	
</div>