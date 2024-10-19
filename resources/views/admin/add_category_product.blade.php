@extends('admin_layout')
@section('admin_content')


<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm Danh Mục Sản Phẩm
                        </header>
                        <div class="panel-body">
                            
                        <?php
                            // Thêm danh mục
                                use Illuminate\Support\Facades\Session;

                                    $message = Session::get("message");
                                    if($message) {
                                        echo '<span class="text-alert">'.$message.'</span>';
                                        Session::put("message",null);
                                    }
                        ?>
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/save-category-product')}}" method="post">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên Danh Mục</label>
                                    <input type="text" name = "category_product_name" class="form-control" id="exampleInputEmail1" placeholder="Tên Danh Mục">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô Tả Danh Mục</label>
                                    <textarea style="resize:none" rows="none" class="form-control" name="category_product_desc" id="exampleInputPassword1" placeholder="Mô Tả Danh Mục"></textarea>
                                </div>
                                <div class="form-group">
                                <label for="exampleInputEmail1">Hiển Thị Danh Mục Sản Phẩm</label>
                                    <select name="category_product_status" class="form-control input-sm m-bot15">
                                        <option value="0">Ẩn</option>
                                        <option value="1">Hiển thị</option>
                                    </select>
                                </div>
                            
                                <button type="submit" name="add_category_product" class="btn btn-info">Thêm Danh Mục</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>

@endsection