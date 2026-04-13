<?php
require_once('core/config.php');
require_once('core/khaibaobankmb.php');

if (!isset($_SESSION['account'])) {
    header('Location: /pages/dangnhap.php');
    exit;
}

$username = $_SESSION['account'];
$stmt = mysqli_prepare($config, "SELECT id, username, vnd, tongnap FROM account WHERE username = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    die('Không tìm thấy tài khoản.');
}

$accountId = $user['id'];
$transferContent = $MEMO_PREFIX;

require_once('core/head.php');
include('set.php');

$queryt = "SELECT p.name, p.id
    FROM player p
    LEFT JOIN account a ON p.account_id = a.id
    WHERE a.username = '$username'";

$resultt = $config->query($queryt);
if ($resultt->num_rows > 0) {
    $rowt = $resultt->fetch_assoc();
    $player_id = $rowt['id'];
} else {
    echo '<p style="text-align: center; font-size: 20px; color: green; font-weight: bold;">Bạn chưa tạo nhân vật</p>';
    exit;
}
?>

<style>
    /* CSS cho nút sao chép */
    .copy-button {
        background-color: #A6A6A6;
        border: none;
        color: white;
        padding: 5px 10px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .copy-button:hover {
        background-color: #545454;
    }

    .container {
        border: 1px solid black;
        background-color: #f2f2f2;
        padding: 20px;
        text-align: center;
    }

    .label {
        font-weight: bold;
    }

    .value {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
    }

    table {
        border-collapse: collapse;
        margin-left: auto;
        margin-right: auto;
    }

    th, td {
        padding: 7px;
        text-align: left;
        font-size: 18px;
    }
</style>

<div class="align-items-center my-2 d-flex justify-content-center">
    <a href="/napatm.php" style="margin-right: 10px;">
        <img src="/public/images/icon/ATM.png" alt="Nạp ATM"
            style="width: 110px; height: 110px; border-radius: 10px; pointer-events: none;" class="btn-img"></a>
    <a href="/napthe.php" style="margin-right: 10px;">
        <img src="/public/images/icon/Card.png" alt="Nạp Thẻ"
            style="width: 100px; height: 100px; border-radius: 10px; pointer-events: none;" class="btn-img"></a>
</div>

<div class="p-1 mt-1" style="background-color: rgba(254, 217, 0, 0.9); border-radius: 7px; box-shadow: 0px 2px 5px black;">
    <div class="atm-body">
        <form method="POST" action="#" id="myform">
            <center>
                <h1 class="h3 mb-3 font-weight-normal text-white" style="padding-top: 3px; font-weight: bold; text-shadow: 2px 2px 2px #000;">Thông tin Chuyển khoản</h1>
            </center>
            <div class="container">
                <div class="value">
                    <img src="https://img.vietqr.io/image/TPB-<?php echo $stk; ?>-compact2.png?amount=0&addInfo=<?php echo urlencode($transferContent); ?>&accountName=<?php echo urlencode($chutaikhoan); ?>"
                         alt="QR TPBank" style="max-width: 260px; border-radius: 12px; margin-bottom: 20px;">
                    
                    <table>
                        <tr>
                            <th>Số tài khoản:</th>
                            <td><b><?php echo htmlspecialchars($stk); ?></b></td>
                        </tr>
                        <tr>
                            <th>Ngân hàng:</th>
                            <td><b><?php echo htmlspecialchars($tennh); ?></b></td>
                        </tr>
                        <tr>
                            <th>Chủ tài khoản:</th>
                            <td><b><?php echo htmlspecialchars($chutaikhoan); ?></b></td>
                        </tr>
                        <tr>
                            <th>Nội dung CK:</th>
                            <td><b id="transfer-content"><?php echo htmlspecialchars($transferContent); ?></b></td>
                        </tr>
                    </table>
                </div>

                <br>
                <button type="button" class="copy-button" onclick="copyText('<?php echo htmlspecialchars($stk, ENT_QUOTES); ?>')">Copy STK</button>
                <button type="button" class="copy-button" onclick="copyText('<?php echo htmlspecialchars($transferContent, ENT_QUOTES); ?>')">Copy nội dung</button>
                <button type="button" class="copy-button" onclick="window.location.href = '/napatm.php'">Load lại trang</button>

                <div style="color: dodgerblue; font-weight: bold; font-size: 15px; mt-3">
                    *Lưu ý: Chuyển Khoản đúng nội dung xong Vui lòng load lại trang hiện tại đến khi được cộng tiền
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function copyText(text) {
  navigator.clipboard.writeText(text).then(() => {
    alert('Đã copy: ' + text);
  });
}
</script>

<div class="p-1 mt-3" style="background-color: rgba(254, 217, 0, 0.9); border-radius: 7px; box-shadow: 0px 2px 5px black;">
    <div class="atm-body">
        <center>
            <h1 class="h3 mb-3 font-weight-normal text-white" style="padding-top: 3px; font-weight: bold; text-shadow: 2px 2px 2px #000;">Lịch Sử Chuyển khoản</h1>
        </center>
        <div class="table-responsive">
            <table style="border-collapse: collapse; width: 100%;">
                <thead>
                    <tr>
                        <th style="padding: 8px; text-align: left; border: 1px solid black; background-color: #b8f9f1;">STT</th>
                        <th style="padding: 8px; text-align: left; border: 1px solid black; background-color: #b8f9f1;">Mệnh Giá</th>
                        <th style="padding: 8px; text-align: left; border: 1px solid black; background-color: #b8f9f1;">Thời Gian</th>
                        <th style="padding: 8px; text-align: left; border: 1px solid black; background-color: #b8f9f1;">Trạng Thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $resultk = $config->query("SELECT * FROM mb_bank WHERE username = '$username' ORDER BY id DESC");
                    $stt = 1;
                    if ($resultk && $resultk->num_rows > 0) {
                        while ($rowk = $resultk->fetch_assoc()) {
                            $statusText = ($rowk['status'] == 1) ? 'Thành công' : 'Đang xử lý';
                            $statusColor = ($rowk['status'] == 1) ? 'green' : 'red';
                            echo '<tr>
                                <td style="padding: 8px; border: 1px solid black; background: white;">' . $stt++ . '</td>
                                <td style="padding: 8px; border: 1px solid black; background: white;">' . number_format($rowk['amount']) . 'đ</td>
                                <td style="padding: 8px; border: 1px solid black; background: white;">' . $rowk['time'] . '</td>
                                <td style="padding: 8px; border: 1px solid black; background: white; color: ' . $statusColor . '; font-weight:bold;">' . $statusText . '</td>
                            </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="4" align="center" style="background: white;">Bạn chưa có giao dịch nào</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once('core/end.php'); ?>