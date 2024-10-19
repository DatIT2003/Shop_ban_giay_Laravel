@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Quản lý đơn hàng
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th>Tên khách hàng</th>
                        <th>Email</th>
                        <th>Số Điện Thoại</th>
                        <th>Tổng tiền</th>
                        <th>Ngày đặt</th>
                        <th>Tình trạng</th>
                        <th style="width:30px;"></th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($all_order as $order)
                    <tr>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ $order->customer_email }}</td>
                        <td>{{ $order->customer_phone }}</td>
                        <td>{{ number_format((float) $order->order_total) }} vnd</td>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->order_status }}</td>
                        <td>
                            <a href="{{ URL::to('/edit-order/'.$order->order_id) }}" class="active styling-edit" ui-toggle-class="">
                                <i class="fa fa-pencil-square-o text-success text-active"></i>
                            </a>
                        </td>
                        <td>
                        <a href="{{ route('admin.view_order', $order->order_id) }}" class="active styling-edit" ui-toggle-class="">
                            <i class="fa fa-eye text-primary text-active"></i> Xem chi tiết
                        </a>
                    </td>

                            <!-- <td> -->
                            <!-- <a href="{{ URL::to('/view-order/'.$order->order_id) }}" class="active styling-edit" ui-toggle-class="">
                                <i class="fa fa-eye text-primary text-active"></i> Xem chi tiết
                            </a>
                        </td> -->

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection