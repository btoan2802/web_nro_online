<?php
require_once('core/config.php');
require_once('core/head.php');

?>
<style>
	.announcement {
		background-color: #fff6c4;
		color: #333;
		font-weight: bold;
		margin-bottom: 5px;
		border-radius: 7px;
		border: 3px solid black;
		padding: 5px;
	}

	.announcement-text {
		font-size: 50px;
		font-weight: bold;
		margin: 0;
	}

	.announcement p {
		margin: 0;
	}

	.announcement-info {
		font-size: 15px;
		display: none;
		margin-top: 10px;
		background-color: white;
		border: 2px solid white;
		padding: 10px;
		border-radius: 5px;
	}

	.announcement-info.active {
		display: block;
	}

	.ent-info {
		font-size: 12px;
		display: none;
		margin-top: 10px;
		background-color: white;
		border: 2px solid white;
		padding: 10px;
		border-radius: 5px;
	}

	.ent-info.active {
		display: block;
	}

	.row1 {
		display: flex;
		flex-wrap: wrap;
		justify-content: center;
		/* Canh giữa các thẻ trong dòng */
		padding: 10px;
	}
</style>
<script>
	function toggleInfo(id) {
		var info = document.getElementById('info' + id);
		info.classList.toggle('active');
	}
</script>

