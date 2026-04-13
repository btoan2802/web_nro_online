<?php
include '../head.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (!empty($_POST['name']) && !empty($_POST['vnd'])) {
		$row = sql::Select("account", "username", $_POST['name']);
		if ($row) {
			sql::update("account", "vnd", $row['vnd'] + $_POST['vnd'], "id", $row['id']);
			sql::update("account", "tongnap", $row['tongnap'] + $_POST['tongnap'], "id", $row['id']);
			echo '
 <script>
alert("Cộng vnd thành công");
</script>';
		} else {
			echo '
 <script>
alert("Tài Khoản không tồn tại");
</script>';
		}
	} else {
		echo '
 <script>
alert("vui lòng nhập đầy đủ thông tin!");
</script>
   ';
	}
}
?>

<!--**********************************
			Sidebar end
		***********************************-->

<!--**********************************
			Content body start
		***********************************-->
<div class="content-body">
	<!-- row -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-xl-12">
				<div class="row">
					<div class="col-xl-6">
						<div class="row">
							<div class="col-xl-12">
								<div class="card tryal-gradient">
									<div class="card-body tryal row">
										<div class="col-xl-7 col-sm-6">
											<h2>BUFF VNĐ</h2>
											<span>CỘNG VNĐ</span>
										</div>
										<div class="col-xl-5 col-sm-6">
										</div>
									</div>
								</div>
							</div>

							<!-- <div class="col-xl-6 col-sm-6"> -->
								<div class="card">
									<div class="card-body px-4  justify-content-between">
										<div>
											<form method="POST">
												<input name="name" class="form-control fs-18 font-weight-bold d-block"
													placeholder="Tên Tài Khoản">
												</br>
												<input type="number" name="vnd"
													class="form-control fs-18 font-weight-bold d-block"
													placeholder="VNĐ">
												</br>
												<button class="btn btn-primary btn-lg font-weight-bold fs-18">Cộng
													Tiền</button>

											</form>
										</div>
									</div>
								</div>
							<!-- </div> -->




						</div>

					</div>
				</div>

			</div>
		</div>
	</div>
</div>
</div>
</div>
</div>
<!--**********************************
			Content body end
		***********************************-->




<!--**********************************
			Footer start
		***********************************-->
<?php include '../end.php'; ?>