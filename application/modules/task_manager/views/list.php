 <script type="text/javascript" src="/path/to/jquery-latest.js"></script>
 <script type="text/javascript" src="/path/to/jquery.tablesorter.js"></script>
 <style>
 	.image-link {
 		display: flex;
 		align-items: center;
 		text-decoration: none;
 		justify-content: center;
 	}

 	.image-container {
 		position: relative;
 	}

 	.angka {

 		position: absolute;
 		top: 10px;
 		right: 0;
 		background-color: #007bff;
 		color: #fff;
 		/* Warna teks putih */
 		border-radius: 50%;
 		padding: 5px 10px;
 		font-size: 16px;
 	}
 </style>
 <script async src="//www.instagram.com/embed.js"></script>
 <div class="page-content">
 	<div class="container-fluid">

 		<!-- start page title -->
 		<div class="row">
 			<div class="col-12">
 				<div class="page-title-box d-sm-flex  align-items-center justify-content-between">
 					<h4 class="mb-sm-0 font-size-18">Task Management</h4>

 					<div class="page-title-right">
 						<ol class="breadcrumb m-0">
 							<li class="breadcrumb-item"><a href="javascript: void(0);">Siraja / </a></li>
 							<a href="#" onclick="loadMainContent('task_manager/task_manager/index')" class="image-link">
 								<li class="breadcrumb-item active"> Task Management</li>
 							</a>
 						</ol>
 					</div>

 				</div>
 			</div>
 		</div>
 		<!-- end page title -->


 		<div class="row">
 			<div class="col-xl-2">

 				<div class="card">
 					<br>
 					<div>
 						<center>
 							<a href="#" onclick="loadMainContent('ajuan_tm/ajuan_tm/index')" class="image-link">
 								<img src="/siRaja_new/assets/images/input_tm.png" title="" style="width:100px;height:100px;">
 							</a>

 							<div class="card-body">
 								<h4 class="card-title mt-0">Task Request</h4>
 							</div>
 						</center>
 					</div>


 				</div>

 			</div>


 			<div class="col-xl-2">
 				<div class="card">
 					<br>
 					<center>
 						<a href="#" onclick="loadMainContent('approve_atasan_tm/approve_atasan_tm/index')" class="image-link">
 							<img src="/siRaja_new/assets/images/approved_atasan.png" title="" style="width:100px;height:100px;">
 							<h4 class="angka mt-0">* <?= $app_atasan ?></h4>
 						</a>
 						<div class="card-body">
 							<h4 class="card-title mt-0">Supervisor Approval</h4>
 						</div>
 					</center>


 				</div>

 			</div>


 			<div class="col-xl-2">
 				<div class="card">
 					<br>
 					<center>
 						<a href="#" onclick="loadMainContent('approve_it_tm/approve_it_tm/index')" class="image-link">
 							<img src="/siRaja_new/assets/images/approved_it.png" title="" style="width:100px;height:100px;">
 							<h4 class="angka mt-0">* <?= $app_it ?></h4>
 						</a>
 						<div class="card-body">
 							<h4 class="card-title mt-0">Technical Review</h4>

 						</div>
 					</center>

 				</div>

 			</div>


 			<div class="col-xl-2">
 				<div class="card">
 					<br>
 					<center>
 						<a href="#" onclick="loadMainContent('perlu_tl/perlu_tl/index')" class="image-link">
 							<img src="/siRaja_new/assets/images/sedang_tl.png" title="" style="width:100px;height:100px;">
 							<h4 class="angka mt-0">* <?= $perlu_tl ?></h4>
 						</a>
 						<div class="card-body">
 							<h4 class="card-title mt-0">Task Preparation</h4>

 						</div>
 					</center>

 				</div>

 			</div>




 			<div class="col-xl-2">
 				<div class="card">
 					<br>
 					<center>
 						<a href="#" onclick="loadMainContent('proses_tl/proses_tl/index')" class="image-link">
 							<img src="/siRaja_new/assets/images/perlu_tl.png" title="" style="width:100px;height:100px;">
 							<h4 class="angka mt-0">* <?= $proses_tl ?></h4>
 						</a>
 						<div class="card-body">
 							<h4 class="card-title mt-0">In Progress</h4>

 						</div>
 					</center>

 				</div>

 			</div>

 			<div class="col-xl-2">
 				<div class="card">
 					<br>
 					<center>
 						<a href="#" onclick="loadMainContent('arsip_tm/arsip_tm/index')" class="image-link">
 							<img src="/siraja/assets/images/complated.jpg" title="" style="width:100px;height:100px;">

 						</a>
 						<div class="card-body">
 							<h4 class="card-title mt-0">Completed</h4>

 						</div>
 					</center>

 				</div>

 			</div>



 		</div>






 		<!-- end page title -->


 		<!-- end row -->



 		<!-- end row -->


 		<!-- end table-responsive -->
 	</div>
 </div>