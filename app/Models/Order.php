<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'tbl_order'; // Tên bảng là tbl_order
    protected $primaryKey = 'order_id'; // Khóa chính là order_id

    // Quan hệ với bảng Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id'); // customer_id là khóa ngoại trong bảng tbl_order
    }
    public function shipping()
    {
        return $this->belongsTo(Shipping::class, 'shipping_id'); // Đảm bảo rằng bạn đang sử dụng tên khóa ngoại đúng
    }
    // Quan hệ với bảng OrderDetails
    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class, 'order_id'); // order_id là khóa ngoại trong bảng tbl_order_details
    }
}
