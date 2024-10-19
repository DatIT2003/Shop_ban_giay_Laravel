@extends('welcome')
@section('content')

<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{URL::to('/')}}">Trang Chủ</a></li>
                <li class="active">Thanh Toán Thành Công</li>
            </ol>
        </div>

        <div class="review-payment">
            <h2>Cảm ơn bạn đã đặt hàng!</h2>
            <p>Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.</p>
        </div>
    </div>
</section>

@endsection
