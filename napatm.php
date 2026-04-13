<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('core/config.php');
require_once('core/khaibaobankmb.php');

// Kiểm tra đăng nhập qua cả 2 session phổ biến của source
if (!isset($_SESSION['account']) && !isset($_SESSION['logger']['username'])) {
    header('Location: /pages/dangnhap.php');
    exit;
}

$username = isset($_SESSION['account']) ? $_SESSION['account'] : $_SESSION['logger']['username'];

// Sử dụng Prepared Statement để bảo mật
$stmt = mysqli_prepare($config, "SELECT id, username, vnd, tongnap FROM account WHERE username = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    die('Không tìm thấy tài khoản trong hệ thống.');
}

$accountId = $user['id'];
$transferContent = $MEMO_PREFIX;

require_once('core/head.php');
include('set.php');

$queryt = "SELECT p.name, p.id FROM player p LEFT JOIN account a ON p.account_id = a.id WHERE a.username = '$username'";
$resultt = $config->query($queryt);
if ($resultt->num_rows > 0) {
    $rowt = $resultt->fetch_assoc();
    $player_id = $rowt['id'];
} else {
    echo '<p style="text-align: center; font-size: 20px; color: green; font-weight: bold;">Bạn chưa tạo nhân vật trong game.</p>';
    include_once('core/end.php');
    exit;
}
?>

