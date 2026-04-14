<?php
include __DIR__ . '/../api/sql.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
unset($_SESSION["errors"]);
$_username = $_SESSION['logger']['username'];
$sql = "SELECT id FROM account WHERE username = '$_username'";
$result = $config->query($sql);

if ($result->num_rows > 0) {
  // Lấy id từ kết quả truy vấn
  $row = $result->fetch_assoc();
  $accountId = $row["id"];

  // Truy vấn để lấy giá trị giới tính từ bảng Player
  $sql = "SELECT gender FROM player WHERE account_id = $accountId";
  $sqll = "SELECT id, vnd FROM account WHERE id = $accountId";
  $result = $config->query($sql);
  $resultt = $config->query($sqll);

  if ($result->num_rows > 0) {
    // In ra giá trị giới tính
    $row = $result->fetch_assoc();
  }
  if ($resultt->num_rows > 0) {
    // In ra giá trị giới tính
    $roww = $resultt->fetch_assoc();
  }
}
?>
<html lang="en">

<head>
  <!-- Import SweetAlert2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.min.css">

  <!-- Import SweetAlert2 JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.min.js"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>
    <?= $tieude; ?>
  </title>
  <link rel="canonical" href="<?= $link_web; ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="<?= $iconweb; ?>">
  <!-- bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- icon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- jquery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
  <!-- mycss -->
  <link rel="stylesheet" href="../public/css/cssweb.css?cssweb=<?= rand(0, 100000); ?>">
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
  <!-- Captcha Goole -->
  <script src='https://www.google.com/recaptcha/api.js' async defer></script>
  
  <style type="text/css">
    #cssweb {
      background-color: black;
    }

    #cssweb2 {
      padding: 30px;
      background-color: rgba(0, 0, 0, 0.3);
    }

    #custom-hr {
      border: none;
      border-top: 1px solid #000;
      margin: 10px 0;
    }

    #custom-hr2 {
      border: none;
      border-top: 1px solid #000;
      margin: 10px 0;
    }

    <?= $nutdangnhapdangki; ?>
    <?= $nutdownloadfile; ?>
  </style>
</head>

