<!-- Table -->
<div style="overflow: auto;max-height: 500px;">
<table class="dynamicTable tableTools table table-striped checkboxs">
<!--table class="table table-bordered table-white"-->

	<!-- Table heading -->
	<thead>
		<tr>
			<th rowspan="2" class="text-center">#</th>
			<!--th rowspan="2">Directory</th-->
			<th rowspan="2">No Petak</th>
			<th rowspan="2">Kode kebun</th>
			<th rowspan="2">Nama kebun</th>
			<th colspan="2">Musim Tanam</th>
			<th rowspan="2">Tgl Pemotretan</th>
			<th rowspan="2">Foto</th>
			<th rowspan="2">Catatan</th>
			<th rowspan="2">Action</th>
		</tr>
		<tr>
			<th>Awal</th>
			<th>Akhir</th>
		</tr>
	</thead>
	<!-- // Table heading END -->
	
	<!-- Table body -->
	<tbody>
		<?php 
		$no = ($paging['current']-1) * $paging['limit'] ;
		$no++;
		foreach($list->result_array() as $row)
		{
		$foto = $row['file_path'].'/thumbnails_60/'.$row['file_server_name'];
		if(!file_exists($foto)){
			$foto = $row['file_path'].'/'.$row['file_server_name'];
		}
		?>
		<tr class="gradeX">
			<td><?= $no++;?></td>
			<!--td><?//= $row['file_path']?></td-->
			<td><?= $row['no_petak']?></td>
			<td><?= $row['kode_kebun']?></td>
			<td><?= $row['nama_kebun']?></td>
			<td><?= $row['tahun_tanam_awal']?></td>
			<td><?= $row['tahun_tanam_akhir']?></td>
			<td><?= humanize_mdate($row['tgl_pemotretan'])?></td>
			<td><img src="<?= $foto?>" alt="<?=$row['real_name']?>"/></td> 
			<td><?= $row['remark']?></td>
			<td>
				<input type="hidden" id="real_name_<?=$row['id_file_upload']?>" value="<?=$row['real_name']?>">
				<a href="javascript:void(0);" onClick="loadInput('utilities/file_upload/input/<?= encode($row['id_file_upload'])?>')" title="Edit : <?=$row['real_name']?>"><i class="fa fa-pencil-square-o"></i></a>
				<a href="javascript:void(0);" onClick="deleteConfirm('<?= ($row['id_file_upload'])?>')" title="Edit : <?=$row['real_name']?>"><i class="fa fa-trash-o"></i></a>
			</td>
		</tr>
		
		<?php 
		
		}?>
	</tbody>
	<!-- // Table body END -->
	
</table>
</div>
<?= $paging['list']?>
<!--
Author: Rickytarius
Author URL: http://www.bayssl.com
28052016
-->