<script type="text/javascript">
	$(document).ready(function(){
		setTitle('<?= $title?>');
  		loadMain();
		$('#lbl_title').text('Filter');
	});	
	function loadMain()
	{
		$.post(site_url+'utilities/file_upload/filter'
				,{}
				,function(result) {
					$('#filter_list').html(result);
				}					
				,"html"
			);
	}
	function loadPageList(pg)
	{
		showProgres();
		$.post(site_url+'utilities/file_upload/page/'+pg
				,$("#dataForm").serialize()
				,function(result) {
					$('#main-list').show();
					$('#content-list').html(result);
					$('#main-input').hide();
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
	function backToList()
	{
		$('#main-input').hide();
		$('#main-list').show();
	
	}
	function deleteConfirm(id)
	{
		bootbox.confirm('Anda yakin data : <br>'+$('#real_name_'+id).val()+' akan di Hapus?', 
			function(e){
				if (e){
					$.post(site_url+"utilities/file_upload/delete/"+id
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
	function contentFilterShow()
	{
		contentHide();
		$('#tabFilter').show();
		$('#filter_list').show();
		$('#lbl_title').text('Filter');
	}
	function contentListShow()
	{
		contentHide();
		$('#tabList').show();
		$('#lbl_title').text('<?=$title?>');
		loadPageList(1);
		if ($('#content-list').html()=='')
		{
			
		}
	}
	function contentHide()
	{
		$('#tabFilter').hide();
		$('#tabList').hide();
	}
</script>
<div id="content"><h1 class="bg-white content-heading border-bottom"><?=$title?></h1>
<div class="innerAll spacing-x2">
	<div class="widget widget-inverse" id="main-list">
		<div class="widget-head">
			<div class="btn-group pull-right">
				<a class="btn btn-inverse" onClick="contentFilterShow()" title="Cari..."><i class="fa fa-search"></i></a>
				<a class="btn btn-inverse" title="Segarkan..." onClick="contentListShow(1);"><i class="fa fa-refresh"></i></a>
				<a class="btn btn-inverse" title="Tambah" href="javascript:void(0);" onClick="loadInput('utilities/file_upload/input')"><i class="fa fa-plus-square"></i></a>
				
			</div>
			<h4 class="heading"><i class="fa fa-fw fa-user"></i> <span id="lbl_title"></span></h4>
		</div>
		<div class="widget-body padding-bottom-none">
			<div class="tab-content">
				<div id="tabFilter" class="tab-pane active widget-body-regular">
					<form id="dataForm">
						<div id="filter_list">
						</div>
					</form>
				</div>
				<div id="tabList" class="tab-pane widget-body-regular">
					<div id="content-list">
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="main-input">
	</div>
</div>
<!--
Author: Rickytarius
Author URL: http://www.bayssl.com
28052016
-->