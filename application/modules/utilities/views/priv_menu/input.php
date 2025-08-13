<div class="container-fluid">
	<div class="block-header">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-12">
				<h2>Administrator User (Setting User)</h2>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.html"><i class="fa fa-dashboard"></i></a></li>
					<li class="breadcrumb-item">Utility</li>
					<li class="breadcrumb-item active">Administrator User (Setting User)</li>
				</ul>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-12">
				<div class="d-flex flex-row-reverse">
					<div class="page_action">
						<button type="button" class="btn btn-primary" onClick="backToList();"><i class="fa fa-arrow-left"></i> Kembali</button>
					</div>
					<div class="p-2 d-flex">

					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row clearfix">
		<div class="card">
			<div class="body">
				<form class="form-horizontal margin-none" id="submitForm" method="post" autocomplete="off" novalidate="novalidate">
					<div class="card-body">
						<input class="form-control" style="width: 500px;" id="id_ms_operator" name="t_id_ms_operator" type="hidden" value="<?= $operator['id_ms_operator'] ?>">
						<input class="form-control" style="width: 500px;" id="fid_unit" name="t_fid_unit" type="hidden" value="<?= $operator['fid_lokasi_kerja'] ?>">
						<div class="form-group">
							<label class="control-label">Username :</label>
							<div class="col-md-12">
								<input class="form-control" id="nama_jabatan" name="t_nama_jabatan" type="text" value="<?= $operator['username'] ?>" readonly>
							</div>
						</div><br>

						<?php
						// Group menu berdasarkan parent
						$groupedMenu = [];
						foreach ($menu as $menus) {
							$groupedMenu[$menus->fid_app_menu][] = $menus;
						}

						$permissions = ['create', 'read', 'update', 'delete', 'export', 'approve'];

						function badgeClass($type)
						{
							switch ($type) {
								case 'utama':
									return 'badge-soft-primary';
								case 'sub_menu1':
									return 'badge-soft-warning';
								case 'sub_menu2':
									return 'badge-soft-info';
								default:
									return 'badge-soft-secondary';
							}
						}
						?>

						<div class="accordion" id="accordionMenu">
							<?php foreach ($groupedMenu[0] as $mainIndex => $mainMenu): ?>
								<?php
								$collapseId = "collapseMenu_" . $mainMenu->id_app_menu;
								?>
								<div class="accordion-item mb-2">
									<h2 class="accordion-header" id="heading_<?= $mainMenu->id_app_menu ?>">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $collapseId ?>" aria-expanded="false" aria-controls="<?= $collapseId ?>">
											<div class="form-check form-switch me-3">
												<input class="form-check-input" type="checkbox" name="menus[]" value="<?= $mainMenu->id_app_menu ?>" id="akses_<?= $mainMenu->id_app_menu ?>"
													<?= in_array($mainMenu->id_app_menu, $menu_user) ? 'checked' : '' ?>>
											</div>
											<label class="form-check-label fw-bold" for="akses_<?= $mainMenu->id_app_menu ?>">
												<?= $mainMenu->title ?>
												<span class="badge badge-pill <?= badgeClass($mainMenu->app_type) ?> font-size-11"><?= ucfirst($mainMenu->app_type) ?></span>
											</label>
										</button>
									</h2>
									<div id="<?= $collapseId ?>" class="accordion-collapse collapse" aria-labelledby="heading_<?= $mainMenu->id_app_menu ?>" data-bs-parent="#accordionMenu">
										<div class="accordion-body">
											<!-- Sub Menu 1 -->
											<?php if (isset($groupedMenu[$mainMenu->id_app_menu])): ?>
												<?php foreach ($groupedMenu[$mainMenu->id_app_menu] as $subMenu1): ?>
													<div class="row align-items-center ms-2 mt-2">
														<div class="col-md-4">
															<div class="form-check form-switch">
																<input class="form-check-input" type="checkbox" name="menus[]" value="<?= $subMenu1->id_app_menu ?>" id="akses_<?= $subMenu1->id_app_menu ?>"
																	<?= in_array($subMenu1->id_app_menu, $menu_user) ? 'checked' : '' ?>>
																<label class="form-check-label" for="akses_<?= $subMenu1->id_app_menu ?>">
																	<?= $subMenu1->title ?>
																	<span class="badge badge-pill <?= badgeClass($subMenu1->app_type) ?> font-size-11"><?= ucfirst($subMenu1->app_type) ?></span>
																</label>
															</div>
														</div>
													</div>

													<!-- Sub Menu 2 + permission -->
													<?php if (isset($groupedMenu[$subMenu1->id_app_menu])): ?>
														<?php foreach ($groupedMenu[$subMenu1->id_app_menu] as $subMenu2): ?>
															<div class="row align-items-start ms-5 mt-2">
																<div class="col-md-4">
																	<div class="form-check form-switch">
																		<input class="form-check-input" type="checkbox" name="menus[]" value="<?= $subMenu2->id_app_menu ?>" id="akses_<?= $subMenu2->id_app_menu ?>"
																			<?= in_array($subMenu2->id_app_menu, $menu_user) ? 'checked' : '' ?>>
																		<label class="form-check-label" for="akses_<?= $subMenu2->id_app_menu ?>">
																			<?= $subMenu2->title ?>
																			<span class="badge badge-pill <?= badgeClass($subMenu2->app_type) ?> font-size-11"><?= ucfirst($subMenu2->app_type) ?></span>
																		</label>
																	</div>
																</div>
																<div class="col-md-8">
																	<div class="table-responsive">
																		<table class="table table-bordered table-sm w-auto mb-0">
																			<thead class="table-light text-center">
																				<tr>
																					<?php foreach ($permissions as $perm): ?>
																						<th class="px-3"><?= ucfirst($perm) ?></th>
																					<?php endforeach; ?>
																				</tr>
																			</thead>
																			<tbody>
																				<tr class="text-center">
																					<?php foreach ($permissions as $perm): ?>
																						<td>
																							<input class="form-check-input" type="checkbox"
																								name="permissions[<?= $subMenu2->id_app_menu ?>][]" value="<?= $perm ?>"
																								<?= isset($user_permissions[$subMenu2->id_app_menu]) && in_array($perm, $user_permissions[$subMenu2->id_app_menu]) ? 'checked' : '' ?>
																								id="<?= $perm ?>_<?= $subMenu2->id_app_menu ?>">
																						</td>
																					<?php endforeach; ?>
																				</tr>
																			</tbody>
																		</table>
																	</div>
																</div>
															</div>

														<?php endforeach; ?>
													<?php endif; ?>
												<?php endforeach; ?>
											<?php endif; ?>

										</div>
									</div>
								</div>
							<?php endforeach; ?>
							<div class="form-actions pull-right">
								<a href="javascript:void(0);" class="btn btn-success" onClick="save_hirarki();"><i class="fa fa-floppy-o"></i> Simpan</a>
							</div>
						</div>
						<br>
						<br>
					</div>

				</form>

			</div>
		</div>
	</div>
