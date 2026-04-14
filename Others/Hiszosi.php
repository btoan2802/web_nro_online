<?php
require_once('../core/config.php');
require_once('../core/head.php');
if (!isset($_SESSION['logger']['username'])) {
    die();
} else {
    echo $head;
}
$items_web = "";
$player = until::isPl();
if (!$player) {
    $items_web .= '<tr>
               <td class="text-danger fw-bold">chưa tạo nhân vật</td>
               <td class="text-danger fw-bold">chưa tạo nhân vật </td>
               <td class="text-danger fw-bold">chưa tạo nhân vật</td>
               <td class="text-danger fw-bold">chưa tạo nhân vật</td>
               </tr>';
} else {
    $account = sql::Select("account", "username", $_SESSION['logger']['username']);

    $result = $conn->query("SELECT * FROM shops_web WHERE uid = " . $player['id']);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $items = sql::Select("items_web", "id", $row['items']);
            $item_template = sql::Select("item_template", "id", $items['items']);
            $option = json_decode($items['options'], true);
            $opName = "";
            foreach ($option as $data) {
                $opName .= str_replace("#", $data[1], sql::Select("item_option_template", "id", $data[0])['NAME']) . "</br>";
            }
            $status = ($row['status'] == 0) ? "Vào game chờ 4-5 phút" : "Bạn đã nhận rồi";
            $items_web .= '<tr>
               <td class="text-success fw-bold">' . $item_template['NAME'] . '</td>
               <td class="text-danger fw-bold"><img style="width:50px" src="' . until::domain("assets/Icon/" . $item_template['icon_id'] . ".png") . '"/></td>
               <td class="text-success fw-bold">' . $opName . '</td>
               <td class="text-danger fw-bold">' . $status . '</td>
               </tr>';

        }
    } else {
        $items_web = "Không có item nào";
    }
}
?>
<style>
    #myModal .modal-content {
        background-color: #FCE3C6 !important;
    }

    #myModal a.btn.btn-menu.btn-danger.w-100.fw-semibold.my-1 {
        border-radius: 10px;
        background-color: #8f34f5 !important;
        color: #ffffff !important;
        box-shadow: none !important;
    }

    /* Hiệu ứng nhấp nháy 7 màu cho chữ */
    @keyframes rainbow {

        14% {
            color: orange;
        }

        28% {
            color: yellow;
        }

        48% {
            color: pink;
        }

        84% {
            color: violet;
        }

    }

    .rainbow-text {
        animation: rainbow 3s infinite;
    }

    /* Hiệu ứng border 7 màu chạy xung quanh nút */
    @keyframes rainbow-border {
        0% {
            border-color: red;
        }

        14% {
            border-color: orange;
        }

        28% {
            border-color: yellow;
        }

        42% {
            border-color: green;
        }

        56% {
            border-color: blue;
        }

        70% {
            border-color: indigo;
        }

        84% {
            border-color: violet;
        }

        100% {
            border-color: red;
        }
    }

    .rainbow-border {
        animation: rainbow-border 1s infinite;
    }
</style>
<style>
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

    .ant-list-item-meta {
        display: flex;
        flex: 1 1;
        align-items: flex-start;
        max-width: 100%;
    }

    .ant-list-item-meta-content {
        flex: 1 0;
        width: 0;
        color: rgba(0, 0, 0, .85);
    }

    .ant-list-item-meta-title {
        margin-bottom: 4px;
        color: rgba(0, 0, 0, .85);
        font-size: 14px;
        line-height: 1.5715;
    }

    .ant-list-item-meta-description {
        color: rgba(0, 0, 0, .45);
        font-size: 14px;
        line-height: 1.5715;
    }
</style>
<div class="p-1 mt-1 ibox-content"
    style="background-color: rgba(254, 217, 0, 0.9); border-radius: 7px; box-shadow: 0px 2px 5px black;">
    <div class="p-1">
        <div class="card-body">
            <h5 class="h3 mb-3 font-weight-normal text-white"
                style="text-align:center;padding-top: 3px; font-weight: bold; text-shadow: 2px 2px 2px #000;">
                Lịch sử mua Item</h5>

            <div style="display: flex; justify-content: center; align-items: center;">
                <a href="SHOPS" class="btn btn-action m-1 text-white" style="border-radius: 10px;">
                    <i class="fa-solid fa-address-card"></i> Web Shop </a>
            </div>
            
            <div class="p-1 mt-1 ibox-content" style="border-radius: 7px; box-shadow: 0px 0px 5px black;">
                <table class="table table-bordered table-hover" style="margin-top: 5px; border: 2px solid black;">
                    <thead class="text-center">
                        <tr class="border-solid border-2">
                            <th>Item</th>
                            <th>Icon</th>
                            <th>Options</th>
                            <th>Trạng Thái</th>
                        </tr>
                    </thead>
                    <tbody id="ListItems" class="text-center">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("ListItems").innerHTML = `<tr>
               <td class="text-danger fw-bold"><div class='spinner'></div></td>
               <td class="text-danger fw-bold"><div class='spinner'></div></td>
               <td class="text-danger fw-bold"><div class='spinner'></div></td>
               <td class="text-danger fw-bold"><div class='spinner'></div></td>
               </tr>`;
    setTimeout(function () {
        document.getElementById("ListItems").innerHTML = `<?php echo $items_web; ?>`;
    }, 2000);
</script>


<style>
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
        background: #b3afaf url("../Assets/Images/nen_backgr.png");
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
<?php require_once('../core/end.php'); ?>
</div>

<!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>-->
<!--<script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/jquery-slim.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.5/sweetalert2.all.js"></script>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"> </script>-->
</body>

</html>