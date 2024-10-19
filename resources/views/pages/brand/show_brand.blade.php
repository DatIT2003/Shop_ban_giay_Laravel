
@extends('welcome')
@section('content')


                    <div class="features_items"><!--features_items-->

                        @foreach ($brand_name as $key => $name)
                        
						<h2 class="title text-center">{{$name->name}}</h2>
                        @endforeach


						@foreach ($brand_by_id as $key => $product)
							<a href="{{URL::to('/chi-tiet-san-pham/'.$product->product_id)}}">

								<div class="col-sm-4">
									<div class="product-image-wrapper">

										<div class="single-products">
												<div class="productinfo text-center">
													<img src="{{URL::to('public/upload/product/'.$product->product_image)}}" alt="" />
													<h2>{{ $product->product_price . ' VND' }}</h2>
													<p>{{$product->product_name}}</p>
													<a href="{{URL::to('/chi-tiet-san-pham/'.$product->product_id)}}" class="btn btn-default add-to-cart">Chi Tiết Sản Phẩm</a>
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
					</div><!--features_items-->



</div><!--/recommended_items-->                    


@endsection