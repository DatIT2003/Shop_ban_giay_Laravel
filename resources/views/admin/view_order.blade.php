@extends('admin_layout')
@section('admin_content')

<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Chi tiết đơn hàng #{{ $order->order_id }}
        </div>
        
        <div class="table-responsive">
            <h2>Thông tin khách hàng</h2>
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $order->customer->customer_name }}</td>
                        <td>{{ $order->customer->customer_email }}</td>
                        <td>{{ $order->customer->customer_phone }}</td>
                    </tr>
                </tbody>
            </table>

            <h2>Thông tin vận chuyển</h2>
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th>Tên người vận chuyển</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $order->shipping->shipping_name }}</td>
                        <td>{{ $order->shipping->shipping_address }}</td>
                        <td>{{ $order->shipping->shipping_phone }}</td>
                    </tr>
                </tbody>
            </table>

            <h2>Thông tin sản phẩm</h2>
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalAmount = 0; // Initialize total amount variable
                    @endphp

                    @foreach($order->orderDetails as $detail)
                        @php
                            $productTotal = (int)$detail->product_sales_quatity * (int)str_replace(',', '', $detail->product->product_price);
                            $totalAmount += $productTotal; // Add product total to the total amount
                        @endphp
                        <tr>
                            <td>{{ $detail->product->product_name }}</td>
                            <td>{{ $detail->product_sales_quatity }}</td> <!-- Số lượng -->
                            <td>{{ $detail->product->product_price }} VND</td>
                            <td>{{ number_format($productTotal, 0, ',', '.') }} VND</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-right">
                <strong>Tổng tất cả: {{ number_format($totalAmount, 0, ',', '.') }} VND</strong>
            </div>
        </div>
    </div>
</div>

@endsection