</div>


<script>
	var site_url = "<?= site_url() ?>";
</script>
<script type="text/javascript">
	$(document).ready(function() {
		setTitle('<?= $title ?>');
		$("#unit").select2({
			placeholder: "-- Pilih --",
			allowClear: true
		});
	});
	$(document).ready(function() {
		$('#submit').submit(function(e) {
			e.preventDefault();
			$.ajax({
				url: '<?php echo base_url(); ?>utilities/priv_menu/save_hirarki',
				type: "post",
				data: new FormData(this),
				processData: false,
				contentType: false,
				cache: false,
				async: false,
				dataType: "json",
				success: function(data) {
					if (data.error) {
						pesan_error(data.error);
						loadPageList(1);
					} else {
						pesan_success(data.message);
						$('#id_ktp').val(data.id_ktp);
						backToList();
						loadPageList(1);
					}
				}
			});
		});

	});

	function save_hirarki() {
		$.post(site_url + 'utilities/priv_menu/save_hirarki', $('#submitForm').serialize(), function(result) {
			if (result.error) {
				pesan_error(result.error);
			} else {
				alert('Data berhasil diinput');
				pesan_success(result.message);
				$('#id_bsm').val(result.id_bsm);
				loadPageList(1);
				pesan_validasi(pesan)
			}
		}, "json");
	}


	function validate_angka(evt) {
		var theEvent = evt || window.event;
		var key = theEvent.keyCode || theEvent.which;
		key = String.fromCharCode(key);
		var regex = /[0-9]|\./;
		if (!regex.test(key)) {
			theEvent.returnValue = false;
			if (theEvent.preventDefault) theEvent.preventDefault();
		}
	}
</script>

</div>
</div>
</div>
</div>
</div>