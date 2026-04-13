<?php
require_once('../core/config.php');
require_once('../core/head.php');

$thongbao = null;

// echo "19h Ngày 1/4 Sẽ Chính thức Mở khóa";
// exit;

if (isset($_SESSION['logger']['username'])) {
	echo '<script>window.location.href = "/";</script>';
	exit();
}

if (isset($_POST['submit']) && $_POST['username'] != '' && $_POST['password'] != '') {
	$username = $_POST['username'];
	$password = $_POST['password'];

	$username = mysqli_real_escape_string($config, $username);
	$password = mysqli_real_escape_string($config, $password);

	$sql = "SELECT * FROM account WHERE username = '$username' AND password = '$password'";
	$account = mysqli_query($config, $sql);

	if (mysqli_num_rows($account) > 0) {
		$_SESSION['logger']['username'] = $username;
		$_SESSION['logger']['password'] = $password;
		$_SESSION['account'] = $username;

		$thongbao = 'Đăng nhập thành công';

		$script = '
			var thongbao = ' . json_encode($thongbao) . ';
			if (thongbao !== "") {
				Swal.fire({
					title: "Thành Công",
					html: thongbao,
					icon: "success",
					confirmButtonText: "Đóng",
					allowOutsideClick: () => Swal.getConfirmButton().click()
				}).then((result) => {
					if (result.isConfirmed) {
						window.location.href = "/";
					}
				});
			}
		';

		echo '<script>' . $script . '</script>';
	} else {
		$thongbao = 'Sai tài khoản hoặc mật khẩu!';

		$script = '
			var thongbao = ' . json_encode($thongbao) . ';
			if (thongbao !== "") {
				Swal.fire({
					title: "Thất Bại",
					html: thongbao,
					icon: "error",
					confirmButtonText: "Đóng",
					allowOutsideClick: () => Swal.getConfirmButton().click()
				}).then((result) => {
					if (result.isConfirmed) {
						window.location.href = "Login";
					}
				});
			}
		';

		echo '<script>' . $script . '</script>';
	}
}
?>

<main>
	<div style="background-color: rgba(254, 217, 0, 0.9); border-radius: 7px; box-shadow: 0px 2px 5px black;" class="pb-1">
		<form class="text-center col-lg-5 col-md-10" style="margin: auto; padding: 20px;" method="post" action="">
			<h1 class="h3 mb-3 font-weight-normal text-white"
				style="padding-top: 3px; font-weight: bold; text-shadow: 2px 2px 2px #000;">Đăng Nhập</h1>

			<input style="height: 50px; border-radius: 15px; font-weight: bold;" name="username" type="text"
				class="form-control mt-1" placeholder="Tên tài khoản" autofocus="">

			<span style="color: red; font-size: 12px; font-weight: bold;"></span>

			<input style="height: 50px; border-radius: 15px; font-weight: bold;" name="password" type="password"
				class="form-control mt-1" placeholder="Mật khẩu">

			<span style="color: red; font-size: 12px; font-weight: bold;"></span>

			<div class="text-center mt-1">
				<button class="btn btn-lg btn-dark btn-block" style="<?= $nutdangnhapdangkiTO; ?>" type="submit"
					name="submit" onmouseover="<?= $onmouseover; ?>" onmouseout="<?= $onmouseout; ?>">
					Đăng Nhập
				</button>
			</div>
		</form>
	</div>
</main>

<?php require_once('../core/end.php'); ?>