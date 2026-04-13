<?php
require_once('../core/config.php');
require_once('../core/head.php');

$thongbao = null;

if (isset($_SESSION['logger']['username'])) {
	echo '<script>window.location.href = "/";</script>';
	exit();
}

//echo '<div class="p-1 mt-1  "
//    style="background-color: rgba(254, 217, 0, 0.9); border-radius: 7px; box-shadow: 0px 2px 5px black;">
//    <center>
//        <h1 class="h3 mb-3 font-weight-normal text-white"
//            style="padding-top: 15px; font-weight: bold; text-shadow: 2px 2px 2px #000;">
//            Chức năng đang tạm thời Bảo trì. Mở vào lúc 19h Ngày 18/02/2025
//        </h1>
//    </center>
//</div>';
//require_once('../core/end.php');
//exit;

if (isset($_POST['submit']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['repassword'])) {
	$username = mysqli_real_escape_string($config, $_POST['username']);
	$password = mysqli_real_escape_string($config, $_POST['password']);
	$repassword = mysqli_real_escape_string($config, $_POST['repassword']);
	$vndd = 0;

	if ($password !== $repassword) {
		$thongbao = 'Mật khẩu nhập lại không khớp. Vui lòng thử lại!';
	} else {
		if (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
			$thongbao = 'Tên người dùng không hợp lệ!';
		} elseif (!preg_match('/^[a-zA-Z0-9]+$/', $password)) {
			$thongbao = 'Mật khẩu không hợp lệ!';
		} else {
			$stmt = mysqli_prepare($config, "SELECT * FROM account WHERE username = ?");
			mysqli_stmt_bind_param($stmt, "s", $username);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);

			if (mysqli_num_rows($result) > 0) {
				$thongbao = 'Tài khoản đã tồn tại!';
			} else {
				$stmt = mysqli_prepare($config, "INSERT INTO account (username, password, vnd, tongnap) VALUES (?, ?, ?, ?)");
				mysqli_stmt_bind_param($stmt, "ssii", $username, $password, $vndd, $vndd);
				mysqli_stmt_execute($stmt);

				echo '<script>
                    Swal.fire({
                        title: "Thành Công",
                        html: "Đăng ký thành công!",
                        icon: "success",
                        confirmButtonText: "Đóng"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "Login";
                        }
                    });
                </script>';
				exit();
			}
		}
	}

	if ($thongbao) {
		echo '<script>
            Swal.fire({
                title: "Thất Bại",
                html: ' . json_encode($thongbao) . ',
                icon: "error",
                confirmButtonText: "Đóng"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "Register";
                }
            });
        </script>';
	}
}
?>

<main>
	<div style="background-color: rgba(254, 217, 0, 0.9); border-radius: 7px; box-shadow: 0px 2px 5px black;"
		class="pb-1">
		<form class="text-center col-lg-5 col-md-10" style="margin: auto; padding: 20px;" method="post" action="">
			<h1 class="h3 mb-3 font-weight-normal text-white"
				style="padding-top: 3px; font-weight: bold; text-shadow: 2px 2px 2px #000;">Đăng Kí</h1>

			<input style="height: 50px; border-radius: 15px; font-weight: bold;" name="username" required autofocus
				   type="text" class="form-control mt-1" placeholder="Tên tài khoản">

			<div style="position: relative;">
				<input style="height: 50px; border-radius: 15px; font-weight: bold; padding-right: 40px;"
					   name="password" required type="password" id="password"
					   class="form-control mt-1" placeholder="Mật khẩu">
				<span onclick="togglePassword('password', this)"
					  class="password-toggle">👁️</span>
			</div>

			<div style="position: relative;">
				<input style="height: 50px; border-radius: 15px; font-weight: bold; padding-right: 40px;"
					   name="repassword" required type="password" id="repassword"
					   class="form-control mt-1" placeholder="Nhập lại Mật khẩu">
				<span onclick="togglePassword('repassword', this)"
					  class="password-toggle">👁️</span>
			</div>

			<div class="text-center mt-1">
				<button class="btn btn-lg btn-dark btn-block" style="<?= $nutdangnhapdangkiTO; ?>" type="submit"
					name="submit" onmouseover="<?= $onmouseover; ?>" onmouseout="<?= $onmouseout; ?>">Đăng Kí</button>
			</div>
		</form>
	</div>
</main>

<style>
    .password-toggle {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        cursor: pointer;
        font-size: 20px;
        user-select: none;
    }

    .password-toggle.hidden::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 10%;
        width: 80%;
        height: 2px;
        background: black;
        transform: rotate(45deg);
        transform-origin: center;
    }
</style>

<script>
    function togglePassword(inputId, icon) {
        const inputField = document.getElementById(inputId);

        if (inputField.type === 'password') {
            inputField.type = 'text';
            icon.classList.add('hidden');
        } else {
            inputField.type = 'password';
            icon.classList.remove('hidden');
        }
    }
</script>

<?php require_once('../core/end.php'); ?>