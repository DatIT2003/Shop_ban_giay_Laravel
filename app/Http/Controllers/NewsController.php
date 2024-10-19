<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;


class NewsController extends Controller
{
    //
    public function tintuc() {
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('status','0')->orderBy('id','desc')->get();

        return view('pages.tintuc.tintuc')
        ->with('category',$cate_product)
        ->with('brand',$brand_product);
    }
}
