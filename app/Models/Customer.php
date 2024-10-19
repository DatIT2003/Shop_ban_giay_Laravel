<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'tbl_customers'; // Tên bảng là tbl_customer
    protected $primaryKey = 'customer_id'; // Khóa chính là customer_id

    // Nếu cần, bạn có thể thêm các quan hệ khác ở đây
}
