<table class="dynamicTable tableTools table table-striped checkboxs">

	<!-- Table heading -->
	<thead>
		<tr>
			<th class="text-center">
				#
			</th>
			<th>Username</th>				
			<th>Nama Karyawan</th>
			<th>Unit</th>
		</tr>
	</thead>
	<!-- // Table heading END -->
	
	<!-- Table body -->
	<tbody>
		<?php 
		$no = ($paging['current']-1) * $paging['limit'] ;
		$no++;
		foreach($user_list->result_array() as $row)
		{
		
		?>
		<tr class="gradeX">
			<td><?= $no++;?></td>
			<td><?= $row['username']?></td>				
			<td><?= $row['nama_depan'].' '.$row['nama_belakang']?></td>
			<td><?= $row['fid_unit'].' - '.$row['nama_unit']?></td>
			<td>
				<input type="hidden" id="username_<?=$row['id_ms_operator']?>" value="<?=$row['id_ms_operator']?>">
				<a href="javascript:void(0);" onClick="editData('<?=$row['fid_unit']?>','<?=encode($row['id_ms_operator'])?>')" title="Edit : <?=$row['id_ms_operator']?>"><i class="fa fa-pencil-square-o"></i></a>
				<a href="javascript:void(0);" onClick="deleteConfirm('<?= ($row['id_ms_operator'])?>','<?= ($row['id_ms_operator'])?>')" title="Delete : <?=$row['id_ms_operator']?>"><i class="fa fa-trash-o"></i></a>
			
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