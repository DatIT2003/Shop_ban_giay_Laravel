@extends('admin_layout')
@section('admin_content')

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm Mã Giảm Giá
            </header>
            <div class="panel-body">
                <?php
                    use Illuminate\Support\Facades\Session;
                    $message = Session::get('message');
                    if($message) {
                        echo '<span class="text-alert">'.$message.'</span>';
                        Session::put('message', null);
                    }
                ?>
                <div class="position-center">
                    <form role="form" action="{{ URL::to('/save-discount') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="discountCodeName">Tên Mã Giảm Giá</label>
                            <input type="text" name="discount_code_name" class="form-control" id="discountCodeName" placeholder="Tên Mã Giảm Giá">
                        </div>
                        <div class="form-group">
                            <label for="discountCode">Mã Giảm Giá</label>
                            <input type="text" name="discount_code" class="form-control" id="discountCode" placeholder="Mã Giảm Giá">
                        </div>
                        <div class="form-group">
                            <label for="discountAmount">Số Tiền Giảm</label>
                            <input type="number" name="discount_amount" class="form-control" id="discountAmount" placeholder="Số Tiền Giảm">
                        </div>
                        <div class="form-group">
                            <label for="discountType">Loại Giảm Giá</label>
                            <select name="discount_type" class="form-control input-sm m-bot15">
                                <option value="fixed">Cố Định</option>
                                <option value="percent">Phần Trăm</option>
                            </select>
                        </div>
                        <button type="submit" name="add_discount_code" class="btn btn-info">Thêm Mã Giảm Giá</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

@endsection
