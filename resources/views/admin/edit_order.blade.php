@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Chỉnh sửa tình trạng đơn hàng
        </div>
        <div class="table-responsive">
            <?php
                use Illuminate\Support\Facades\Session;

                $message = Session::get("message");
                if($message) {
                    echo '<span class="text-alert">'.$message.'</span>';
                    Session::put("message",null);
                }
            ?>
            <form action="{{ URL::to('/update-order-status/'.$order->order_id) }}" method="post">
                @csrf
                <div class="form-group">
                    <label>Tình trạng:</label>
                    <select name="order_status" class="form-control">
                        <option value="Đang chờ xử lý" {{ $order->order_status == 'Đang chờ xử lý' ? 'selected' : '' }}>Đang chờ xử lý</option>
                        <option value="Đang giao hàng" {{ $order->order_status == 'Đang giao hàng' ? 'selected' : '' }}>Đang giao hàng</option>
                        <option value="Đã giao hàng" {{ $order->order_status == 'Đã giao hàng' ? 'selected' : '' }}>Đã giao hàng</option>
                        <option value="Đã hủy" {{ $order->order_status == 'Đã hủy' ? 'selected' : '' }}>Đã hủy</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật tình trạng</button>
            </form>
        </div>
    </div>
</div>
@endsection
