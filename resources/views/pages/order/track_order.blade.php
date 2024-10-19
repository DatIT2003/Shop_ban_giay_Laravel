@extends('welcome')
@section('content')

<div class="container" style="max-width: 1200px; margin: auto; padding: 20px;">
    <h2 class="title text-center" style="margin-bottom: 30px;">Theo Dõi Đơn Hàng</h2>

    @foreach ($orders as $order)
    <div class="card" style="border: 1px solid #ddd; margin-bottom: 20px;">
        <div class="card-header" style="background-color: #FFA500; color: white; padding: 10px;">
            <h3>Mã Đơn Hàng: {{ $order->order_id }}</h3>
        </div>
        <div class="card-body" style="padding: 15px;">
            <p><strong>Ngày đặt:</strong> {{ $order->created_at }}</p>
            <p><strong>Tình trạng:</strong> {{ $order->order_status }}</p>
            <p><strong>Địa chỉ giao hàng:</strong> {{ $order->shipping_address }}</p>

            <h4 style="margin-top: 20px;">Chi tiết sản phẩm</h4>
            <div class="table-responsive" style="margin-top: 10px;">
                <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #f8f9fa;">
                            <th style="padding: 10px; border: 1px solid #dee2e6;">Tên sản phẩm</th>
                            <th style="padding: 10px; border: 1px solid #dee2e6;">Giá</th>
                            <th style="padding: 10px; border: 1px solid #dee2e6;">Số lượng</th>
                            <th style="padding: 10px; border: 1px solid #dee2e6;">Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                        <tr>
                            <td style="padding: 10px; border: 1px solid #dee2e6;">{{ $item->product_name }}</td>
                            <td style="padding: 10px; border: 1px solid #dee2e6;">{{ number_format($item->product_price, 0, ',', '.') }} vnd</td>
                            <td style="padding: 10px; border: 1px solid #dee2e6;">{{ $item->product_sales_quatity }}</td>
                            <td style="padding: 10px; border: 1px solid #dee2e6;">{{ number_format($item->product_price * $item->product_sales_quatity, 0, ',', '.') }} vnd</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="order-total" style="margin-top: 15px; font-weight: bold;">
                <p><strong>Tổng tiền phải thanh toán (Đã Bao Gồm Thuế và Phí Ship):</strong> {{ number_format($order->order_total, 0, ',', '.') }} vnd</p>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection
