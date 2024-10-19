@extends('welcome')
@section('content')

<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{URL::to('/')}}">Trang Chủ</a></li>
                <li class="active">Giỏ Hàng Của Bạn</li>
            </ol>
        </div>
        <div class="table-responsive cart_info">

            <?php
            use Gloudemans\Shoppingcart\Facades\Cart;
            use Illuminate\Support\Facades\Session;

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
                            <p>Web ID: {{$v_content->id}}</p>
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
    </div>
</section> <!--/#cart_items-->

<section id="discount_code">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h2>Mã giảm giá</h2>
                <form action="{{ URL::to('/apply-discount') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="discount_code">Nhập mã giảm giá</label>
                        <input type="text" class="form-control" id="discount_code" name="discount_code" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Áp dụng</button>
                </form>
            </div>
            <div class="col-sm-6">
                <h2>Mã giảm phí ship</h2>
                <form action="{{ URL::to('/apply-shipping-discount') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="shipping_discount_code">Nhập mã giảm phí ship</label>
                        <input type="text" class="form-control" id="shipping_discount_code" name="shipping_discount_code" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Áp dụng</button>
                </form>
            </div>
        </div>
    </div>
</section>

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
                    <?php
                        $customer_id = Session::get('customer_id');
                        $shipping_id = Session::get('shipping_id');
                        if($customer_id != Null && $shipping_id == Null) {
                    ?>
                        <a class="btn btn-default check_out" href="{{URL::to('/checkout')}}">Thanh Toán</a>
                    <?php } elseif ($customer_id != Null && $shipping_id != Null) { ?>
                        <a class="btn btn-default check_out" href="{{URL::to('/payment')}}">Thanh Toán</a>
                    <?php } else { ?>
                        <a class="btn btn-default check_out" href="{{URL::to('/login-checkout')}}">Thanh Toán</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
