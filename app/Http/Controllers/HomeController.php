<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index() {

        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('status','0')->orderBy('id','desc')->get();

        // $all_product = DB::table('tbl_product')
        // ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        // ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        // ->orderBy('tbl_product.product_id','desc')->get();

        $all_product = DB::table('tbl_product')->where('product_status','0')->orderBy('product_id','desc')->get();
        $customers = DB::table('tbl_customers')->get();


        return view('pages.home')
        ->with('category',$cate_product)
        ->with('brand',$brand_product)
        ->with('all_product',$all_product)
        ->with('customers',$customers);
    }

    public function search(Request $req) {
        $keywords = $req->keywords_submit;
        
        // Lấy danh mục sản phẩm và thương hiệu
        $cate_product = DB::table('tbl_category_product')
            ->where('category_status', '0')
            ->orderBy('category_id', 'desc')
            ->get();
    
        $brand_product = DB::table('tbl_brand')
            ->where('status', '0')
            ->orderBy('id', 'desc')
            ->get();
    
        // Tìm kiếm sản phẩm dựa trên tên sản phẩm, thương hiệu hoặc giá
        $search_product = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')
            ->join('tbl_brand', 'tbl_product.brand_id', '=', 'tbl_brand.id')
            ->where('tbl_product.product_name', 'like', '%' . $keywords . '%')
            ->orWhere('tbl_brand.name', 'like', '%' . $keywords . '%') // tìm kiếm theo tên thương hiệu
            ->orWhere('tbl_product.product_price', 'like', '%' . $keywords . '%') // tìm kiếm theo giá (dạng chuỗi)
            ->select('tbl_product.*', 'tbl_category_product.category_name', 'tbl_brand.name')
            ->get();
    
        return view('pages.sanpham.search')
            ->with('category', $cate_product)
            ->with('brand', $brand_product)
            ->with('search_product', $search_product);
    }
    



    
}
