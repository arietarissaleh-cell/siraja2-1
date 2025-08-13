<table class="dynamicTable tableTools table table-striped checkboxs">

	<!-- Table heading -->
	<thead>
		<tr>
			<th class="text-center">
				#
			</th>
			<th>Unit</th>
			<th>Kode Kebun</th>
			<th>No. Petak</th>
			<th>Nama Kebun</th>
			<th>Detail</th>
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
		
		?>
		<tr class="gradeX">
			<td><?= $no++;?></td>
			<td><?= $row['fid_unit'].' - '.$row['nama_unit']?></td>
			<td><?= match_key($row['kode_kebun'],$key['kode_kebun'])?></td>
			<td><?= match_key($row['no_petak'],$key['no_petak'])?></td>
			<td><?= match_key($row['nama_kebun'],$key['nama_kebun'])?></td>
			<td>
				<input type="hidden" id="username_<?=$row['fid_unit'].'_'.$row['kode_kebun']?>" value="<?=$row['kode_kebun']?>">
				<a href="javascript:void(0);" data-dismiss="modal" onClick="lookupSelectKodeKebun('<?=$row['kode_kebun']?>')" title=" : <?=$row['kode_kebun']?>"><i class="btn btn-success"> Pilih </i></a>
			</td>
		</tr>
		
		<?php 
		
		}?>
	</tbody>
	<!-- // Table body END -->
	
</table>
<?= $paging['list']?>
<!--
Author: Rickytarius
Author URL: http://www.bayssl.com
28052016
-->