<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'tbl_product'; // Tên bảng là tbl_product
    protected $primaryKey = 'product_id'; // Khóa chính là product_id
}
