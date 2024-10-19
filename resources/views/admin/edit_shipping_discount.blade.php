@extends('admin_layout')
@section('admin_content')

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Cập Nhật Mã Giảm Giá Phí Ship
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
                    @if($edit_discount_code)
                    <form role="form" action="{{ URL::to('/update-shipping-discount/'.$edit_discount_code->id) }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="discountCodeName">Tên Mã Giảm Giá Phí Ship</label>
                            <input type="text" name="discount_code_name" class="form-control" id="discountCodeName" value="{{ $edit_discount_code->name }}">
                        </div>
                        <div class="form-group">
                            <label for="discountCode">Mã Giảm Giá Phí Ship</label>
                            <input type="text" name="discount_code" class="form-control" id="discountCode" value="{{ $edit_discount_code->code }}">
                        </div>
                        <div class="form-group">
                            <label for="discountAmount">Số Tiền Giảm</label>
                            <input type="number" name="discount_amount" class="form-control" id="discountAmount" value="{{ $edit_discount_code->discount_amount }}">
                        </div>
                        <div class="form-group">
                            <label for="discountType">Loại Giảm Giá</label>
                            <select name="discount_type" class="form-control input-sm m-bot15">
                                <option value="fixed" {{ $edit_discount_code->discount_type == 'fixed' ? 'selected' : '' }}>Cố Định</option>
                                <option value="percent" {{ $edit_discount_code->discount_type == 'percent' ? 'selected' : '' }}>Phần Trăm</option>
                            </select>
                        </div>
                        <button type="submit" name="update_discount_code" class="btn btn-info">Cập Nhật Mã Giảm Giá</button>
                    </form>
                    @else
                    <p>Không tìm thấy mã giảm giá.</p>
                    @endif
                </div>
            </div>
        </section>
    </div>
</div>

@endsection
