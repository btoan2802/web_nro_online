<?php
include __DIR__ . '/../../core/config.php';
include 'head.php';
$data = "SELECT SUM(account.tongnap) AS total_vnd
		FROM player INNER JOIN account ON account.id = player.account_id
		WHERE account.is_admin = 0;";
$result = mysqli_query($config, $data);
$row = $result ? mysqli_fetch_array($result) : ['total_vnd' => 0];

$dataf = "SELECT SUM(amount) AS atm FROM mb_bank WHERE status = 1;";
$resultf = mysqli_query($config, $dataf);
$rowf = $resultf ? mysqli_fetch_array($resultf) : ['atm' => 0];

$datak = "SELECT COUNT(*) as total FROM account WHERE active = 1 AND account.is_admin = 0";
$resultk = mysqli_query($config, $datak);
$rowk = $resultk ? mysqli_fetch_array($resultk) : ['total' => 0];
$totalActiveAccounts = $rowk['total'];

$data1 = "SELECT SUM(amount) AS total_the FROM trans_log WHERE status = 1;";
$result1 = mysqli_query($config, $data1);
$row1 = $result1 ? mysqli_fetch_array($result1) : ['total_the' => 0];

$darut = 0;
$tongdoangthu = ($row1['total_the'] * 80 / 100) + $rowf['atm'] - $darut;

$dataac = "SELECT COUNT(*) as total_player FROM player";
$resultac = mysqli_query($config, $dataac);
$rowac = $resultac ? mysqli_fetch_array($resultac) : ['total_player' => 0];
$totalPlayer = $rowac['total_player'];

$datatt = "SELECT COUNT(*) as total_acc FROM account WHERE account.ban = 0 AND account.is_admin = 0";
$resulttt = mysqli_query($config, $datatt);
$rowtt = $resulttt ? mysqli_fetch_array($resulttt) : ['total_acc' => 0];
$totalAccounts = $rowtt['total_acc'];
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
											<h2>QUẢN LÝ SERVER</h2>
											<span>PANE ADMIN</span>
										</div>
									</div>
								</div>
							</div>

							<div class="col-xl-6 col-sm-6">
								<div class="card">
									<div class="card-body d-flex px-4  justify-content-between">
										<div>
											<div class="">
												<h2 class="fs-32 font-w700">Tổng Account</h2>
												<span class="fs-20 font-w600 d-block">
													<a style="color:#ff0000;">
														<?php echo $totalAccounts ?> Account
													</a>
												</span>
											</div>
										</div>
										<!-- <div id="NewCustomers1"></div> -->
									</div>
								</div>
							</div>


							<div class="col-xl-6 col-sm-6">
								<div class="card">
									<div class="card-body d-flex px-4  justify-content-between">
										<div>
											<div class="">
												<h2 class="fs-32 font-w700">Tổng người chơi</h2>
												<span class="fs-20 font-w600 d-block">
													<a style="color:#ff0000;">
														<?php echo $totalPlayer ?> Player
													</a>
												</span>

											</div>
										</div>
										<!-- <div id="NewCustomers"></div> -->
									</div>
								</div>
							</div>

							<div class="col-xl-6 col-sm-6">
								<div class="card">
									<div class="card-body d-flex px-4  justify-content-between">
										<div>
											<div class="">
												<h2 class="fs-32 font-w700">Tổng MTV</h2>
												<span class="fs-20 font-w600 d-block">
													<a style="color:#ff0000;">
														<?php echo $totalActiveAccounts ?> Tài khoản
													</a>
												</span>
											</div>
										</div>
										<!-- <div id="NewCustomers1"></div> -->
									</div>
								</div>
							</div>

							<div class="col-xl-6 col-sm-6">
								<div class="card">
									<div class="card-body d-flex px-4  justify-content-between">
										<div>
											<div class="">
												<h2 class="fs-32 font-w700">Tổng Doanh Thu</h2>
												<span class="fs-20 font-w600 d-block">
													<a style="color:#ff0000;">
														<?php echo number_format($tongdoangthu) ?><sup>đ</sup>
													</a>
												</span>
												<br>
												<span class="fs-18 font-w500 d-block">
													<a style="color:#0035ff;">
														- ATM: <?php echo number_format($rowf['atm']) ?><sup>đ</sup>
													</a>
												</span>
												<span class="fs-18 font-w500 d-block">
													<a style="color:#0CC0DF;">
														- Thẻ Cào:
														<?php echo number_format($row1['total_the'] * 80 / 100) ?><sup>đ</sup>
													</a>
												</span>
											</div>
										</div>
										<!-- <div id="NewCustomers2"></div> -->
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
</div>
</div>
</div>
<div class="footer">
	<div class="copyright">
		<p>Developed by VietNguyen</p>
	</div>
</div>