<main>

	<script>
		window.addEventListener('resize', function () {
			const buttons = document.getElementsByClassName('auto-resize');
			for (let i = 0; i < buttons.length; i++) {
				const button = buttons[i];
				const fontSize = parseInt(window.getComputedStyle(button, null).getPropertyValue('font-size'));
				const buttonWidth = button.offsetWidth;
				const textWidth = button.scrollWidth;
				if (textWidth > buttonWidth) {
					button.style.fontSize = (fontSize - 1) + 'px';
				}
			}
		});
		window.dispatchEvent(new Event('resize'));
	</script>

	<div class="p-1 mt-1 ibox-content"
		style="background-color: rgba(254, 217, 0, 0.9); border-radius: 7px; box-shadow: 0px 2px 5px black;">

		<div class="p-1 text-white">
			<h5 class="h3 mb-3 font-weight-normal text-white"
				style="text-align:center;padding-top: 3px; font-weight: bold; text-shadow: 2px 2px 2px #000;">Bảng Thông
				Tin</h5>

			<div class="announcement">
				<div class="announcement-title" style="color:white;">
					<div class="post-item d-flex align-items-center my-2">
						<div class="post-image"><img src="/public/images/logo/goku.png"
								style="width: 55px; margin-left:10px ; margin: 8px; height: auto; object-fit: contain; pointer-events: none;">
						</div>
						<div>
							<a class="fw-bol" href="ThongTin">Giải thích Cơ chế Game</a>
							<div class="text-muted font-weight-bold">Đăng bởi <span
									style="color: red;">Admin</span><span class="fb-comments-count"
									data-href="#"></span></div>
						</div>
						<div class="post-image">
							<img src="/public/images/logo/new.gif"
								style="width: 80% ; margin-left: 10px; margin: 8px; height: auto; object-fit: contain; float: left;">
						</div>
					</div>
				</div>
			</div>
			
			<!-- <div class="announcement">
				<div class="announcement-title" style="color:white;">
					<div class="post-item d-flex align-items-center my-2">
						<div class="post-image"><img src="/public/images/icon/share.png"
								style="width: 55px; margin-left:10px ; margin: 8px; height: auto; object-fit: contain; pointer-events: none;">
						</div>
						<div>
							<a class="fw-bol" href="SuKienShare">Sự kiện Share Bài viết Nhận code</a>
							<div class="text-muted font-weight-bold">Đăng bởi <span
									style="color: red;">Admin</span><span class="fb-comments-count"
									data-href="#"></span></div>
						</div>
						<div class="post-image">
							<img src="/public/images/logo/new.gif"
								style="width: 80% ; margin-left: 10px; margin: 8px; height: auto; object-fit: contain; float: left;">
						</div>
					</div>
				</div>
			</div>

			<div class="announcement">
				<div class="announcement-title" style="color:white;">
					<div class="post-item d-flex align-items-center my-2">
						<div class="post-image"><img src="/public/images/logo/shop.png"
								style="width: 55px;margin-left:10px ; margin: 8px; height: auto; object-fit: contain; pointer-events: none;">
						</div>
						<div>
							<a class="fw-bol" href="SHOPS">Shop Vật Phẩm</a>
							<div class="text-muted font-weight-bold">Đăng bởi <span
									style="color: red;">Admin</span><span class="fb-comments-count"
									data-href="#"></span></div>
						</div>
						<div class="post-image">
							<img src="/public/images/logo/new.gif"
								style="width: 80% ; margin-left: 10px; margin: 8px; height: auto; object-fit: contain; float: left;">
						</div>
					</div>
				</div>
			</div>

			<div class="announcement">
				<div class="announcement-title" style="color:white;">
					<div class="post-item d-flex align-items-center my-2">
						<div class="post-image"><img src="/public/images/logo/thoivang.png"
								style="width: 55px;margin-left:10px ; margin: 8px; height: auto; object-fit: contain; pointer-events: none;">
						</div>
						<div>
							<a class="fw-bol" href="DoiThoiVang">Đổi Thỏi vàng</a>
							<div class="text-muted font-weight-bold">Đăng bởi <span
									style="color: red;">Admin</span><span class="fb-comments-count"
									data-href="#"></span></div>
						</div>
						<div class="post-image">
							<img src="/public/images/logo/new.gif"
								style="width: 80% ; margin-left: 10px; margin: 8px; height: auto; object-fit: contain; float: left;">
						</div>
					</div>
				</div>
			</div> -->

			<!--<div class="announcement" onclick="toggleInfo(1)">
				<div class="announcement-title" style="color:white;">
					<div class="post-item d-flex align-items-center my-2">
						<div class="post-image"><img src="/public/images/logo/quatop.png"
								style="width: 55px;margin-left:10px ; margin: 8px; height: auto; object-fit: contain; pointer-events: none;">
						</div>
						<div>
							<a class="fw-bold ">Đua Top Test Nhận quà Open <?php echo $ten_server ?></a>
							<div class="text-muted font-weight-bold">Đăng bởi <span style="color: red;">Admin</span>
							</div>
						</div>
						<div class="post-image">
							<img src="/public/images/logo/new.gif"
								style="width: 80% ; margin-left: 10px; margin: 8px; height: auto; object-fit: contain; float: left;">
						</div>
					</div>
				</div>
				<div id="info1" class="ent-info">
					<span style="color: blue; font-weight: bold; font-size: 20px;">TOP SỨC MẠNH</span><br>
					-TOP 1 : 6.000 Thỏi vàng, 1.000 Hộp pháp sư, 5.000 Hộp Sổ sưu tầm, Ác linh nhí (Linh thú) 60% Chỉ số, 50 Ngọc rồng siêu
					cấp <br>
					-TOP 2 : 4.000 Thỏi vàng, 500 Hộp pháp sư, 4.000 Hộp Sổ sưu tầm, Ác linh nhí (Linh thú) 60% Chỉ số, 20 Ngọc rồng siêu
					cấp <br>
					-TOP 3 : 2.000 Thỏi vàng, 300 Hộp pháp sư, 3.000 Hộp Sổ sưu tầm, Ác linh nhí (Linh thú) 60% Chỉ số, 10 Ngọc rồng siêu
					cấp <br>
					-TOP 4 đến TOP 10 : 1.000 Thỏi vàng, 10 Ngọc rồng siêu cấp <br>
					<span style="color: red;">(Chốt Top vào 21h Ngày 25/02/2025)<br></span>
					<span style="color: orange;">*Lưu ý: <br>
					-Top Sức mạnh sẽ tính Ưu tiên theo: Cấp Chuyển sinh > Sức mạnh > Cấp đệ tử > Sức mạnh đệ<br>
					-Cấp đệ tử theo thứ tự ưu tiên giảm dần là: Zeno > Berus > Mabu > Đệ Thường<br>
					+ Đổi đệ tử Berus cần Đệ Mabu đã mở Skill 4<br>
					+ Đổi đệ tử Zeno cần Đệ Berus đã mở Skill 4</span> <br> <br>
					
					<span style="color: blue; font-weight: bold; font-size: 20px;">TOP NHIỆM VỤ</span><br>
					-TOP 1 : 6.000 Thỏi vàng, 1.000 Hộp pháp sư, 5.000 Hộp Sổ sưu tầm, Thú cưỡi Huyết Long 30% Chỉ số, 50 Ngọc rồng siêu cấp
					<br>
					-TOP 2 : 4.000 Thỏi vàng, 500 Hộp pháp sư, 4.000 Hộp Sổ sưu tầm, Thú cưỡi Huyết Long 30% Chỉ số, 20 Ngọc rồng siêu cấp
					<br>
					-TOP 3 : 2.000 Thỏi vàng, 300 Hộp pháp sư, 3.000 Hộp Sổ sưu tầm, Thú cưỡi Huyết Long 30% Chỉ số, 10 Ngọc rồng siêu cấp
					<br>
					-TOP 4 đến TOP 10 : 1.000 Thỏi vàng, 10 Ngọc rồng siêu cấp <br>
					<span style="color: red;">(Chốt Top vào 21h Ngày 26/02/2025)</span> <br> <br>

					<span style="color: blue; font-weight: bold; font-size: 20px;">TOP NẠP COIN</span><br>
					-TOP 1 : 20.000 Thỏi vàng, 5.000 Hộp pháp sư, 10.000 Hộp Sổ sưu tầm, Pet Gà Chín Cựa 70% Chỉ số, Cánh Thiên Thần 80% Chỉ số,
					100 Ngọc rồng siêu cấp <br>
					-TOP 2 : 10.000 Thỏi vàng, 3.000 Hộp pháp sư, 7.000 Hộp Sổ sưu tầm, Pet Ngựa chín lmao 60% Chỉ số, Cánh Thiên Thần 80%
					Chỉ số, 50 Ngọc rồng siêu cấp <br>
					-TOP 3 : 7.000 Thỏi vàng, 2.000 Hộp pháp sư, 5.000 Hộp Sổ sưu tầm, Pet Ngựa chín lmao 60% Chỉ số, 50 Ngọc rồng siêu cấp
					<br>
					-TOP 4 đến TOP 10 : 7000 Thỏi vàng, Pet Voi chín ngà 50% Chỉ số, 1.000 Hộp pháp sư, 50 Ngọc rồng
					siêu cấp <br>
					<span style="color: red;">(Chốt Top vào 21h Ngày 28/02/2025)</span> <br> <br>
					<span style="color: dodgerblue; font-weight: bold; font-size: 16px;">**Lưu ý : Riêng Top Nhiệm Vụ và
						Top Sức mạnh một người chỉ được chọn 1 nếu lọt vào cả 2 top**</span>

				</div>
			</div>-->


			
		</div>
	</div>
	<br>

	<div class="p-1 mt-1 ibox-content"
		style="background-color: #ffe967; border-radius: 7px; box-shadow: 0px 2px 5px black;">

			<h5 class="h3 mb-3 font-weight-normal"
				style="text-align:center;padding-top: 3px; font-weight: bold;">Giới thiệu
				chung</h5>
			<div class="content-banner-slide">
				<div class="slider">
					<div class="row position-relative">
						<div class="col-12 slider_in">
							<div class="swiper-container mySwiper slider_detail swiper-container-horizontal">
								<div class="swiper-wrapper">
									<div class="swiper-slide">
										<a href="javascript:void(0)">
											<img src="/public/images/trangchinh/td.png" alt=""
												class="img-fluid swiper-lazy w-100 loading_lazy" data-ignore="true">
										</a>
									</div>
									<div class="swiper-slide">
										<a href="javascript:void(0)">
											<img src="/public/images/trangchinh/nm.png" alt=""
												class="img-fluid swiper-lazy w-100 loading_lazy" data-ignore="true">
										</a>
									</div>
									<div class="swiper-slide">
										<a href="javascript:void(0)">
											<img src="/public/images/trangchinh/xd.png" alt=""
												class="img-fluid swiper-lazy w-100 loading_lazy" data-ignore="true">
										</a>
									</div>
								</div>
								<img class="swiper-button-prev" src="/public/images/trangchinh/mui_ten_2.png">
								<img class="swiper-button-next" src="/public/images/trangchinh/mui_ten_1.png">
							</div>
						</div>
					</div>
				</div>
			</div>

			<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

			<script>
				document.addEventListener('DOMContentLoaded', function () {
					var mySwiper = new Swiper('.mySwiper', {
						loop: true,
						centeredSlides: true,
						slidesPerView: 1,
						spaceBetween: 10,
						autoplay: {
							delay: 4000,
							disableOnInteraction: false,
						},
						navigation: {
							nextEl: '.swiper-button-next',
							prevEl: '.swiper-button-prev',
						},
						breakpoints: {
							768: {
								slidesPerView: 1,
							},
						},
					});
				});
			</script>
			<div>
				<div class="ant-col ant-col-24 title_index_info">Hướng Dẫn Tân Thủ </div>
				<div class="ant-col ant-col-24">
					<div class="text_info_index" style="display:flex">
						<a><strong>1. Đăng ký tài khoản</strong>
							<br />
							Bạn có thể đăng ký tài khoản miễn phí ngay trên trang Trang chủ của
							<?php echo $ten_server ?><br />
							<strong>2. Hướng dẫn điều khiển</strong>
							<br />
							-Đối với máy bàn phím: Dùng phím mũi tên, phím số, để điều
							khiển nhân vật. Phím chọn giữa để tương tác.<br />
							-Đối với máy cảm ứng: Dùng
							tay chạm vào màn hình cảm ứng để di chuyển. Chạm nhanh 2 lần vào 1 đối tượng
							để tương tác.<br />
							-Đối với PC: Dùng chuột, click chuột phải để di chuyển,
							click chuột trái để chọn, click đôi vào đối tượng để tương tác<br />
							<strong>3. Một số thông tin căn bản</strong>
							<br />
							- Đậu thần dùng để tăng KI và HP ngay lập tức.<br />
							- Bạn chỉ mang theo người được 10 hạt đậu. Nếu muốn mang nhiều hơn, hãy xin từ bạn bè trong
							Bang.<br />
							- Tất cả các sách kỹ năng đều có thể học miễn phí tại Quy Lão Kame, khi bạn có đủ điểm tiềm
							năng.<br />
							- Bạn không thể bay, dùng kỹ năng, nếu hết KI.<br />
							- Tấn công quái vật cùng bạn bè trong Bang sẽ mang lại nhiều điểm tiềm năng hơn đánh một
							mình.<br />
							- Tập luyện với bạn bè tại khu vực thích hợp sẽ mang lại nhiều điểm tiềm năng hơn
							đánh quái vật.<br />
							- Khi được nâng cấp, đậu thần sẽ phục hồi nhiều HP và KI hơn.<br />
							- Vào trò chơi đều đặn mỗi ngày để nhận được Ngọc miễn phí.<br />
							- Đùi gà sẽ phục hồi 100% HP, KI. Cà chua phục hồi 100% KI. Cà rốt phục hồi
							100% HP.<br />
							- Cây đậu thần kết một hạt sau một thời gian, cho dù bạn đang
							offline.<br />
							- Sau 3 ngày không tham gia trò chơi, bạn sẽ bị giảm sức mạnh
							do lười luyện tập.<br />
							- Bạn sẽ giảm thể lực khi đánh quái, nhưng sẽ tăng
							lại thể lực khi không đánh nữa.
							<br />
						</a>
					</div>
				</div>
				<div class="ant-col ant-col-24 title_index_info">Giới thiệu</div>
				<div class="ant-col ant-col-24 text_info_index">
					<div style="background:#fff6c4;padding:10px;border-radius:10px">
						- Trò Chơi Trực Tuyến với cốt truyện xoay quanh bộ truyện tranh 7 viên Ngọc
						Rồng. Người chơi sẽ hóa thân thành một trong những anh hùng của 3 hành tinh:
						Trái Đất, Xayda, Namếc. Cùng luyện tập, tăng cường sức mạnh và kỹ năng. Đoàn
						kết cùng chiến đấu chống lại các thế lực hung ác. Cùng nhau tranh tài.<br />
						*** Đặc điểm nổi bật:<br />
						- Thể loại hành động, nhập vai. Trực tiếp điều khiển nhân
						vật hành động. Dễ chơi, dễ điều khiển nhân vật. Đồ họa sắc nét. Có phiên bản
						đồ họa cao cho điện thoại mạnh và phiên bản pixel cho máy cấu hình
						thấp.<br />
						- Cốt truyện bám sát nguyên tác. Người chơi sẽ gặp tất cả nhân
						vật từ Bunma, Quy lão kame, Jacky-chun, Tàu Pảy Pảy... cho đến Fide, Pic,
						Poc, Xên, Broly, đội Bojack.<br />
						- Đặc điểm nổi bật nhất: Tham gia đánh
						doanh trại độc nhãn. Tham gia đại hội võ thuật. Tham gia săn lùng ngọc rồng
						để mang lại điều ước cho bản thân.<br />
						- Tương thích tất cả các dòng máy
						trên thị trường hiện nay: Máy tính PC, Điện thoại di động Nokia Java,
						Android, iPhone, Windows Phone, và máy tính bảng Android, iPad.
					</div>
				</div>
			</div>
		</div>
</main>

<br>

<?php require_once('core/end.php'); ?>


<script type="text/javascript">
	$(document).ready(function () {
		$('#Noti_Home').modal('show');
	})
</script>
<?php require_once('core/end.php'); ?>