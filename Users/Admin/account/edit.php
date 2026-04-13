<?php
include '../head.php';
$row = sql::Select("account", "id", $_GET['id']);
if (!$row) {
    echo '<script> window.location.href = "' . until::domain("ADMIN/ACCOUNT") . '" </script>';
    die();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    sql::update("account", "username", $_POST['username'], "id", $_GET['id']);
    sql::update("account", "password", $_POST['password'], "id", $_GET['id']);
    sql::update("account", "vnd", $_POST['vnd'], "id", $_GET['id']);
    sql::update("account", "active", $_POST['active'], "id", $_GET['id']);
    sql::update("account", "ban", $_POST['ban'], "id", $_GET['id']);
    echo '
 <script>
 alert("Chỉnh Sửa account Thành Công");
 setTimeout(function() {
          window.location.href = "' . until::domain("ADMIN/ACCOUNT") . '"
         }, 2000)
 </script>
    ';
}
?>
<div class="content-body">
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
                                            <h2>CHỈNH SỬA ACCOUNT</h2>
                                            <span>CHỈNH SỬA ACCOUNT</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-sm-6">
                                <div class="card">
                                    <div class="card-body d-flex px-4 justify-content-between">
                                        <div>
                                            <form method="POST">
                                                <p class="text-primary">Tài Khoản.</p>
                                                <input value="<?php echo $row['username']; ?>" name="username" class="form-control fs-18 font-weight-bold d-block" placeholder="Tài Khoản">
                                                <p class="text-primary">Mật Khẩu</p>
                                                <input value="<?php echo $row['password']; ?>" name="password" class="form-control fs-18 font-weight-bold d-block" placeholder="Mật Khẩu">
                                                <p class="text-primary">Vnd</p>
                                                <input value="<?php echo $row['vnd']; ?>" type="number" name="vnd" class="form-control fs-18 font-weight-bold d-block" placeholder="vnd">
                                                <p class="text-primary">Active</p>
                                                <div class="form-group">
                                                    <select class="form-control" id="active" name="active" required>
                                                        <?php
                                                        if ($row['active'] == 0) {
                                                            echo ' <option value="0">Chưa kích hoạt</option><option value="1">Kích hoạt</option>';
                                                        } else {
                                                            echo '<option value="1">Kích hoạt</option><option value="0">Chưa kích hoạt</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <p class="text-primary">Is Ban</p>
                                                <div class="form-group">
                                                    <select class="form-control" id="ban" name="ban" required>
                                                        <?php
                                                        if ($row['ban'] == 0) {
                                                            echo ' <option value="0">Hoạt Động</option><option value="1">Ban</option>';
                                                        } else {
                                                            echo '<option value="1">Ban</option><option value="0">Hoạt Động</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <button class="btn btn-primary btn-lg font-weight-bold fs-18 mt-3">Đồng Ý</button>
                                            </form>
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
<?php include '../end.php'; ?>