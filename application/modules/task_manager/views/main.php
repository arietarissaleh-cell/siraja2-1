<script type="text/javascript">
	$(document).ready(function(){
		loadMain(1);
		setTitle('<?= $title?>');
		$('#lbl_title').text('List');
  	});
	
	function loadMain()
	{
		showProgres();
		$.post(site_url+'task_manager/task_manager/page'
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
		showProgres();
		$.post(site_url+'task_manager/task_manager/page/'+pg
				,$("#dataForm").serialize()
				,function(result) {
					//$('#main-list').show();
					$('#content-list').html(result);
					//$('#content-filter').hide();
					//$('#main-input').hide();
					hideProgres();
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
		$.post(site_url+'task_manager/task_manager/filter'
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
	
	
	function editData(unit,id)
	{
		loadInput('task_manager/input/'+unit+'/'+id);
	
	}
	
		function detailData(unit,id)
	{
		loadInput('task_manager/detail/'+unit+'/'+id);
	
	}
	
	function deleteConfirm(id)
	{
		bootbox.confirm('Anda yakin data dengan NIK: <br>'+$('#username_'+id).val()+' akan di Hapus?', 
			function(e){
				if (e){
					$.post(site_url+"task_manager/task_manager/delete/"+id
						,{}
						,function(result) {
							if (result.error)
							{
								pesan_error(result.error);
							}else
							{
								pesan_success(result.message);
								loadPageList(1);
							}
						}					
					,"json"
					);
					}
				}); 
	}
	
	
	
</script>

<div class="innerAll spacing-x2">
	<div class="widget widget-inverse" id="main-list">
		
		
		
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
<!--
Author: Hariyo Koco
Author URL: http://www.koco.com
28052016
-->