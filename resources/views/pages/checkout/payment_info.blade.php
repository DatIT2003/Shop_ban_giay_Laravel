@extends('welcome')
@section('content')

<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{URL::to('/')}}">Trang Chủ</a></li>
                <li class="active">Thông Tin Thanh Toán</li>
            </ol>
        </div>

        <div class="review-payment">
            <h2>Xem Lại Thông Tin Thanh Toán</h2>
        </div>

        <div class="table-responsive cart_info">
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
                            <p>Web ID: {{$v_content->id}}</p>
                        </td>
                        <td class="cart_price">
                            <p>{{$v_content->price.' vnd'}}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <form action="{{URL::to('/update-cart-quantity')}}" method="POST">
                                    {{csrf_field()}}
                                    <input class="cart_quantity_input" type="text" name="cart_quantity" value="{{$v_content->qty}}">
                                    <input type="hidden" value="{{$v_content->rowId}}" name="rowId_cart" class="form-control">
                                    <input type="submit" value="Cập Nhật" name="update_qty" class="btn btn-default btn-sm">
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

        <div class="bill-to">
            <p>Thông Tin Gửi Hàng</p>
            <form action="{{URL::to('/save-checkout-customer')}}" method="POST">
                {{ csrf_field() }}
                <input type="text" name="shipping_email" placeholder="Email" value="{{$shipping->shipping_email}}">
                <input type="text" name="shipping_name" placeholder="Họ Và Tên" value="{{$shipping->shipping_name}}">
                <input type="text" name="shipping_address" placeholder="Địa Chỉ" value="{{$shipping->shipping_address}}">
                <input type="text" name="shipping_phone" placeholder="Số Điện thoại" value="{{$shipping->shipping_phone}}">
                <textarea name="shipping_notes" placeholder="Ghi Chú Đơn Hàng Của Bạn" rows="16"></textarea>
                <input type="submit" value="Cập Nhật Thông Tin" name="update_shipping" class="btn btn-primary btn-sm">
            </form>
        </div>

        <div class="payment-options">
            <h4 style="margin:40px 0;font-size:20px;">Chọn Hình Thức Thanh Toán</h4>
            <form method="POST" action="{{URL::to('/order-place')}}">
                {{csrf_field()}}
                <div>
                    <label><input name="payment_option" value="1" type="radio"> Trả Bằng Thẻ ATM</label>
                    <label><input name="payment_option" value="2" type="radio"> Nhận Tiền Mặt</label>
                    <label><input name="payment_option" value="3" type="radio"> Trả Bằng Thẻ Ghi Nợ</label>
                </div>
                <div>
                    <input type="submit" value="Thanh Toán" name="send_order_place" class="btn btn-primary btn-sm">
                </div>
            </form>
        </div>

        <div class="total_area">
            <ul>
                <?php
                use Gloudemans\Shoppingcart\Facades\Cart;
                use Illuminate\Support\Facades\Session;
    
                $content = Cart::content();
                ?>
                <li>Tổng <span>{{ Cart::subtotal(0,',').' vnd' }}</span></li>
                <li>Thuế <span>{{ Cart::tax(0,',').' vnd' }}</span></li>
                <li>Phí Vận Chuyển <span>{{ number_format($shipping_fee).' vnd' }}</span></li>
                @if(Session::has('shipping_discount_amount'))
                <li>Giảm Phí Ship <span>-{{ number_format(Session::get('shipping_discount_amount')).' vnd' }}</span></li>
                @endif
                @if(Session::has('discount_amount'))
                <li>Mã giảm giá <span>-{{ number_format(Session::get('discount_amount')).' vnd' }}</span></li>
                @else
                <li>Mã giảm giá <span>0 vnd</span></li>
                @endif
                <li>Thành Tiền <span>{{ number_format($total).' vnd' }}</span></li>
            </ul>
        </div>

    </div>
</section>

@endsection
