<?php
require_once('../core/config.php');
require_once('../core/head.php');


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

$items_web = "";
$result = $conn->query("SELECT * FROM items_web");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $items = sql::Select("item_template", "id", $row['items']);
        $option = json_decode($row['options'], true);
        $opName = "";
        foreach ($option as $data) {
            $opName .= '<span style="padding-left: 10px; color: #0a3bf5;">' . str_replace("#", $data[1], sql::Select("item_option_template", "id", $data[0])['NAME']) . "</span></br>";
        }
        $items_web .= '
        <button onclick="onSwick(\'showINFO' . $row['id'] . '\')" class="p-1 mt-1 ibox-content" 
                style="border: none; background-color: #fff6c4; border-radius: 7px; box-shadow: 0px 0px 5px black; width: 100%; text-align: left; cursor: pointer;">
    <div class="post-item d-flex align-items-center my-2 justify-content-between">
        <div class="post-image" style="padding-left: 10px;">
            <img src="' . until::domain("assets/Icon/" . $items['icon_id'] . ".png") . '" alt="hd">
            <span style="padding-left: 10px; color: #0d6efd; font-weight: 700">' . $items['NAME'] . '</span><br>
            
            <i style="padding-left: 10px; color: #ff0000; font-weight: 700">' . number_format($row["vnd"], 0, '.', ',') . 'VNĐ</i>
        </div>
        <div>
            <a style="color: #0d6efd; font-weight: 700 !important;">Click Để Xem Chi Tiết</a>
            <img width="50px" src="/public/images/icon/giohang.png" alt="tick">
        </div>
    </div>
    <div style="display: none;" id="showINFO' . $row['id'] . '">
        ' . $opName . '
        <span style="padding-left: 10px; color: #ff0000; font-weight: 700;">Số lượng : ' . $row["slot"] . '</span><br>
        <span style="padding-left: 10px; color: #00a70b; font-weight: 700">Giá : ' . number_format($row["vnd"], 0, '.', ',') . ' VND</span><br>
        <a onclick="shop(' . $row['id'] . ' , \'' . until::domain("assets/Icon/" . $items['icon_id'] . ".png") . '\' , \'' . $items['NAME'] . '\' , \'' . number_format($row["vnd"], 0, '.', ',') . '\')" class="btn btn-primary">
            Mua ngay
        </a>
  </div>
  </div>
  </button>
