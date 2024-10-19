
@extends('welcome')
@section('content')


<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Kết Quả Tìm Kiếm</h2>
						@foreach ($search_product as $key => $products)
						
						<a href="{{URL::to('/chi-tiet-san-pham/'.$products->product_id)}}">
							<div class="col-sm-4">
								<div class="product-image-wrapper">

									<div class="single-products">
											<div class="productinfo text-center">
												<img src="{{URL::to('public/upload/product/'.$products->product_image)}}" alt="" />
												<h2>{{ $products->product_price . ' VND' }}</h2>
												<p>{{$products->product_name}}</p>
                                                <p>Thương hiệu: {{$products->name}}</p>
                                                <p>Danh mục: {{$products->category_name}}</p>
												<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm Vào Giỏ Hàng</a>
											</div>
											
									</div>

									<div class="choose">
										<ul class="nav nav-pills nav-justified">
											<li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích</a></li>
											<li><a href="#"><i class="fa fa-plus-square"></i>so Sánh</a></li>
										</ul>
									</div>
								</div>
												
							</div>
						</a>
						@endforeach
					



</div><!--/recommended_items-->                    





@endsection