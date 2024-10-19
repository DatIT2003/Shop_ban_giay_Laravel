@extends('welcome')
@section('content')

<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{URL::to('/')}}">Trang Chủ</a></li>
                <li class="active">Xem Lại Thông Tin</li>
            </ol>
        </div>

        <div class="shopper-informations">
            <h2>Giỏ Hàng Của Bạn</h2>
            <div class="row">
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
                                <p>{{$v_content->qty}}</p>
                            </td>
                            <td class="cart_total">
                                <p class="cart_total_price">
                                <?php
                                    $subtotal = $v_content->price * $v_content->qty;
                                    echo number_format($subtotal).' vnd';
                                ?>
                                </p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <section id="do_action">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        @if(Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        @if(Session::has('error'))
                            <div class="alert alert-danger">
                                {{ Session::get('error') }}
                            </div>
                        @endif
                        <div class="total_area">
                            <ul>
                                <?php
                                use Gloudemans\Shoppingcart\Facades\Cart;
                                use Illuminate\Support\Facades\Session;
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
                                <li>Thành Tiền <span>
                                    <?php
                                    
                                        $total = str_replace(',', '', Cart::total(0, ',', '')) + $shipping_fee;
                                        if (Session::has('discount_amount')) {
                                            $total -= Session::get('discount_amount');
                                        }
                                        if (Session::has('shipping_discount_amount')) {
                                            $total -= Session::get('shipping_discount_amount');
                                        }
                                        echo number_format($total).' vnd';
                                    ?>
                                </span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
                <div class="col-sm-12 clearfix">
                    <div class="bill-to">
                        <p>Thông Tin Gửi Hàng</p>
                        <div class="form-one">
                            <form action="{{URL::to('/update-shipping-info')}}" method="POST">
                                {{ csrf_field() }}
                                <input type="text" name="shipping_email" value="{{ $shipping_info->shipping_email }}" placeholder="Email">
                                <input type="text" name="shipping_name" value="{{ $shipping_info->shipping_name }}" placeholder="Họ Và Tên">
                                <input type="text" name="shipping_address" value="{{ $shipping_info->shipping_address }}" placeholder="Địa Chỉ">
                                <input type="text" name="shipping_phone" value="{{ $shipping_info->shipping_phone }}" placeholder="Số Điện thoại">
                                <textarea name="shipping_notes" placeholder="Ghi Chú Đơn Hàng Của Bạn" rows="16">{{ $shipping_info->shipping_notes }}</textarea>
                                <input type="submit" value="Gửi Lại" name="send_order" class="btn btn-primary btn-sm">
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

       

    </div>
</section>

@endsection