<body class="girlkun-bg" id="cssweb">
  <div class="container-md p-1 col-sm-12 col-lg-6" style="<?= $maunen; ?>"">
      <style>

        .btn-navbar{
            background-color: #5E17EB;
            border-color: black;
            text-shadow: 1px 1px 0 black;
        }
        .btn-navbar:hover,
        .btn-navbar:focus {
            background-color:#5500FF;
            border-color: 1px solid black;
            font-weight: bold;
        }
       
        .table-custom, .table-custom tr, .table-custom td, .table-custom th {
          border: none !important;
        }
        .table-custom th, .table-custom td:first-child {
          width: 150px;
        }
        
        @keyframes blink {
          0% { color: black; }
          50% { color: red; }
          100% { color: black; }
        }
        @keyframes flashing {
          0% {
            border-color: black;
          }
          50% {
            border-color: yellow;
          }
          100% {
            border-color: black;
          }
        }
        @keyframes flashing1 {
          0% {
            border-color: black;
          }
          50% {
            border-color: red;
          }
          100% {
            border-color: black;
          }
        }
        @keyframes flashing2 {
          0% {
            border-color: black;
          }
          50% {
            border-color: #9CF100;
          }
          100% {
            border-color: black;
          }
        }
        @keyframes stretch {
          0% {
            transform: scale(1);
          }
          50% {
            transform: scale(1.2);
          }
          100% {
            transform: scale(1);
          }
        }
        .text-black1 {
          animation: blink 0.5s infinite;
        }

        @keyframes blinking {
          0% { color: #FF0000; }
          50% { color: #FFFFFF; }
          100% { color: #FF0000; }
        }

        .blinking-link {
          animation: blinking 0.5s infinite;
        }
      </style>


<style>


.section1{
    position: relative;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background: url(./bg0.jpg);
    background-position-x: center;
    background-size: cover;
}
.span1{
    position: absolute;
    top: 50%;
    left: 50%;
    width: 4px;
    height: 4px;
    background: #fff;
    border-radius: 50%;
    box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.1), 0 0 0 8px rgba(255, 255, 255, 0.1), 0 0 20px rgba(255, 255, 255, 1)  ;
    animation:  animate 1s linear infinite;
}
.span1::before{
    content: '';
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 300px;
    height: 1px;
    background: linear-gradient(90deg, #fff, transparent);
}
@keyframes animate {
    0%
    {
        transform: rotate(315deg) translateX(0);
        opacity: 1;
    }
    70%
    {
        opacity: 1;

    }
    100%
    {
        transform: rotate(315deg) translateX(-1500px);
        opacity: 0;

    }
    
}
.span1:nth-child(1){
    top: 0;
    right: 0;
    left:initial;
    animation-delay:0 ;
    animation-duration: 1s;
}

.span1:nth-child(2){
    top: 0;
    right: 80px;
    left:initial;
    animation-delay:0.2s;
    animation-duration: 3s;
}

.span1:nth-child(3){
    top: 80px;
    right: 0px;
    left:initial;
    animation-delay:0.4s ;
    animation-duration: 2s;
}

.span1:nth-child(4){
    top: 0;
    right: 180px;
    left:initial;
    animation-delay:0.6s;
    animation-duration: 1.5s;
}

.span1:nth-child(5){
    top: 0;
    right: 400px;
    left:initial;
    animation-delay:0.8s;
    animation-duration: 2.5s;
}

.span1:nth-child(6){
    top: 0;
    right: 600px;
    left:initial;
    animation-delay:1s ;
    animation-duration: 3s;
}
.span1:nth-child(7 ){
    top: 300px;
    right: 0px;
    left:initial;
    animation-delay:1s ;
    animation-duration: 1.75s;
}

.span1:nth-child(8){
    top: 0px;
    right: 700px;
    left:initial;
    animation-delay:1.4s ;
    animation-duration: 1.25s;
}

.span1:nth-child(9){
    top: 0px;
    right: 1000px;
    left:initial;
    animation-delay:0.75s ;
    animation-duration: 2.25s;
}

.span1:nth-child(10){
    top: 0px;
    right: 1000px;
    left:initial;
    animation-delay:2.75s ;
    animation-duration: 2.25s;
}
.decorative-section {
    position: fixed;
    overflow: hidden;
}

.image-container {
display: flex;
flex-wrap: wrap;
justify-content: center; /* Căn giữa các hình ảnh trên dòng */
}

.btn-img {
max-width: 160px; /* Điều chỉnh kích thước tối đa của hình ảnh */
margin: 5px; /* Tạo khoảng cách giữa các hình ảnh */
}

@media (max-width: 576px) {
.btn-img {
    max-width: 100px; /* Điều chỉnh kích thước tối đa của hình ảnh trên màn hình di động */
}
}
</style>




      <main>
        <!-- header -->
        <div style=" background-color: rgba(254, 217, 0, 0.9); border-radius: 7px; box-shadow: 0px 2px 5px black;"
    class="pb-1 ">

    <!-- logo -->
    <style>
      .hovered img {
        transform: scale(1.1);
      }

      a img {
        transition: transform 0.3s ease;
      }

      .marquee {
        font-size: 20px;
        overflow: hidden;
        white-space: nowrap;
        width: 50%;
        margin: 0 auto;
        text-align: center;
        padding-top: 10px;
        padding-bottom: 10px;
        font-weight: bold;
      }

      .marquee span {
        display: inline-block;
        animation: marquee 2s linear infinite;
        padding: 0 20px;
        color: white;
      }

      @keyframes marquee {
        0% {
          transform: translateX(100%);
        }

        100% {
          transform: translateX(-100%);
        }
      }

      @keyframes blink {
        0% {
          color: #FFCF00;
        }

        50% {
          color: red;
        }

        100% {
          color: #FFCF00;
        }
      }

      .marquee span {
        animation: marquee 7s linear infinite, blink 1s ease-in-out infinite;
      }

      /* animation: stretch 2s infinite alternate; thành phần co giãn logo */
    </style>
    <div class="p-xs">
      <div class="image-container">
        <a href="trang-chu">
          <center><img style=" width:60%; padding-bottom:10px; pointer-events: none;" src="<?= $logohead; ?>"
          alt="Logo">
          </center>
        </a>
      </div>
    </div>
    <script>
      function addHoverClass(element) {
        element.classList.add("hovered");
      }

      function removeHoverClass(element) {
        element.classList.remove("hovered");
      }
    </script>

    <div class="marquee">
      <span>Chào mừng bạn đến với <?php echo $ten_server ?></span>
    </div>
  </div>

  <div class="col text-center mt-2 ">

    <!-- navbar -->
    <div class="align-items-center my-2 d-flex justify-content-center image-container">
      <a href="trang-chu" onmouseover="addHoverClass(this)" onmouseout="removeHoverClass(this)">
        <img src="/public/images/icon/trangchu.png" alt="Trang Chủ" style="max-width: 160px; pointer-events: none;"
          class="btn-img"></a>
      <a id="logoLink" onmouseover="addHoverClass(this)" onmouseout="removeHoverClass(this)">
        <img src="/public/images/icon/taigame.png" alt="Tải Game" style="max-width: 160px; pointer-events: none;"
          class="btn-img"></a>
      <a href="<?php echo $linkbox; ?>" onmouseover="addHoverClass(this)" onmouseout="removeHoverClass(this)">
        <img src="/public/images/icon/boxzalo.png" alt="Box Zalo" style="max-width: 160px; pointer-events: none;"
          class="btn-img"></a>
    </div>

    <div class="user_name">
      <?php if ($_SESSION['logger']['username']) { ?>
        <center>
          <?php
          if (!$row["gender"]) {
            echo '<img src="../public/images/icon/3.png" />';
          } else {
            echo '<img style="width: 50px;" src="../public/images/icon/' . $row["gender"] . '.png" />';
          }
          ?>
          <br>
        </center>
        <b style="color: #ff0000">
          <?php echo $_SESSION['logger']['username'] ?>
        </b>
        <br>
        <label>
          <a style="color: black;">Số dư : </a>
        </label>
        <b style="color: black;">
          <?= number_format($roww["vnd"]); ?> VNĐ
        </b>
        <br>
      <?php } else { ?>
      <?php } ?>
    </div>



    <?php if ($_SESSION['logger']['username']) { ?>
      <a href="/pages/doimatkhau.php" class="btn btn-action m-1 text-white" style="border-radius: 10px;">
        <i class="fa fa-address-card"></i> Đổi Mật Khẩu </a>

      <!-- <a href="KichHoat" class="btn btn-action m-1 text-white" style="border-radius: 10px;">
        <i class="fa fa-check-circle-o"></i> Kích Hoạt </a> -->
      <a href="/pages/profile.php" class="btn btn-action m-1 text-white" style="border-radius: 10px;">
        <i class="fa fa-user-plus"></i> Nhân vật </a>
      <!-- <a href="/checkIPclone.php" class="btn btn-action m-1 text-white" style="border-radius: 10px;">
        <i class="fa fa-credit-card"></i> Kiểm Tra IP </a>
      <a href="/lichsunap.php" class="btn btn-action m-1 text-white" style="border-radius: 10px;">
        <i class="fa fa-credit-card"></i> Lịch Sử Nạp </a> -->
      <!-- <a href="Giftcode" class="btn btn-action m-1 text-white" style="border-radius: 10px;">
        <i class="fa-solid fa-gift"></i> Danh Sách Giftcode Riêng</a> -->
      <!-- <a href="NhanGift" class="btn btn-action m-1 text-white" style="border-radius: 10px;">
      <i class="fa-solid fa-gift"></i> Nhận Giftcode </a> -->
      <a href="/pages/dangxuat.php" class="btn btn-action m-1 text-white" style="border-radius: 10px;">
        <i class="fa fa-sign-out"></i> Đăng Xuất </a> <br>


      <?php if (sql::isAdmin()) { ?>
        <a href="/Users/Admin/index.php" class="btn btn-action m-1 text-white" style="border-radius: 10px;">
          <i class="fa-solid fa-user-gear"></i> TRANG ADMIN</a> <br>
      <?php } ?>

    <?php } else { ?>
      <a href="/pages/dangnhap.php" onmouseover="addHoverClass(this)" onmouseout="removeHoverClass(this)">
        <img src="/public/images/icon/dangnhap.png" alt="Đăng nhập" style="max-width: 160px; pointer-events: none;"
          class="btn-img"></a>
      <a href="/pages/dangky.php" onmouseover="addHoverClass(this)" onmouseout="removeHoverClass(this)">
        <img src="/public/images/icon/dangky.png" alt="Đăng ký" style="max-width: 160px; pointer-events: none;"
          class="btn-img"></a>
    <?php } ?>

    <!-- <div class="p-1 mt-1 ibox-content"
      style="background-color: rgba(254, 217, 0, 0.9); border-radius: 7px; box-shadow: 0px 2px 5px black; margin-bottom:10px;">
      <div class="p-1 text-white"> -->
        <?php if ($_SESSION['logger']['username']) { ?>

          <div class="align-items-center my-2 d-flex justify-content-center image-container">
            <a href="/napatm.php" onmouseover="addHoverClass(this)" onmouseout="removeHoverClass(this)">
              <img src="/public/images/icon/napcoin.png" alt="Nạp Coin" style="max-width: 200px; pointer-events: none;"
                class="btn-img"></a>
            <a href="/bxh.php" onmouseover="addHoverClass(this)" onmouseout="removeHoverClass(this)">
              <img src="/public/images/icon/bxh.png" alt="Bảng xếp hạng" style="max-width: 200px; pointer-events: none;"
                class="btn-img"></a>
          </div>
          <!-- <div class="align-items-center my-2 d-flex justify-content-between">
            <a href="BXH" type="submit" class="btn btn-lg btn-dark mx-2 auto-resize" style="<?= $nutdangnhapdangkiTO; ?>"
              name="submit" onmouseover="<?= $onmouseover; ?>" onmouseout="<?= $onmouseout; ?>">
              <i class="fa-solid fa-ranking-star"></i> Bảng Xếp Hạng</a>
            <a href="/napatm.php" type="submit" class="btn btn-lg btn-dark mx-2 auto-resize"
              style="<?= $nutdangnhapdangkiTO; ?>" name="submit" onmouseover="<?= $onmouseover; ?>"
              onmouseout="<?= $onmouseout; ?>"><i class="fa fa-money"></i> Nạp Coin</a>
          </div> -->
        <?php } else { ?>
          <div class="align-items-center my-2 d-flex justify-content-center image-container">
            <a href="/napatm.php" onmouseover="addHoverClass(this)" onmouseout="removeHoverClass(this)">
              <img src="/public/images/icon/napcoin.png" alt="Trang Chủ" style="max-width: 180px; pointer-events: none;"
                class="btn-img"></a>
            <a href="/bxh.php" onmouseover="addHoverClass(this)" onmouseout="removeHoverClass(this)">
              <img src="/public/images/icon/bxh.png" alt="Box Zalo" style="max-width: 180px; pointer-events: none;"
                class="btn-img"></a>
          </div>
        <?php } ?>
      <!-- </div>
    </div> -->



    <script src="../animation/animation.js"></script>
    <div id="myModal" class="modal">
      <div class="modal-content" style="border: 5px solid black; background: #fff6c4; border-radius: 30px;">
        <span class="close">&times;</span>

        <div class="image-container">
          <a>
            <center><img style="width:40%; padding-bottom:2px;" src="<?= $logohead; ?>" alt="Logo"></center>
          </a>
        </div>

        <div class="mt-2">
          <div class="card download-bg suggestion" style="border: 2px solid black; border-radius: 30px;">
            <div class="card-body text-center d-flex justify-content-center align-items-center flex-column">
              <h5 class="card-title"><i class="fa-brands fa-android"></i> Phiên Bản Android</h5>
              <p class="card-text">Nhấn vào đây để tải game cho điện thoại Android của bạn.</p>
              <div class="d-flex justify-content-center">
                <a class="btn btn-info1 me-1 mt-1" href="<?= $adr; ?>">
                  <i class="fa fa-download"></i> Tải về ngay
                </a>
                <!-- <a class="btn btn-info1 me-1 mt-1" href="<?= $adrpro; ?>">
                  <i class="fa fa-download"></i> Cấu hình cao
                </a> -->
              </div>
            </div>
          </div>
        </div>

        <div class=" mt-2">
          <div class="card download-bg suggestion" style="border: 2px solid black; border-radius:30px;">
            <div class="card-body text-center">
              <h5 class="card-title"><i class="fa-solid fa-desktop"></i> Phiên Bản PC</h5>
              <p class="card-text">Nhấn vào đây để tải game cho máy tính của bạn.</p>
              <a class="btn btn-info1 me-1 mt-1" href="<?= $pc; ?>"><i class="fa fa-download"></i>
                Tải Ngay</a>
            </div>
          </div>
        </div>

        <div class=" mt-2">
          <div class="card download-bg suggestion" style="border: 2px solid black; border-radius:30px;">
            <div class="card-body text-center">
              <h5 class="card-title"><i class="fa-brands fa-apple"></i> Phiên Bản IOS </h5>
              <p class="card-text">Nhấn vào đây để tải game cho điện thoại Iphone của bạn.</p>
              <div class="d-flex justify-content-center">
                <!-- <a class="btn btn-info1 me-1 mt-1" href="<?= $testflight; ?>"><i class="fa fa-download"></i>
                  TestFlight</a> -->
                <a class="btn btn-info1 me-1 mt-1" href="<?= $ios; ?>"><i class="fa fa-download"></i> File IPA</a>

              </div>
            </div>
          </div>
        </div>

        <div class=" mt-2">
          <div class="card download-bg suggestion" style="border: 2px solid black; border-radius:30px;">
            <div class="card-body text-center">
              <h5 class="card-title"><i class="fa-brands fa-java"></i> Phiên Bản Java</h5>
              <p class="card-text">Nhấn vào đây để tải giả lập Jar</p>
              <a class="btn btn-info1 me-1 mt-1" href="<?= $jar; ?>"><i class="fa fa-download"></i>
                Tải Jar</a>
            </div>
          </div>
        </div>

      </div>
    </div>

    <script>
      // Get the modal element
      var modal = document.getElementById("myModal");

      // Get the link element
      var link = document.getElementById("logoLink");

      // When the user clicks the link, show the modal
      link.onclick = function () {
        modal.style.display = "block";
      };

      // When the user clicks on the close button (X), close the modal
      var closeBtn = modal.getElementsByClassName("close")[0];
      closeBtn.onclick = function () {
        modal.style.display = "none";
      };

      // Close the modal if the user clicks outside of it
      window.onclick = function (event) {
        if (event.target == modal) {
          modal.style.display = "none";
        }
      };

    </script>

  </div>