<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home | K-Shoes</title>
    <link href="{{asset('frontend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/animate.css')}}" rel="stylesheet">
	<link href="{{asset('frontend/css/main.css')}}" rel="stylesheet">
	<link href="{{asset('frontend/css/responsive.css')}}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="{{('frontend/images/ico/favicon.ico')}}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<body>
@if (session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif


	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i> +84 0123456789</a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> vandat@gmail.com</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->
		
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="/Trang-chu"><img src="{{('upload/product/kingshops.png')}}" alt="" height="50px"/></a>
						</div>
						<div class="btn-group pull-right">
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
									USA
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="#">Canada</a></li>
									<li><a href="#">UK</a></li>
								</ul>
							</div>
							
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
									DOLLAR
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="#">Canadian Dollar</a></li>
									<li><a href="#">Pound</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">
								
									<!-- <a href="#"><i class="fa fa-star"></i> Yêu Thích</a> -->


									
									<?php

										use Illuminate\Support\Facades\DB;
										use Illuminate\Support\Facades\Session;
										$customer_id = Session::get('customer_id');
										$shipping_id = Session::get('shipping_id');
										if($customer_id != null) {
											$customer = DB::table('tbl_customers')->where('customer_id', $customer_id)->first();
    										$customer_name = $customer ? $customer->customer_name : 'Guest';
											?>
											
												<li><i class="fa fa-user"></i> Xin Chào Bạn, <?php echo htmlspecialchars($customer_name, ENT_QUOTES, 'UTF-8'); ?></li>

											<?php
										}
										if($customer_id != null) {
									?>
											<li><a href="{{ route('favorites') }}"><i class="fa fa-star"></i> Yêu Thích</a></li>
									<?php
										} else {
									?>
											<li><a href="{{ URL::to('/login-checkout') }}"><i class="fa fa-crosshairs"></i> yêu thích</a></li>
									<?php
										}
								
										if($customer_id != Null && $shipping_id == Null) {

									?>
										<li><a href="{{URL::to('/checkout')}}"><i class="fa fa-crosshairs"></i> Thanh Toán</a></li>

									<?php 
										}elseif ($customer_id != Null && $shipping_id != Null) {
									?>
										<li><a href="{{URL::to('/payment')}}"><i class="fa fa-crosshairs"></i> Thanh Toán</a></li>
									<?php }else {
										?>
										<li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-crosshairs"></i> Thanh Toán</a></li>
										<?php
									}
									?>

								

								<li><a href="{{URL::to('/show-cart')}}"><i class="fa fa-shopping-cart"></i> Giỏ Hàng</a></li>


								<?php
									$customer_id = Session::get('customer_id');

									if($customer_id != Null) {

								?>
									<li><a href="{{URL::to('/logout-checkout')}}"><i class="fa fa-lock"></i> Đăng xuất</a></li>

								<?php 
									}else {
								?>
									<li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-lock"></i> Đăng Nhập</a></li>
								<?php }
									if($customer_id != Null) {
								?>
									<li><a href="{{ route('track-order') }}">Theo Dõi Các Đơn Hàng Của Bạn</a></li>
								<?php
									}
								?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
	
		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-7">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="{{URL::to('/Trang-chu')}}" class="active">Trang chủ</a></li>
								<li class="dropdown"><a href="{{URL::to('/Trang-chu')}}">Sản Phẩm<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
										@foreach ($brand as $key => $brands )
											<li><a href="{{URL::to('/thuong-hieu-san-pham/'.$brands->id)}}"> <span class="pull-right"></span>{{$brands->name}}</a></li>
										@endforeach
										
                                    </ul>
                                </li> 
								<li class="dropdown"><a href="{{URL::to('/tintuc')}}">Tin Tức<i class="fa fa-angle-down"></i></a></li> 
								<li><a href="{{URL::to('/show-cart')}}">Giỏ Hàng</a></li>
								<li><a href="{{URL::to('/contact')}}">Liên Hệ</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-5">
						<form action="{{URL::to('/tim-kiem')}}" method="POST">
						{{csrf_field()}}
							<div class="search_box pull-right">
								<input type="text" name="keywords_submit" placeholder="Tìm Kiếm Sản Phẩm"/>
								<input type="submit" style="margin-top:0;color:#666" name="search_item" class="btn btn-primary btn-sm" value="Tìm Kiếm" />
							</div>

						</form>
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->
	
	<section id="slider"><!--slider-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div id="slider-carousel" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
							<li data-target="#slider-carousel" data-slide-to="1"></li>
							<li data-target="#slider-carousel" data-slide-to="2"></li>
						</ol>
						
						<div class="carousel-inner">
							<div class="item active">
								<div class="col-sm-6">
									<h1><span>K</span>-SHOES</h1>
									<h2>Free E-Commerce Template</h2>
									<p>Giày Tây Da Nam Clarks - Chantry Walk là một sản phẩm thời trang nam tích hợp sự sang trọng và thoải mái, đặc trưng của thương hiệu Clarks. </p>
									<button type="button" class="btn btn-default get">Get it now</button>
								</div>
								<div class="col-sm-6">
									<img src="{{('upload/product/clarks23.jpg')}}" class="girl img-responsive" alt="" />
								</div>
							</div>
							<div class="item">
								<div class="col-sm-6">
									<h1><span>K</span>-SHOES</h1>
									<h2>100% Responsive Design</h2>
									<p>Giày lười nam Clarks da mềm màu xanh GCL-05X là một sự kết hợp hoàn hảo giữa phong cách hiện đại và thoải mái. </p>
									<button type="button" class="btn btn-default get">Get it now</button>
								</div>
								<div class="col-sm-6">
                                	<img src="{{('upload/product/clarks181.jpg')}}" class="girl img-responsive" alt="" />
								</div>
							</div>
							
							<div class="item">
								<div class="col-sm-6">
									<h1><span>K</span>-SHOES</h1>
									<h2>Free Ecommerce Template</h2>
									<p>Giày Clarks 'Brown' 261684027 là một lựa chọn đẳng cấp và phong cách cho những người muốn kết hợp giữa sự thoải mái và phong cách trong một đôi giày. </p>
									<button type="button" class="btn btn-default get">Get it now</button>
								</div>
								<div class="col-sm-6">
                                	<img src="{{('upload/product/clarks35.png')}}" class="girl img-responsive" alt="" />
								</div>
							</div>
							
						</div>
						
						<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
							<i class="fa fa-angle-left"></i>
						</a>
						<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
					
				</div>
			</div>
		</div>
	</section><!--/slider-->
	
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
						<h2>Danh Mục Sản Phẩm</h2>
						<div class="panel-group category-products" id="accordian"><!--category-productsr-->
							
							@foreach ($category as $key => $cate )
							
							
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a href="{{URL::to('/danh-muc-san-pham/'.$cate->category_id)}}">
												{{$cate->category_name}}
											</a>
										</h4>
									</div>
								</div>

							@endforeach
						</div><!--/category-products-->
					
						<div class="brands_products"><!--brands_products-->
							<h2>Thương Hiệu Sản Phẩm</h2>
							<div class="brands-name">
								<ul class="nav nav-pills nav-stacked">
									@foreach ($brand as $key => $brands )
										<li><a href="{{URL::to('/thuong-hieu-san-pham/'.$brands->id)}}"> <span class="pull-right"></span>{{$brands->name}}</a></li>
									@endforeach
									
								</ul>
							</div>
						</div><!--/brands_products-->

						
					
					</div>
				</div>
				
				<div class="col-sm-9 padding-right">
                    @yield('content')

				</div>
			</div>
		</div>
	</section>
	
	<footer id="footer"><!--Footer-->
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="companyinfo">
							<h2><span>K</span>-Shoes</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,sed do eiusmod tempor</p>
						</div>
					</div>
					<div class="col-sm-7">
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="{{asset('upload/product/converse371.jpg')}}" alt="" height="60px" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Converse chuck taylor all star classic low xanh navy</p>
								<h2>24 DEC 2023</h2>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
                                    <img src="{{asset('upload/product/img105.jpeg')}}" alt="" style="height: 60px;"/>
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>NIKE AIR JORDAN 1 CMFT 2</p>
								<h2>24 DEC 2023</h2>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
                                    <img src="{{asset('upload/product/puma197.jpg')}}" alt="" style="height: 60px;"/>
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Puma Ignite Elevate Blue</p>
								<h2>24 DEC 2023</h2>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
                                    <img src="{{asset('upload/product/teva173.jpg')}}" alt="" style="height: 60px; "/>
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Sandals Nam Teva Hurricane Xlt2</p>
								<h2>24 DEC 2023</h2>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="address">
							<img src="{{asset('frontend/images/map.png')}}" alt="" />
							<p>505 S Atlantic Ave Virginia Beach, VA(Virginia)</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="footer-widget">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Service</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Online Help</a></li>
								<li><a href="#">Contact Us</a></li>
								<li><a href="#">Order Status</a></li>
								<li><a href="#">Change Location</a></li>
								<li><a href="#">FAQ’s</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Quock Shop</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">T-Shirt</a></li>
								<li><a href="#">Mens</a></li>
								<li><a href="#">Womens</a></li>
								<li><a href="#">Gift Cards</a></li>
								<li><a href="#">Shoes</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Policies</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Terms of Use</a></li>
								<li><a href="#">Privecy Policy</a></li>
								<li><a href="#">Refund Policy</a></li>
								<li><a href="#">Billing System</a></li>
								<li><a href="#">Ticket System</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>About Shopper</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Company Information</a></li>
								<li><a href="#">Careers</a></li>
								<li><a href="#">Store Location</a></li>
								<li><a href="#">Affillate Program</a></li>
								<li><a href="#">Copyright</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3 col-sm-offset-1">
						<div class="single-widget">
							<h2>About Shopper</h2>
							<form action="#" class="searchform">
								<input type="text" placeholder="Your email address" />
								<button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
								<p>Get the most recent updates from <br />our site and be updated your self...</p>
							</form>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left">Copyright © 2024 Bản quyền thuộc về tôi.</p>
					<p class="pull-right">Designed by <span><a target="_blank" href="http://www.themeum.com">Themeum</a></span></p>
				</div>
			</div>
		</div>
		
	</footer><!--/Footer-->
	
	<script type="text/javascript">
	$(document).ready(function() {
    $('.add-to-cart').click(function() {
        var id = $(this).data('id_product');

        // Kiểm tra giá trị từ các trường dữ liệu
        var cart_product_id = $('.cart_product_id_' + id).val();
        var cart_product_name = $('.cart_product_name_' + id).val();
        var cart_product_image = $('.cart_product_image_' + id).val();
        var cart_product_quantity = $('.cart_product_quantity_' + id).val();
        var cart_product_price = $('.cart_product_price_' + id).val();
        var cart_product_qty = $('.cart_product_qty_' + id).val();
        var _token = $('input[name="_token"]').val();
		if(parseInt(cart_product_qty)>parseInt(cart_product_quantity)){
			alert('Làm ơn đặt nhỏ' + cart_product_quantity);
		}else{

			$.ajax({
        url: '/add-cart-ajax',
        method: 'POST',
        data: {
            cart_product_id: cart_product_id,
            cart_product_name: cart_product_name,
            cart_product_image: cart_product_image,
            cart_product_quantity: cart_product_quantity,
            cart_product_qty: cart_product_qty,
            _token: _token
        },
            success: function() {
                swal({
                    title: "Đã thêm sản phẩm vào giỏ hàng",
                    text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để thanh toán",
                    showCancelButton: true,
                    cancelButtonText: "Xem tiếp",
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "Đi đến giỏ hàng",
                    closeOnConfirm: false
                },
                function() {
                    window.location.href = "{{ url('/show-cart') }}";
                });
            }
        });
	}
    });
});
</script>

  
    <script src="{{asset('frontend/js/jquery.js')}}"></script>
	<script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('frontend/js/jquery.scrollUp.min.js')}}"></script>
	<script src="{{asset('frontend/js/price-range.js')}}"></script>
    <script src="{{asset('frontend/js/jquery.prettyPhoto.js')}}"></script>
    <script src="{{asset('frontend/js/main.js')}}"></script>
</body>
</html>