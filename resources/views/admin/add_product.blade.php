@extends('admin_layout')
@section('admin_content')


<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm Sản Phẩm
                        </header>
                        <div class="panel-body">
                            
                        <?php
                            // Thêm Sản Phẩm
                                use Illuminate\Support\Facades\Session;

                                    $message = Session::get("message");
                                    if($message) {
                                        echo '<span class="text-alert">'.$message.'</span>';
                                        Session::put("message",null);
                                    }
                        ?>
                            <div class="position-center">                                                                                    
                                <form role="form" action="{{URL::to('/save-product')}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên Sản Phẩm</label>
                                    <input type="text" name = "product_name" class="form-control" id="exampleInputEmail1" placeholder="Tên Sản Phẩm">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giá Sản Phẩm</label>
                                    <input type="text" name = "product_price" class="form-control" id="exampleInputEmail1" placeholder="Giá Sản Phẩm">
                                </div>
                                <div class="form-group">
                                    <label for="product_quantity">Số lượng sản phẩm</label>
                                    <input type="number" name="product_quantity" class="form-control" id="product_quantity" placeholder="Nhập số lượng sản phẩm" required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình Ảnh Sản Phẩm</label>
                                    <input type="file" name = "product_image" class="form-control" id="exampleInputEmail1" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô Tả Sản Phẩm</label>
                                    <textarea style="resize:none" rows="none" class="form-control" name="product_desc" id="ckeditor1" placeholder="Mô Tả Sản Phẩm"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nội Dung Sản Phẩm</label>
                                    <textarea style="resize:none" rows="none" class="form-control" name="product_content" id="ckeditor" placeholder="Nội Dung Sản Phẩm"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Danh Mục Sản Phẩm</label>
                                    <select name="product_cate" class="form-control input-sm m-bot15">
                                        @foreach ($cate_product as $key =>$cate )
                                        
                                        <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>

                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Thương Hiệu Sản Phẩm</label>
                                    <select name="product_brand" class="form-control input-sm m-bot15">
                                       
                                        @foreach ($brand_product as $key =>$brand )
                                            
                                            <option value="{{$brand->id}}">{{$brand->name}}</option>

                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hiển Thị Sản Phẩm</label>
                                    <select name="product_status" class="form-control input-sm m-bot15">
                                        <option value="0">Ẩn</option>
                                        <option value="1">Hiển thị</option>
                                    </select>
                                </div>
                            
                                <button type="submit" name="add__product" class="btn btn-info">Thêm Sản Phẩm</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>

@endsection