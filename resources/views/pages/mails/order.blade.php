<!DOCTYPE html>
<html>
<head>
    <title>Chi tiết đơn hàng</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            width: 100px; /* Thay đổi kích thước hình ảnh nếu cần */
            height: auto; /* Đảm bảo tỷ lệ hình ảnh */
        }
    </style>
</head>
<body>
    @if(is_array($order))
    <h1>Cảm ơn bạn đã đặt hàng tại cửa hàng chúng tôi</h1>
    <p>Chi tiết đơn hàng của bạn:</p>

    <h2>Sản phẩm</h2>
    <table>
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Hình ảnh</th>
                <th>Tổng tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cartContent as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ number_format($item->price, 0, ',', '.') }} vnd</td>
                    <td>{{ $item->qty }}</td>
                    <td><img src="{{URL::to('public/upload/product/'.$item->product_image)}}" alt="" style="height: 300px;"/></td>
                    <td>{{ number_format($item->price * $item->qty, 0, ',', '.') }} vnd</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Tổng cộng</h2>
    <table>
        <tr>
            <td>Tổng tiền sản phẩm:</td>
            <td>{{ $subtotal }} vnd</td>
        </tr>
        <tr>
            <td>Thuế:</td>
            <td>{{ $tax }} vnd</td>
        </tr>
        <tr>
            <td>Phí vận chuyển:</td>
            <td>{{ number_format($shipping_fee, 0, ',', '.') }} vnd</td>
        </tr>
        @if (Session::has('discount_amount'))
        <tr>
            <td>Giảm giá:</td>
            <td>-{{ number_format(Session::get('discount_amount'), 0, ',', '.') }} vnd</td>
        </tr>
        @endif
        @if (Session::has('shipping_discount_amount'))
        <tr>
            <td>Giảm phí vận chuyển:</td>
            <td>-{{ number_format(Session::get('shipping_discount_amount'), 0, ',', '.') }} vnd</td>
        </tr>
        @endif
        <tr>
            <td><strong>Thành tiền:</strong></td>
            <td><strong>
                @php
                    $totalWithShipping = str_replace(',', '', $total) + $shipping_fee;
                    if (Session::has('discount_amount')) {
                        $totalWithShipping -= Session::get('discount_amount');
                    }
                    if (Session::has('shipping_discount_amount')) {
                        $totalWithShipping -= Session::get('shipping_discount_amount');
                    }
                    echo number_format($totalWithShipping, 0, ',', '.').' vnd';
                @endphp
            </strong></td>
        </tr>
    </table>

    <p>Tình Trạng Đơn Hàng : {{ $order['order_status'] }}</p>
    @else
        <h1>Cảm ơn bạn đã đặt hàng tại cửa hàng chúng tôi</h1>
        <h2>Tình trạng đơn hàng của bạn đã được thay đổi</h2>
        <p>Tình Trạng Đơn Hàng : {{ $order->order_status }}</p>
    @endif
</body>
</html>
