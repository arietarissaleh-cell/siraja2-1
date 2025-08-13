<script type="text/javascript">
	$(document).ready(function(){
		loadPageList(1);
		setTitle('<?= $title?>');
  	});	
	function loadPageList(id)
	{
		showProgres();
		$.post(site_url+'utilities/akun/input/'+id
				,{}
				,function(result) {
					$('#widget_input').html(result);
					hideProgres();
				}					
				,"html"
			);
	}
</script>
<!-- Widget -->
<div class="widget widget-inverse">
	<div class="widget-head">
		<h4 class="heading"></h4>
	</div>
	<div class="widget-body padding-bottom-none">
		<div id="widget_input">
		</div>
	</div>
</div>
<!-- // Widget END -->