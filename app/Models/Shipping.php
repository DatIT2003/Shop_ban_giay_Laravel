<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $table = 'tbl_shipping'; // Đảm bảo rằng tên bảng là đúng

    protected $primaryKey = 'shipping_id'; // Chỉ định khóa chính nếu không phải là 'id'
    
    // Nếu có, thêm các mối quan hệ khác
}
