<table class="dynamicTable tableTools table table-striped checkboxs">

	<!-- Table heading -->
	<thead>
		<tr>
			<th class="text-center">
				#
			</th>
			<th>Nama Karyawan</th>
			<th>NIK</th>
			<th>Unit</th>		
			<th>Detail</th>
		</tr>
	</thead>
	<!-- // Table heading END -->
	
	<!-- Table body -->
	<tbody>
		<?php 
		$no = ($paging['current']-1) * $paging['limit'] ;
		$no++;
		foreach($karyawan_list->result_array() as $row)
		{
		
		?>
		<tr class="gradeX">
			<td><?= $no++;?></td>
			<td><?= $row['nama_depan']?></td>
			<td><?= $row['nik']?></td>
			<td><?= $row['fid_unit'].' - '.$row['nama_unit']?></td>		
			<td>
				<input type="hidden" id="username_<?=$row['id_karyawan']?>" value="<?=$row['nik']?>">
				<a href="javascript:void(0);" onClick="detailData('<?=$row['fid_unit']?>','<?=encode($row['id_karyawan'])?>')" title="Detail : <?=$row['nik']?>"><i class="fa fa-tasks"></i></a>
				<!-- <a href="javascript:void(0);" onClick="editData('<//?=$row['fid_unit']?>','<//?=encode($row['id_karyawan'])?>')" title="Edit : <//?=$row['nik']?>"><i class="fa fa-pencil-square-o"></i></a> -->
				<!-- <a href="javascript:void(0);" onClick="deleteConfirm('<//?= ($row['id_karyawan'])?>','<//?= ($row['nik'])?>')" title="Delete : <//?=$row['nik']?>"><i class="fa fa-trash-o"></i></a> -->
			
			</td>
		</tr>
		
		<?php 
		
		}?>
	</tbody>
	<!-- // Table body END -->
	
</table>
<?= $paging['list']?>
<!--
Author: Hariyo Koco
Author URL: http://www.koco.com
28052016
-->