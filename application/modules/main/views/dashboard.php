<script src="<?= base_url();?>assets/js/upclick.js" type="text/javascript"></script> 
<script type="text/javascript">
	$(document).ready(function(){
		loadMain(1);
		setTitle('<?= $title?>');
		$('#lbl_title').text('List');
  	});
	
	function loadMain()
	{
		showProgres();
		$.post(site_url+'main/main/dashboard1'
				,{}
				,function(result) {
					
					$('#content-list').html(result);
					hideProgres();
				}					
				,"html"
			);
	}
	
	
	
function loadPageList(pg)
	{
		//showProgres();
		$.post(site_url+'main/drone/page/'+pg
				,$("#dataForm").serialize()
				,function(result) {
					//$('#main-list').show();
					$('#content-list').html(result);
					//$('#content-filter').hide();
					//$('#main-input').hide();
					//hideProgres();
				}					
				,"html"
			);
	}
	
	function loadList(url)
	{
		showProgres();
		$.post(site_url+url
				,{}
				,function(result) {
					$('#list-data').html(result);
					$('#main-view').show();
					$('#main-input').hide();	
					$('#input-view').hide();
					
					hideProgres();
				}					
				,"html"
			);
	}
	
	
	function contentFilterShow()
	{
		//-------- baris scrip yg lama ------
		//contentHide();
		//$('#tabFilter').show();
		//$('#content-filter').show();
		//$('#lbl_title').text('Filter');
		//-----------------------------------
		
		showProgres();
		$.post(site_url+'main/mitra/filter'
				,{}
				,function(result) {
					//contentHide();
					$('#tabFilter').show();
					$('#lbl_title').text('Filter');
					$('#content-filter').html(result);
					
				}					
				,"html"
			);
		
		hideProgres();	
		
	}
	
	function contentFilterHide()
	{
		$('#content-filter').hide();
	}
	
	function contentListShow()
	{
		//-------- baris scrip yg lama ------
		//$('#tabList').show();
		//$('#lbl_title').text('<?=$title?>');
		//loadPageList(1);
		
		//if ($('#content-list').html()=='')
		//{
			
		//} 
		//-----------------------------------
		
		loadPageList(1);
		$('#content-list').show();
		
	}
	
	
	
	
	
	function contentHide()
	{
		$('#tabFilter').hide();
		$('#tabList').hide();
	}
	

	function backToList()
	{
		$('#main-input').hide();
		$('#main-list').show();
	
	}
	
	
		
	function loadInput(url)
	{
		showProgres();
		$.post(site_url+url
			,{}
			,function(result) {
				$('#main-input').show();
				$('#main-input').html(result);
				$('#input-view').show();
				$('#main-list').hide();
				
				hideProgres();
			}					
			,"html"
			);
	}
	
	
	function inputData(id)
	{
		loadInput('drone/input/'+id);
	
	}
	
	function detailData(id)
	{
		alert('hai');
		loadInput('drone/detail/'+id);
	
	}
	 
	function uploadDok(id)
	{
		loadInput('drone/input_foto/'+id);
	
	}
	
	function liat_profile(nik,fid_unit)
	{
		loadInput('main/main/detail/'+nik+'/'+fid_unit);
	
	}
	
	function uploaddata(id)
	{
		loadInput('kelengkapan_admin/input/'+id);

	}

	 
	
	 

	 

	  
	
</script>
<div id="content"> 
<div  >
	<div class="widget widget-inverse" id="main-list">
		
		<div class="widget-head">
			<div class="btn-group pull-right">
							
				<a class="btn btn-inverse" title="Muat Ulang..." onClick="contentListShow(1);"><i class="fa fa-refresh"></i></a>

			</div>
			<h4 class="heading"><i class="fa fa-fw fa-list"></i> <span id="lbl_title"></span></h4>
		</div>
		
		
		<div id="tabFilter" class="widget-body padding-bottom-none">
			<form id="dataForm">
				<div id="content-filter">
				
				</div>
			</form>
		</div>

		
		<div id="tabList" class="widget-body padding-bottom-none">
			<div id="content-list">
			</div>
		</div>
		
		
	</div>

	<div id="main-input">
	</div>
</div>
 