';

    }
} else {
    $items_web = "không có item nào";
}
?>
<div class="p-1 mt-1 ibox-content"
    style="background-color: rgba(254, 217, 0, 0.9); border-radius: 7px; box-shadow: 0px 2px 5px black;">
    <div class="p-1">
        <h5 class="h3 mb-3 font-weight-normal text-white"
            style="text-align:center; padding-top: 3px; font-weight: bold; text-shadow: 2px 2px 2px #000;">
            Shop Vật Phẩm</h5>

        <div style="display: flex; justify-content: center; align-items: center;">
            <a href="TRANS_ITEMS" class="btn btn-action m-1 text-white" style="border-radius: 10px;">
                <i class="fa-solid fa-address-card"></i> Lịch sử mua </a>
        </div>
        <div class="card-body">

            <div id="shopITemS">
                <div class="mt-4">
                    <div class="mt-4">
                        <div class="table-responsive"></div>
                    </div>
                </div>
            </div>
            <script>
                async function _post(url, data) {
                    try {
                        const response = await fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(data)
                        });

                        if (!response.ok) {
                            return JSON.stringify({ error: 99 });
                        }
                        const responseData = await response.json();
                        return JSON.stringify({ error: 0, data: responseData });
                    } catch (error) {
                        return JSON.stringify({ error: 99 });
                    }
                }

                async function shop(id, avatar, name, vnd) {
                    try {
                        const result = await Swal.fire({
                            title: `Mua ${name}`,
                            text: `Bạn chắc chắn muốn mua ${name} với giá ${vnd}VND`,
                            icon: '',
                            imageUrl: avatar,
                            imageAlt: 'Custom image',
                            showCancelButton: true,
                            confirmButtonText: 'Xác Nhận',
                            cancelButtonText: 'Hủy',
                            customClass: {
                                popup: 'custom-popup'
                            }
                        });

                        if (result.isConfirmed) {
                            let status = JSON.parse(await _post('<?php echo until::domain("ITEMS"); ?>', { "uid": id, "type": "byitems" }));
                            console.log(status);
                            if (status.error == 0) {
                                if (status.data.error_code == 0) {
                                    Swal.fire('Mua Thành Công!', 'Đã mua thành công', 'success');
                                    setTimeout(function () {
                                        window.location.href = "TRANS_ITEMS";
                                    }, 2000);
                                } else {
                                    Swal.fire('Lỗi', status.data.error, 'error');
                                }
                            } else {
                                Swal.fire('Lỗi', 'Gặp lỗi phía api', 'error');
                            }
                        } else if (result.isDismissed) {
                            Swal.fire('Hủy', 'Đã huỷ mua Item', 'error');
                        }
                    } catch (error) {
                        console.error('Error occurred:', error);
                    }
                }


                var stick1 = "null";
                function onSwick(stick) {
                    if (stick1 != "null" && stick1 == stick) {
                        document.getElementById(stick1).style.display = "none";
                        stick1 = "null";
                        return;
                    }
                    if (stick1 != "null") {
                        document.getElementById(stick1).style.display = "none";
                    }
                    stick1 = stick;
                    document.getElementById(stick).style.display = "block";
                }

                document.getElementById("shopITemS").innerHTML = "<div class='spinner'></div>";
                setTimeout(function () {
                    document.getElementById("shopITemS").innerHTML = `<?php echo $items_web; ?>`;
                }, 2000);
            </script>

            <style>
                .post-item img {
                    max-width: 50px;
                    max-height: 50px;
                }

                .custom-toast {
                    position: fixed;
                    padding: 15px;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    border-radius: 5px;
                    color: white;
                    display: none;
                    z-index: 9999;
                }

                .alert-success {
                    background-color: #28a745;
                }

                .alert-danger {
                    background-color: #dc3545;
                }

                .nsotien_logo {
                    height: 120px;
                    width: auto;
                }

                @media only screen and (max-width: 768px) {
                    .nsotien_logo {
                        height: 70px;
                    }
                }

                .mt-3 a:hover {
                    color: white;
                    background-color: red;
                    border-color: red;
                }

                .header-logo {
                    border-top-left-radius: 15px;
                    border-top-right-radius: 15px;
                    border-radius: 10px;
                    max-height: 100%;
                    max-width: 100%;
                }

                .custom-success-alert {
                    background-color: #4CAF50 !important;
                    color: white !important;
                    padding: 10px !important;
                    text-align: center !important;
                    border-radius: 5px;
                }

                .spinner {
                    border: 3px solid #f3f3f3;
                    border-top: 3px solid #3498db;
                    border-radius: 50%;
                    width: 20px;
                    height: 20px;
                    animation: spin 1s linear infinite;
                    margin: auto;
                }

                @keyframes spin {
                    0% {
                        transform: rotate(0deg);
                    }

                    100% {
                        transform: rotate(360deg);
                    }
                }

                .alert.alert-danger.alert-block {
                    background: none;
                    border-color: transparent;
                    text-align: center;
                }

                /*a {*/
                /*    margin: 5px;*/
                /*}*/

                svg {
                    width: 30px;
                    height: 30px;
                }

                .age-rule a {
                    background-color: #B4E3FF;
                    color: #F4FFFF !important;
                    border-radius: 10px !important;
                    text-align: center;
                    max-width: 10%;
                    margin: 5px auto;
                    padding: 5px 10px;
                }

                .age-rule a:hover {
                    background-color: #ffcc99;
                    color: #F4FFFF !important;
                }

                .page-layout-color {
                    background: #b3afaf url("Assets/Images/nen_backgr.png");
                    background-size: cover;
                    background-attachment: fixed;
                    height: auto;
                }

                #serverModal a#serverTeamButton {
                    width: 100% !important;

                    margin-bottom: 10px !important;

                    align-items: flex-start !important;
                    background-color: #8f34f5 !important;
                    border-color: #8f34f5 !important;
                    border-radius: 10px !important;
                    color: #ffffff !important;
                    display: inline-block !important;
                    font-family: system-ui !important;
                    font-size: 14px !important;
                    line-height: 21px !important;
                    margin: 10px 0px 0px !important;
                    text-align: center !important;
                }

                #serverModal a#serverTeamButton:hover {
                    background-color: #FF418C !important;
                    border-color: #FF418C !important;
                }

                #serverModal .mt-2 {
                    color: #212529 !important;
                    font-weight: 600 !important;
                    line-height: 24px !important;
                    margin: 8px 0px 0px !important;
                    text-align: center !important;
                }

                #serverModal .mb-2 {
                    color: #212529 !important;
                    font-weight: 600 !important;
                    line-height: 30px !important;
                    margin: 0px 0px 8px !important;
                    text-align: center !important;
                }

                #serverModal .text-center {
                    color: #212529 !important;
                    font-weight: 300 !important;
                    line-height: 24px !important;
                    text-align: center !important;
                }

                #serverModal img.logo {
                    color: #212529 !important;
                    display: inline !important;
                    font-weight: 300 !important;
                    line-height: 24px !important;
                    text-align: center !important;
                }

                #serverModal .modal-body {

                    outline: 2px solid #000;
                    border-radius: 10px;

                    background-color: #FCE3C6 !important;
                    color: #212529 !important;
                    font-weight: 300 !important;
                    line-height: 24px !important;

                }

                #serverModal .modal-content {
                    margin: 2px 127px;

                }

                #serverModal .modal-content p {
                    margin: 9px 30px;
                    line-height: 1.5;
                }

                #serverModal .modal-content h2 {
                    margin: 9px 30px;
                    line-height: 1.5;
                }


                #serverModal .modal-content font[color="#FF0000"] {
                    color: #FF0000;
                    font-weight: bold;

                }

                @media (min-width: 768px) and (max-width: 1024px) {

                    #serverModal html,
                    body {
                        overflow: visible;
                    }
                }

                @media (max-width: 767px) {

                    #serverModal html,
                    body {
                        overflow: visible;
                    }

                    #serverModal .modal-body {
                        margin: 0 -36px;

                        text-align: center;
                    }

                    #serverModal .modal-content {
                        margin: 4px 55px
                    }

                    #serverModal .modal-content p {
                        margin: 32px 30px;
                        line-height: 1.5;
                    }

                }
            </style>
        </div>
    </div>
</div>
<?php require_once('../core/end.php'); ?>
</div>

<!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>-->
<!--<script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/jquery-slim.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.5/sweetalert2.all.js"></script>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"> </script>-->
</body>

</html>