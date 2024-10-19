<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductQuantityToTblProductTable extends Migration
{
    public function up()
    {
        Schema::table('tbl_product', function (Blueprint $table) {
            $table->integer('product_quantity')->default(0); // Thêm cột với kiểu dữ liệu integer và giá trị mặc định là 0
        });
    }

    public function down()
    {
        Schema::table('tbl_product', function (Blueprint $table) {
            $table->dropColumn('product_quantity'); // Xóa cột nếu rollback
        });
    }
}

