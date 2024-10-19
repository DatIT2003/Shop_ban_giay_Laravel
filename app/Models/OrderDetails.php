<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    protected $table = 'tbl_order_details'; // Tên bảng là tbl_order_details
    protected $primaryKey = 'order_details_id'; // Khóa chính là order_details_id

    // Quan hệ với bảng Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id'); // product_id là khóa ngoại trong bảng tbl_order_details
    }
}
