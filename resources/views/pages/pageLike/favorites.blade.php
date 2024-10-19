@extends('welcome')
@section('content')
<div class="features_items">
    <h2 class="title text-center">Sản Phẩm Bạn Đã Yêu Thích</h2>
    @if(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    @foreach ($products as $product)
        <a href="{{ URL::to('/chi-tiet-san-pham/'.$product->product_id) }}">
            <div class="col-sm-4">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <img src="{{ URL::to('public/upload/product/'.$product->product_image) }}" alt="" style="height: auto; " />
                            <h2>{{ $product->product_price . ' VND' }}</h2>
                            <p>{{ $product->product_name }}</p>
                            <a href="{{ URL::to('/chi-tiet-san-pham/'.$product->product_id) }}" class="btn btn-default add-to-cart" >Chi Tiết Sản Phẩm</a>
                            <form action="{{ route('remove.favorite', ['id' => $product->product_id]) }}" method="POST" style="display:inline;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn" style="background: #FE980F; color: #fff; border: 1px solid #FE980F; border-radius: 0; display: inline-block; font-size: 12px; margin-bottom: 25px; text-transform: uppercase; padding: 10px 15px; transition: all 0.4s ease 0s;">
                                    <i class="fa fa-trash"></i> Xóa
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    @endforeach
</div>
@endsection
