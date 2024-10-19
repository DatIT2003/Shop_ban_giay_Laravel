@extends('welcome')
@section('content')

<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{URL::to('/')}}">Trang Chủ</a></li>
				  <li class="active">Thanh Toán Giỏ Hàng</li>
				</ol>
			</div>
			

			<div class="review-payment">
				<h2>Xem Lại Giỏ Hàng</h2>
			</div>
            <div class="table-responsive cart_info">


				<?php

				use Gloudemans\Shoppingcart\Facades\Cart;

				$content = Cart::content();
				
				?>


				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Hình Ảnh Sản Phẩm</td>
							<td class="description">Mô Tả</td>
							<td class="price">Giá</td>
							<td class="quantity">Số Lượng</td>
							<td class="total">Tổng Tiền</td>
							<td></td>
						</tr>
					</thead>
					<tbody>

					@foreach ($content as $v_content)
					
					
							<tr>
								<td class="cart_product">
									<a href=""><img src="{{URL::to('public/upload/product/'.$v_content->options->image)}}" width="100" alt="" /></a>
								</td>
								<td class="cart_description">
									<h4><a href="">{{$v_content->name}}</a></h4>
									<p>{{$v_content->id}}</p>
								</td>
								<td class="cart_price">
									<p>{{$v_content->price.' vnd'}}</p>
								</td>
								<td class="cart_quantity">
									<div class="cart_quantity_button">
										<form action="{{URL::to('/update-cart-quantity')}}" method="POST">

											{{csrf_field()}}

											<input class="cart_quantity_input" type="text" name="cart_quantity" value="{{$v_content->qty}}" >
											<input type="hidden" value="{{$v_content->rowId}}" name="rowId_cart" class="form-control">
											<input type="submit" value="cập Nhập" name="update_qty" class="btn btn-default btn-sm">

										</form>
									</div>
								</td>
								<td class="cart_total">
									<p class="cart_total_price">
									<?php
										$subtotal = $v_content->price * $v_content->qty;

										echo number_format($subtotal).' vnd';

									?>

									</p>
								</td>
								<td class="cart_delete">
									<a class="cart_quantity_delete" href="{{URL::to('/delete-to-cart/'.$v_content->rowId)}}"><i class="fa fa-times"></i></a>
								</td>
							</tr>

						@endforeach

					</tbody>
				</table>
			</div>
			<h4 style="margin:40px 0;font-size:20px;">Chọn Hình Thức Thanh Toán</h4>
				<form method="POST" action="{{URL::to('/order-place')}}">
					{{csrf_field()}}
					<div class="payment-options">
						<span>
							<label><input name="payment_option" value="1" type="radio"> Trả Bằng Thẻ ATM</label>
						</span>
						<span>
							<label><input name="payment_option" value="2" type="radio"> Nhận Tiền Mặt</label>
						</span>
						<span>
							<label><input name="payment_option" value="3" type="radio"> Trả Bằng Thẻ Ghi Nợ</label>
						</span>
						<input type="submit" value="Đặt Hàng" name="send_order_place" class="btn btn-primary btn-sm">
					</div>
				</form>

				<div class="review-button">
					<form action="{{URL::to('/review-order')}}" method="GET">
						<button type="submit" class="btn btn-primary btn-sm">Xem lại Thông tin Thanh Toán</button>
					</form>
				</div>
		</div>
	</section> <!--/#cart_items-->

@endsection