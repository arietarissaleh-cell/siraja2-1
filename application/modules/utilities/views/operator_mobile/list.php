<!-- Table -->
<div style="overflow: auto;max-height: 500px;">
<table class="dynamicTable tableTools table table-striped checkboxs">
<!--table class="table table-bordered table-white"-->

	<!-- Table heading -->
	<thead>
		<tr>
			<th class="text-center">
				#
			</th>
			<th>Nama Lengkap</th>
			<th>Tgl Update</th>
			<th>Tgl Kadaluarsa</th>
			<th>Action</th>
		</tr>
	</thead>
	<!-- // Table heading END -->
	
	<!-- Table body -->
	<tbody>
		<?php 
		$no = ($paging['current']-1) * $paging['limit'] ;
		$no++;
		foreach($operator_mobile_list->result_array() as $row)
		{
		
		?>
		<tr class="gradeX">
			<td><?= $no++;?></td>
			<td><?= $row['username']?></td>
			<td><?= $row['last_update']?></td>
			<td><?= humanize_mdate($row['expiry_date'],'%d %M %Y')?></td>
			<td>
				<input type="hidden" id="username_<?=$row['id_ms_operator']?>" value="<?=$row['username']?>">
				<a href="javascript:void(0);" onClick="loadInput('utilities/operator_mobile/input/<?= encode($row['id_ms_operator'])?>')" title="Edit : <?=$row['username']?>"><i class="fa fa-pencil-square-o"></i></a>
				<a href="javascript:void(0);" onClick="deleteConfirm('<?= ($row['id_ms_operator'])?>')" title="Edit : <?=$row['username']?>"><i class="fa fa-trash-o"></i></a>
				<a href="javascript:void(0);" onClick="loadInput('utilities/priv_menu_mobile/input/<?= encode($row['id_ms_operator'])?>')" title="Privilege : <?=$row['username']?>"><i class="fa fa-sitemap"></i></a>
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