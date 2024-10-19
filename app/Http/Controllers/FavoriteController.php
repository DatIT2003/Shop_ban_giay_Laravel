<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Session;

class FavoriteController extends Controller
{
    //

    public function addFavorite($product_id)
    {
        $customer_id = Session::get('customer_id');
        if ($customer_id) {
            DB::table('page_likes')->insert([
                'customer_id' => $customer_id,
                'product_id' => $product_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('message', 'Đã thêm vào yêu thích');
        } else {
            return redirect('/login-checkout')->with('message', 'Vui lòng đăng nhập để thêm vào yêu thích');
        }
    }

    public function showFavorites()
    {
        $customer_id = Session::get('customer_id');
        if ($customer_id) {
            $favorites = DB::table('page_likes')->where('customer_id', $customer_id)->get();
            $products = [];

            foreach ($favorites as $favorite) {
                $product = DB::table('tbl_product')->where('product_id', $favorite->product_id)->first();
                if ($product) {
                    $products[] = $product;
                }
            }


            $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderBy('category_id','desc')->get();
            $brand_product = DB::table('tbl_brand')->where('status','0')->orderBy('id','desc')->get();

            return view('pages.pageLike.favorites')
            ->with('category',$cate_product)
            ->with('brand',$brand_product)
            ->with('products',$products);
        } else {
            return redirect('/login-checkout')->with('message', 'Vui lòng đăng nhập để xem yêu thích');
        }
    }

    public function removeFavorite($product_id)
    {
        $customer_id = Session::get('customer_id');
        if ($customer_id) {
            DB::table('page_likes')
                ->where('customer_id', $customer_id)
                ->where('product_id', $product_id)
                ->delete();

            return redirect()->back()->with('message', 'Đã xóa sản phẩm khỏi yêu thích');
        } else {
            return redirect('/login-checkout')->with('message', 'Vui lòng đăng nhập để xóa sản phẩm khỏi yêu thích');
        }
    }
}
