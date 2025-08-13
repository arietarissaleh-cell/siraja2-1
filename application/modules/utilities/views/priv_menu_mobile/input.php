<script src="<?= base_url();?>/assets/components/modules/admin/forms/elements/uniform/assets/lib/js/jquery.uniform.min.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/modules/admin/forms/elements/uniform/assets/custom/js/uniform.init.js?v=v1.2.3"></script>
<script type="text/javascript">
	$(document).ready(function(){
		setTitle('<?= $title?>');
		// objDate('picker_expired_date');
  	});	
	function save(){ 
		$.post(site_url+'utilities/priv_menu_mobile/save'
				,$('#submitForm').serialize()
				,function(result) {
				if (result.error)
				{
					pesan_error(result.error);
				}else
				{
					pesan_success(result.message);
					$('#id_ms_operator').val(result.id_ms_operator);
					loadInput('utilities/priv_menu_mobile/input/'+result.id_ms_operator)
				}
			}					
			,"json"
		);
	}
	function checkAll()
	{
		var cCap = $('#buttonCheck').html();
		if (cCap == 'Check All')
		{
			// $(".menu .checkbox").attr("checked", "true");
			$( ".menu span" ).addClass( "checked" )
			cCap = 'UnCheck All';			
		}else
		{
			// $(".menu .checkbox").removeAttr('checked');
			$( ".menu span" ).removeClass( "checked" );
			cCap = 'Check All';
		}
		$('#buttonCheck').html(cCap);
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
			<div class="row-fluid">
				<a href="javascript:void(0)" class="btn btn btn-primary" onclick="checkAll();" id="buttonCheck">Check All</a>
			</div>
			<input class="form-control" id="id_ms_operator" name="t_id_ms_operator" type="hidden" value="<?= encode($operator['id_ms_operator'])?>">
			<!-- Category Links -->
			<div class="row innerAll half border-bottom menu" >
				<?=$app_menu?>
				
			</div>
			<div class="row-fluid">
				<div class="form-actions">
					<button type="button" class="btn btn-success pull-right" onclick="save()">Save Privileges</button>
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