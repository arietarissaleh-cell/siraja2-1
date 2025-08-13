<script type="text/javascript">
	$(document).ready(function(){
		loadPageList(1);
		setTitle('<?= $title?>');
  	});	
	
	function loadPageList(pg)
	{
		
		showProgres();
		$.post(site_url+'validasi/validasi/page'
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
	
	function inputdata(id,no_petak,tahun_tanam_awal,tahun_tanam_akhir)
	{
		loadInput('validasi/input/'+id+'/'+no_petak+'/'+tahun_tanam_awal+'/'+tahun_tanam_akhir);
	
	}
	
	function next(fid_unit,no_petak,tahun_tanam_awal,tahun_tanam_akhir)
	{
		loadInput('validasi/input_foto/'+fid_unit+'/'+no_petak+'/'+tahun_tanam_awal+'/'+tahun_tanam_akhir);
	
	}
	function detail(tanggal)
	{
		loadInput('validasi/detail/'+tanggal);
	
	}
	
	function panggil_debitur(id) {
		url = "<?php echo site_url('validasi/validasi/get_by_id')?>";
		$.ajax({
			url : url,
			type: "POST",
			data: {id:id},
			dataType: "JSON",
			success: function(data){ 
				 $('#id_drone').val("");
				$('#nama_kebun').val("");
				$('#status_kualitas').val("");
				$('#keterangan').val("");
				
				$('#staticBackdrop1').modal('show');
				$('#id_drone').val(data[0].id_drone);
				$('#nama_kebun').val(data[0].nama_kebun); 
				

				// data[0].id_debitur
				// data[0].nama_debitur
			}
		});
		
	}
	function backToList()
	{
		$('#main-input').hide();
		$('#main-list').show();
	
	}
	
	function acceptAll(tanggal)
	{
				swal({
			title: "Apakah Anda sudah Memvalidasi semua data?",
			icon: "warning",
			buttons: {
			  cancel: "Batal",
			  confirm: "Ya",
			},
			dangerMode: true,
		  }).then((willAccept) => {
			if (willAccept) {
			  $.post(
				site_url + "validasi/validasi/approve/" + tanggal,
				{},
				function (result) {
				  if (result.error) {
					swal("Error", result.error, "error");
				  } else {
					swal("Sukses", result.message, "success");
					loadPageList(1);
					// $.post(site_url+"approve_kabag/approve_kabag/page"
				  }
				},
				"json"
			  );
			}
		  });
	}
	
</script>

 

<div id="content">
<div class="innerAll spacing-x2"><h4 class="portlet-title"><?=$title?></h4>
	<div class="widget widget-inverse" id="main-list">
		
		<div class="widget-head">
			<h4 class="heading"></h4>
		</div>
		
		
		<div class="widget-body padding-bottom-none">
			<div id="content-list">
			</div>
		</div>
	
	</div>

	<div id="main-input">
	</div>
</div>
<!--
Author: Upri
-->