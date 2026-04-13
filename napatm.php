<?php
require_once('core/config.php');
require_once('core/head.php');
require_once('core/khaibaobankmb.php');
include('set.php');

if (!isset($_SESSION['logger']['username'])) {
    $thongbao = 'Bạn chưa đăng nhập!';
    $script = '
        var thongbao = ' . json_encode($thongbao) . ';
        if (thongbao !== "") {
            Swal.fire({
                title: "Thất bại",
                html: thongbao,
                icon: "error",
                confirmButtonText: "Đóng",
                allowOutsideClick: () => Swal.getConfirmButton().click()
            }).then((result) => {
                if (result.isConfirmed) {
                    setTimeout(function () {
                        window.location.href = "Login";
                    }, 1000);
                }
            });
        }
        ';
    echo '<script>' . $script . '</script>';
    exit;
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
//require_once('core/end.php');
//exit;

unset($_SESSION["errors"]);
$_username = $_SESSION['logger']['username'];
$sqlk = "SELECT id FROM account WHERE username = '$_username'";
$resultk = $config->query($sqlk);

if ($resultk->num_rows > 0) {
    // Lấy id từ kết quả truy vấn
    $rowk = $resultk->fetch_assoc();
    $accountId = $rowk["id"];
}

$queryt = "SELECT p.name, p.id
    FROM player p
    LEFT JOIN account a ON p.account_id = a.id
    WHERE a.username = '$_username'";

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
        padding: auto;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    /* Hover effect */
    .copy-button:hover {
        background-color: #545454;
    }

    /* Active effect */
    .copy-button:active {
        background-color: #545454;
    }

    /* Khi nút được disabled */
    .copy-button[disabled] {
        background-color: #ccc;
        cursor: not-allowed;
    }

    .container {
        border: 1px solid black;
        background-color: #f2f2f2;
        padding: 20px;
        text-align: center;
    }

    .textinfo {
        border: 1px solid black;
        background-color: #ffefee;
        padding: 10px;
        text-align: center;
        font-weight: bold;
    }

    .label {
        font-weight: bold;
        margin-bottom: 0px;
    }

    .value {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
    }

    .value span {
        margin-right: 2px;
    }

    .red-text {
        color: red;
    }

    table {
        border-collapse: collapse;
        margin-left: auto;
        margin-right: auto;
    }

    th,
    td {
        padding: 7px;
        text-align: left;
        font-size: 18px;
    }

    .tk {
        padding: 20px;
        text-align: left;
        font-size: 15px;
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

<div class="p-1 mt-1  "
    style="background-color: rgba(254, 217, 0, 0.9); border-radius: 7px; box-shadow: 0px 2px 5px black;">
    <div class="atm-body">
        <form method="POST" action="#" id="myform">
            <center>
                <h1 class="h3 mb-3 font-weight-normal text-white"
                    style="padding-top: 3px; font-weight: bold; text-shadow: 2px 2px 2px #000;">Thông tin Chuyển khoản
                </h1>
            </center>
            <div class="container">

                <div class="value">
                    <table>
                        <tr>
                            <th><span class="label">Nội dung: </span></th>
                            <th><span id="noidung">
                                    <strong class="red-text">
                                        <span id="Description"><?php echo $MEMO_PREFIX . $accountId; ?></span>
                                        <button type="button" class="copy-button" onclick="copyDesciptionNumber()">Copy</button>
                                    </strong>
                                </span></th>
                        </tr>
                        <tr>
                            <th><span class="label">Số tài khoản: </span></th>
                            <td><span id="stk">
                                    <span id="accountNumber"><?php echo $stk; ?></span>
                                    <button type="button" class="copy-button" onclick="copyAccountNumber()">Copy</button>
                                </span></td>
                        </tr>
                        <tr>
                            <td><span class="label">Ngân hàng: </span></td>
                            <td><span id="tennh">
                                    <?php echo $tennh; ?>
                                </span></td>
                        </tr>
                        <tr>
                            <td><span class="label">Chủ tài khoản: </span></td>
                            <td><span id="chutaikhoan">
                                    <?php echo $chutaikhoan; ?>
                                </span></td>
                        </tr>

                        <img src="https://img.vietqr.io/image/TPB-<?php echo $stk; ?>-qr_only.png?amount=<AMOUNT>&addInfo=<?php echo $MEMO_PREFIX . $accountId; ?>"
                            " style="max-width: 25%; height: auto; margin: 20px auto;" alt="QR Code">

                    </table>
                </div>

                <br>
                <button type="button" class="copy-button" onclick="window.location.href = '/napatm.php'">Bấm tại đây để load lại trang!</button>
                <div style="color: dodgerblue; font-weight: bold; font-size: 15px;">*Lưu ý : Chuyển Khoản đúng nội dung
                    xong Vui lòng load lại trang hiện tại đến khi được cộng tiền</div>
            </div>
        </form>
        <script>
            function copyAccountNumber() {
                var accountNumber = document.getElementById("accountNumber");
                var range = document.createRange();
                range.selectNode(accountNumber);
                window.getSelection().removeAllRanges();
                window.getSelection().addRange(range);
                document.execCommand("copy");
                window.getSelection().removeAllRanges();
                alert("Đã sao chép số tài khoản!");
            }
            function copyDesciptionNumber() {
                var accountNumber = document.getElementById("Description");
                var range = document.createRange();
                range.selectNode(accountNumber);
                window.getSelection().removeAllRanges();
                window.getSelection().addRange(range);
                document.execCommand("copy");
                window.getSelection().removeAllRanges();
                alert("Đã sao chép nội dung chuyển khoản!");
            }
        </script>
        <!-- <form method="POST" action="#" id="myform">
            <center>
                <h1 class="h4 mb-3 font-weight-normal text-white"
                    style="padding-top: 3px; font-weight: bold; text-shadow: 2px 2px 2px #000;">Bảng giá nạp ATM
                </h1>
            </center>
            <div class="textinfo">
                <table>
                    <tr>
                        <td class="tk"><span class="label" style="font-size: 15px;">
                                10.000đ - 11.000 Coin <br>
                                20.000đ - 22.000 Coin <br>
                                50.000đ - 55.000 Coin <br>
                                100.000đ - 110.000 Coin <br>
                                200.000đ - 220.000 Coin </span></td>

                        <td class="tk"><span class="label" style="font-size: 15px;">
                                500.000đ - 550.000 Coin <br>
                                1.000.000đ - 1.150.000 Coin <br>
                                2.000.000đ - 2.300.000 Coin <br>
                                5.000.000đ - 6.000.000 Coin <br>
                                10.000.000đ - 13.000.000 Coin </span></td>
                    </tr>
                </table>
            </div>
        </form> -->
        <label class="text-black" style="padding-top: 3px; font-weight: bold;">***Lưu ý:</label>
        <br>
        <div class="text-black" style="padding-top: 3px; font-weight: bold;">-Nạp hiện đang x2 toàn Server (Nạp 10.000 được 20.000)<br>
            -Sau khi chuyển khoản Thành công. Load lại trang hiện tại đến khi hiện lịch sử nạp</div>
    </div>
</div>
<br>

<div class="p-1 mt-1"
    style="background-color: rgba(254, 217, 0, 0.9); border-radius: 7px; box-shadow: 0px 2px 5px black;">
    <div class="atm-body">
        <center>
            <h1 class="h3 mb-3 font-weight-normal text-white"
                style="padding-top: 3px; font-weight: bold; text-shadow: 2px 2px 2px #000;">Lịch Sử Chuyển khoản</h1>
        </center>

        <div class="table-responsive">
            <table style="border-collapse: collapse; width: 100%;">
                <thead>
                    <tr>
                        <th
                            style="padding: 8px; text-align: left; border: 1px solid black; background-color: #b8f9f1;font-weight: bold;text-shadow: 2px 2px 2px #fff;">
                            STT</th>
                        <th
                            style="padding: 8px; text-align: left; border: 1px solid black; background-color: #b8f9f1;font-weight: bold;text-shadow: 2px 2px 2px #fff;">
                            Tài Khoản</th>
                        <th
                            style="padding: 8px; text-align: left; border: 1px solid black; background-color: #b8f9f1;font-weight: bold;text-shadow: 2px 2px 2px #fff;">
                            Mệnh Giá</th>
                        <th
                            style="padding: 8px; text-align: left; border: 1px solid black; background-color: #b8f9f1;font-weight: bold;text-shadow: 2px 2px 2px #fff;">
                            Thời Gian</th>
                        <th
                            style="padding: 8px; text-align: left; border: 1px solid black; background-color: #b8f9f1;font-weight: bold;text-shadow: 2px 2px 2px #fff;">
                            Trạng Thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $queryk = "SELECT *
								  FROM mb_bank
								  WHERE mb_bank.username = '" . $_SESSION['logger']['username'] . "'";
                    $resultk = $config->query($queryk);
                    $stt = 1;
                    if ($resultk === false) {
                        echo 'Lỗi truy vấn SQL: ' . $config->error;
                    } elseif ($resultk->num_rows > 0) {
                        while ($rowk = $resultk->fetch_assoc()) {
                            $statusk = '';
                            $statusColork = '';

                            if ($rowk['status'] == 1) {
                                $statusk = 'Thành công';
                                $statusColork = 'green';
                            } elseif ($rowk['status'] == 0) {
                                $statusk = 'Đang xử lý';
                                $statusColork = 'red';
                            }

                            echo '<tr>
							  <td style="padding: 8px; text-align: left; border: 1px solid black;background-color: white;">' . $stt . '</td>
							  <td style="padding: 8px; text-align: left; border: 1px solid black;background-color: white;">' . $rowk['username'] . '</td>
							  <td style="padding: 8px; text-align: left; border: 1px solid black;background-color: white;">' . $rowk['amount'] . '</td>
							  <td style="padding: 8px; text-align: left; border: 1px solid black;background-color: white;">' . $rowk['time'] . '</td>
							  <td style="padding: 8px; text-align: left; border: 1px solid black;background-color: white; color: ' . $statusColork . '; font-weight:bold;">' . $statusk . '</td>
							</tr>';
                            $stt++;
                        }
                    } else {
                        echo ' <tr>
							  <td colspan="8" align="center"><span style="font-size:100%;font-weight: bold; text-shadow: 2px 2px 2px #000; color:white;"><< Bạn Chưa Từng Nạp ATM >></span></td>
							</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<br>


<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
function parse_order_id($des)
{
    global $MEMO_PREFIX;
    $re = '/' . $MEMO_PREFIX . '\d+/im';
    preg_match_all($re, $des, $matches, PREG_SET_ORDER, 0);
    if (count($matches) == 0)
        return null;
    $orderCode = $matches[0][0];
    $prefixLength = strlen($MEMO_PREFIX);
    $orderId = substr($orderCode, $prefixLength);
    return strval($orderId);
}
$data = json_decode($data, true);
foreach ($data['data'] as $mb) {
    $sotien = $mb['creditAmount'];
    $magd = explode('\\', $mb['refNo'])[0];
    $noidung = $mb['description'];
    $id = parse_order_id($noidung);

    $account = "SELECT * FROM account WHERE id = '$id'";
    $result = mysqli_query($config, $account);
    $row = mysqli_fetch_array($result);

    $napatm = "SELECT * FROM `mb_bank` WHERE `tid` = '$magd'";
    $result1 = mysqli_query($config, $napatm);
    $row1 = mysqli_fetch_array($result1);

    if ($id) {
        if ($row['id']) {
            if ($sotien >= 1000) {
                if (!$row1) {
                        $real_amount = $sotien * 2;
                    $sqll = "INSERT INTO `mb_bank` (`tid`, `description`, `amount`, `username`, `status`) 
                VALUES ('$magd', '$noidung', '$sotien', '" . $row['username'] . "', '0')";
                    $result11 = mysqli_query($config, $sqll);
                    $create = ($result11 !== false);
                }
                if ($create) {
                        $real_amount = $sotien * 2;
                    $sql = "UPDATE account
                INNER JOIN mb_bank ON account.username = mb_bank.username
                SET account.vnd = account.vnd + $real_amount
                WHERE account.username = '" . $row['username'] . "' AND mb_bank.status = 0";
                    $result = mysqli_query($config, $sql);

                    $sqlk = "UPDATE account
                INNER JOIN mb_bank ON account.username = mb_bank.username
                SET account.tongnap = account.tongnap + $real_amount
                WHERE account.username = '" . $row['username'] . "' AND mb_bank.status = 0";
                    $resultk = mysqli_query($config, $sqlk);

                    $sqlz = "UPDATE `mb_bank` SET `status` = '1'";
                    $resultz = mysqli_query($config, $sqlz);
                    // if ($sotien >= 1000) {
                    //     newgift(2);
                    // }
                }
            }
        }
    }
}
require_once('core/end.php');
?>