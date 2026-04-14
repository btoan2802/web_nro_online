<?php require_once('core/config.php'); ?>
<?php require_once('core/head.php'); ?>

<main>
	<!-- Các nút chuyển đổi -->
	<div style="text-align: center; margin-bottom: 20px;">
		<button id="btnTopNhiemVu" class="btn btn-action text-white" style="border-radius: 5px;" onclick="showTab('topNhiemVu')">Nhiệm Vụ</button>
		<button id="btnTopSucManh" class="btn btn-action text-white" style="border-radius: 5px;" onclick="showTab('topSucManh')">Sức Mạnh</button>
		<button id="btnTopNap" class="btn btn-action text-white" style="border-radius: 5px;" onclick="showTab('topNap')">Nạp Coin</button>
	</div>

	<!-- Bảng Top Nhiệm Vụ -->
	<div id="topNhiemVu" class="tab-content" style="display: block;">
		<div class="p-1 mt-1 ibox-content"
			style="background-color: rgba(254, 217, 0, 0.9); border-radius: 7px; box-shadow: 0px 2px 5px black;">
			<div class="p-1 text-white">
				<h5 class="h3 mb-3 font-weight-normal text-white"
					style="text-align:center;padding-top: 3px; font-weight: bold; text-shadow: 2px 2px 2px #000;">Top
					Nhiệm Vụ</h5>
				<div class="p-1 mt-1 ibox-content" style="border-radius: 7px; box-shadow: 0px 0px 5px black;">
					<div class="table-responsive">
						<table class="table table-hover table-custom" style="text-align: center;">
							<thead>
								<tr>
									<th>TOP</th>
									<th>Nhân Vật</th>
									<th>ID</th>
									<th>Nhiệm Vụ</th>
									<th>Tiến Độ</th>
								</tr>
							</thead>
							<tbody>
								<?php
								// Lấy toàn bộ template nhiệm vụ chính
								$mainTasks = [];
								$resMain = $config->query("SELECT id, NAME FROM task_main_template");
								if ($resMain) {
									while($mRow = $resMain->fetch_assoc()) {
										$mainTasks[$mRow['id']] = $mRow['NAME'];
									}
								}

								// Lấy toàn bộ template nhiệm vụ phụ để tra cứu nhanh
								$allSubTasks = [];
								$resSub = $config->query("SELECT task_main_id, NAME, max_count FROM task_sub_template ORDER BY task_main_id ASC, keyid ASC");
								if ($resSub) {
									while($sRow = $resSub->fetch_assoc()) {
										// Sử dụng NAME (viết hoa) theo schema database
										$allSubTasks[$sRow['task_main_id']][] = $sRow;
									}
								}

								// Truy vấn SQL và hiển thị dữ liệu như ban đầu
								$query = "SELECT name, gender, player.id, CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(data_task, ',', 1), '[', -1) AS UNSIGNED) AS nv,
                                      CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(data_task, ',', 2), ',', -1) AS UNSIGNED) AS nv1,
                                      CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(data_task, ',', 3), ',', -1) AS UNSIGNED) AS nv2
                                      FROM player
                                      INNER JOIN account ON account.id = player.account_id
                                      WHERE account.is_admin = 0 AND account.ban = 0
                                      ORDER BY 
                                      nv DESC,
                                      nv1 DESC,
                                      nv2 DESC
                                      LIMIT 30;";
								$result = $config->query($query);
								$stt = 1;
								if ($result === false) {
									echo 'Lỗi truy vấn SQL: ' . $config->error;
								} elseif ($result->num_rows > 0) {
									while ($row = $result->fetch_assoc()) {
										$taskName = "Nhiệm vụ " . $row['nv'];
										if (isset($mainTasks[$row['nv']])) {
											$taskName = $mainTasks[$row['nv']];
										}

										$progress = "---";
										if (isset($allSubTasks[$row['nv']])) {
											$subIndex = $row['nv1'];
											$subTask = isset($allSubTasks[$row['nv']][$subIndex]) ? $allSubTasks[$row['nv']][$subIndex] : null;
											if ($subTask) {
												$taskName = $subTask['NAME'];
												$taskName = str_replace(['%1', '%2', '%3', '%4'], ['...', '...', '...', '...'], $taskName);
												
												if ($subTask['max_count'] > 0) {
													$progress = '<span class="badge bg-primary">' . $row['nv2'] . '/' . $subTask['max_count'] . '</span>';
												} else {
													$progress = '<span class="badge bg-secondary">Xong</span>';
												}
											}
										}

										echo '<tr>
                                    <td>' . $stt . '</td>
                                    <td>' . $row['name'] . ' <small class="text-muted">#' . $row['id'] . '</small></td>
                                    <td>' . $row['nv'] . '</td>
                                    <td>' . $taskName . '</td>
                                    <td>' . $progress . '</td>
                                    </tr>';
										$stt++;
									}
								} else {
									echo '<tr><td colspan="5" align="center"><span style="font-size:100%;"><< Lịch Sử Trống >></span></td></tr>';
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Bảng Top Sức Mạnh -->
	<div id="topSucManh" class="tab-content" style="display: none;">
		<div class="p-1 mt-1 ibox-content"
			style="background-color: rgba(254, 217, 0, 0.9); border-radius: 7px; box-shadow: 0px 2px 5px black;">
			<div class="p-1 text-white">
				<h5 class="h3 mb-3 font-weight-normal text-white"
					style="text-align:center;padding-top: 3px; font-weight: bold; text-shadow: 2px 2px 2px #000;">Top
					Sức Mạnh</h5>
				<div class="p-1 mt-1 ibox-content" style="border-radius: 7px; box-shadow: 0px 0px 5px black;">
					<div class="table-responsive">
						<table class="table table-hover table-custom" style="text-align: center;">
							<thead>
								<tr>
									<th>TOP</th>
									<th>Tên</th>
									<th>Sức Mạnh</th>
								</tr>
							</thead>
							<tbody>
								<?php
								// Truy vấn SQL và hiển thị dữ liệu như ban đầu
								$query = "SELECT name, gender, player.id, CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(data_point, ',', 2), ',', -1) AS UNSIGNED) AS sm
                                    FROM player
                                    INNER JOIN account ON account.id = player.account_id
                                    WHERE account.is_admin = 0 AND account.ban = 0
                                    ORDER BY sm DESC
                                    LIMIT 30;";
								$result = $config->query($query);
								$stt = 1;
								if ($result === false) {
									echo 'Lỗi truy vấn SQL: ' . $config->error;
								} elseif ($result->num_rows > 0) {
									while ($row = $result->fetch_assoc()) {
										$biensm = $row['sm'];
										$tongsm = $biensm;
										echo '<tr>
                                    <td>' . $stt . '</td>
                                    <td>' . $row['name'] . '</td>
                                    <td>' . number_format($biensm). '</td>
                                    </tr>';
										$stt++;
									}
								} else {
									echo '<tr><td colspan="5" align="center"><span style="font-size:100%;"><< Lịch Sử Trống >></span></td></tr>';
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Bảng Top Nạp -->
	<div id="topNap" class="tab-content" style="display: none;">
		<div class="p-1 mt-1 ibox-content"
			style="background-color: rgba(254, 217, 0, 0.9); border-radius: 7px; box-shadow: 0px 2px 5px black;">
			<div class="p-1 text-white">
				<h5 class="h3 mb-3 font-weight-normal text-white"
					style="text-align:center;padding-top: 3px; font-weight: bold; text-shadow: 2px 2px 2px #000;">Top
					Nạp</h5>
				<div class="p-1 mt-1 ibox-content" style="border-radius: 7px; box-shadow: 0px 0px 5px black;">
					<div class="table-responsive">
						<table class="table table-hover table-custom" style="text-align: center;">
							<thead>
								<tr>
									<th>TOP</th>
									<th>Tên</th>
									<th>Tổng nạp</th>
								</tr>
							</thead>
							<tbody>
							<?php
								// Truy vấn SQL và hiển thị dữ liệu như ban đầu
								$query = "SELECT * FROM player INNER JOIN account ON account.id = player.account_id WHERE account.is_admin = 0 AND account.ban = 0 AND account.tongnap > 0 ORDER BY account.tongnap DESC LIMIT 30";
								$result = $config->query($query);
								$stt = 1;
								if ($result === false) {
									echo 'Lỗi truy vấn SQL: ' . $config->error;
								} elseif ($result->num_rows > 0) {
									while ($row = $result->fetch_assoc()) {
										echo '<tr>
                                    <td>' . $stt . '</td>
                                    <td>' . $row['name'] . '</td>
                                    <td>' . number_format($row['tongnap']) . '<sup>đ</sup></td>
                                    </tr>';
										$stt++;
									}
								} else {
									echo '<tr><td colspan="3" align="center"><span style="font-size:100%;"><< Lịch Sử Trống >></span></td></tr>';
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

</main>
<script>
	function showTab(tabId) {
		// Ẩn tất cả các bảng
		var tabs = document.querySelectorAll('.tab-content');
		tabs.forEach(function (tab) {
			tab.style.display = 'none';
		});

		// Hiển thị bảng đã chọn
		var activeTab = document.getElementById(tabId);
		if (activeTab) {
			activeTab.style.display = 'block';
		}
	}
</script>


<?php require_once('core/end.php'); ?>