<style>
    .copy-button {
        background-color: #A6A6A6;
        border: none;
        color: white;
        padding: 8px 15px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin: 5px;
    }

    .copy-button:hover { background-color: #545454; }

    .container-atm {
        border: 1px solid black;
        background-color: #f2f2f2;
        padding: 20px;
        text-align: center;
        border-radius: 10px;
    }

    .label { font-weight: bold; }

    .value {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
    }

    .atm-table {
        border-collapse: collapse;
        margin-left: auto;
        margin-right: auto;
        width: 100%;
        max-width: 400px;
    }

    .atm-table th, .atm-table td {
        padding: 10px;
        text-align: left;
        font-size: 16px;
        border-bottom: 1px solid #ddd;
    }
</style>

<div class="align-items-center my-2 d-flex justify-content-center">
    <a href="/napatm.php" style="margin-right: 10px;">
        <img src="/public/images/icon/ATM.png" alt="Nạp ATM" style="width: 110px; height: 110px; border-radius: 10px;" class="btn-img"></a>
    <a href="/napthe.php" style="margin-right: 10px;">
        <img src="/public/images/icon/Card.png" alt="Nạp Thẻ" style="width: 100px; height: 100px; border-radius: 10px;" class="btn-img"></a>
</div>

<div class="p-1 mt-1" style="background-color: rgba(254, 217, 0, 0.9); border-radius: 7px; box-shadow: 0px 2px 5px black;">
    <div class="atm-body">
        <center>
            <h1 class="h3 mb-3 font-weight-normal text-white" style="padding-top: 10px; font-weight: bold; text-shadow: 2px 2px 2px #000;">THÔNG TIN CHUYỂN KHOẢN</h1>
        </center>
        <div class="container-atm">
            <div class="mb-3 text-start">
                <label class="form-label font-weight-bold" style="color: #5E17EB;">1. Nhập số tiền cần nạp:</label>
                <input type="number" id="naptien_amount" class="form-control" placeholder="Ví dụ: 50000" oninput="updateQR()">
                <small class="text-muted">* Để trống nếu muốn quét mã không số tiền.</small>
            </div>

            <div class="value">
                <img id="qr-image" src="https://img.vietqr.io/image/TPB-<?php echo $stk; ?>-compact2.png?amount=0&addInfo=<?php echo urlencode($transferContent . $accountId); ?>&accountName=<?php echo urlencode($chutaikhoan); ?>"
                     alt="QR TPBank" style="max-width: 260px; border-radius: 12px; margin-bottom: 20px; border: 2px solid #fff;">
                
                <table class="atm-table">
                    <tr>
                        <td class="label">Số tài khoản:</td>
                        <td><b><?php echo htmlspecialchars($stk); ?></b></td>
                    </tr>
                    <tr>
                        <td class="label">Ngân hàng:</td>
                        <td><b><?php echo htmlspecialchars($tennh); ?></b></td>
                    </tr>
                    <tr>
                        <td class="label">Chủ tài khoản:</td>
                        <td><b><?php echo htmlspecialchars($chutaikhoan); ?></b></td>
                    </tr>
                    <tr>
                        <td class="label">Nội dung CK:</td>
                        <td><b style="color: red; font-size: 24px;" id="transfer-content"><?php echo htmlspecialchars($transferContent . $accountId); ?></b></td>
                    </tr>
                </table>
            </div>

            <div class="mt-3">
                <button type="button" class="copy-button" onclick="copyText('<?php echo $stk; ?>')">Copy STK</button>
                <button type="button" class="copy-button" onclick="copyText('<?php echo $transferContent . $accountId; ?>')">Copy Nội Dung</button>
                <button type="button" class="copy-button" onclick="window.location.reload()">Load Lại Trang</button>
            </div>

            <div style="color: #d32f2f; font-weight: bold; font-size: 14px; margin-top: 15px; background: #fff; padding: 10px; border-radius: 5px;">
                *Lưu ý: Chuyển khoản đúng nội dung <b><?php echo $transferContent . $accountId; ?></b>. Sau khi chuyển thành công, vui lòng Load lại trang hoặc chờ hệ thống tự động cộng tiền.
            </div>
        </div>

        <script>
        function updateQR() {
            var amount = document.getElementById('naptien_amount').value;
            if (amount < 0) amount = 0;
            var baseUrl = "https://img.vietqr.io/image/TPB-<?php echo $stk; ?>-compact2.png";
            var memo = "<?php echo urlencode($transferContent . $accountId); ?>";
            var name = "<?php echo urlencode($chutaikhoan); ?>";
            
            var newSrc = baseUrl + "?amount=" + amount + "&addInfo=" + memo + "&accountName=" + name;
            document.getElementById('qr-image').src = newSrc;
        }
        </script>
    </div>
</div>

<script>
function copyText(text) {
  navigator.clipboard.writeText(text).then(() => {
    alert('Đã copy: ' + text);
  }).catch(err => {
    // Fallback cho trình duyệt cũ
    var textArea = document.createElement("textarea");
    textArea.value = text;
    document.body.appendChild(textArea);
    textArea.select();
    document.execCommand('copy');
    document.body.removeChild(textArea);
    alert('Đã copy: ' + text);
  });
}
</script>

<div class="p-1 mt-3" style="background-color: rgba(254, 217, 0, 0.9); border-radius: 7px; box-shadow: 0px 2px 5px black;">
    <div class="atm-body">
        <center>
            <h1 class="h3 mb-3 font-weight-normal text-white" style="padding-top: 10px; font-weight: bold; text-shadow: 2px 2px 2px #000;">LỊCH SỬ NẠP</h1>
        </center>
        <div class="table-responsive">
            <table style="border-collapse: collapse; width: 100%; border: 1px solid #000;">
                <thead>
                    <tr style="background-color: #b8f9f1;">
                        <th style="padding: 10px; border: 1px solid black;">STT</th>
                        <th style="padding: 10px; border: 1px solid black;">Số Tiền</th>
                        <th style="padding: 10px; border: 1px solid black;">Thời Gian</th>
                        <th style="padding: 10px; border: 1px solid black;">Trạng Thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $resultk = $config->query("SELECT * FROM mb_bank WHERE username = '$username' ORDER BY tid DESC");
                    $stt = 1;
                    if ($resultk && $resultk->num_rows > 0) {
                        while ($rowk = $resultk->fetch_assoc()) {
                            $statusText = ($rowk['status'] == 1) ? 'Thành công' : 'Đang xử lý';
                            $statusColor = ($rowk['status'] == 1) ? '#2e7d32' : '#c62828';
                            echo '<tr>
                                <td align="center" style="padding: 8px; border: 1px solid black; background: white;">' . $stt++ . '</td>
                                <td align="center" style="padding: 8px; border: 1px solid black; background: white;">' . number_format($rowk['amount']) . 'đ</td>
                                <td align="center" style="padding: 8px; border: 1px solid black; background: white;">' . $rowk['time'] . '</td>
                                <td align="center" style="padding: 8px; border: 1px solid black; background: white; color: ' . $statusColor . '; font-weight:bold;">' . $statusText . '</td>
                            </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="4" align="center" style="padding: 20px; background: white;">Bạn chưa có giao dịch nào.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once('core/end.php'); ?>