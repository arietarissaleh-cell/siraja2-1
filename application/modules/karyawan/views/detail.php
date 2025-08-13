<script src="<?= base_url();?>/assets/components/modules/admin/forms/elements/uniform/assets/lib/js/jquery.uniform.min.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/modules/admin/forms/elements/uniform/assets/custom/js/uniform.init.js?v=v1.2.3"></script>

<script type="text/javascript">
	//$(document).ready(function(){
		setTitle('<?= $title?>');		
		
	
</script>

<form class="form-horizontal margin-none" id="submitForm" method="get" autocomplete="off" novalidate="novalidate">
	
	<div class="widget widget-inverse"  id="main-list">
		<div class="widget-head">
			<h4 class="heading"><i class="fa fa-fw fa-user"></i><?=$title?></h4>
			<div class="btn-group btn-group-xs pull-right">
				<a href="javascript:void(0);" class="btn btn-inverse" onClick="backToList();"title="Kembali"><i class="fa fa-arrow-left"></i></a>
			</div>
		</div>
		<div class="widget-body">
			<input class="form-control" id="id_karyawan" name="t_id_karyawan" type="hidden" value="<?= encode($karyawan['id_karyawan'])?>">
			<div class="innerB">

	<table class="dynamicTable tableTools table table-striped checkboxs">

	<!-- Table body -->
	<tbody>
		<tr class="gradeX">
			<td>Nama Karyawan</td>
			<td>:</td>
			<td><?=$detail_data['nama_depan']?></td>
		</tr>
		<tr class="gradeX">
			<td>NIK</td>
			<td>:</td>
			<td><?=$detail_data['nik']?></td>
		</tr>
		<tr class="gradeX">
			<td>Unit</td>
			<td>:</td>
			<td><?=$detail_data['nama_unit']?></td>
		</tr>
		<!-- <tr class="gradeX">
			<td>Bidang</td>
			<td>:</td>
			<td><?=$detail_data['nama_bidang']?></td>
		</tr> -->
		<tr class="gradeX">
			<td>Bagian</td>
			<td>:</td>
			<td><?=$detail_data['nama_bagian']?></td>
		</tr>
		<tr class="gradeX">
			<td>Tanggal Masuk</td>
			<td>:</td>
			<td><?=$detail_data['tanggal_diangkat']?></td>
		</tr>
		<tr class="gradeX">
			<td>Masa Kerja</td>
			<td>:</td>
			<td><?=$detail_data['jml_tahun_kerja'].' tahun '.$detail_data['jml_bulan_kerja'].' bulan '.$detail_data['jml_hari_kerja'].' hari'?></td>
		</tr>
		<tr class="gradeX">
			<td>Jabatan</td>
			<td>:</td>
			<td><?=$detail_data['nama_jabatan']?></td>
		</tr>
		<tr class="gradeX">
			<td>Golongan</td>
			<td>:</td>
			<td><?=$detail_data['deskripsi']?></td>
		</tr>
		<tr class="gradeX">
			<td>Email</td>
			<td>:</td>
			<td><?=$detail_data['alamat_email']?></td>
		</tr>
		
	</tbody>
	<!-- // Table body END -->
	
</table>
										
			</div>								
		</div>
	</div>
	<!-- // Widget END -->
	
</form>
<!--
Author: Rickytarius
Author URL: http://www.bayssl.com
28052016
-->