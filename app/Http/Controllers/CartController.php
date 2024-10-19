<?php

namespace App\Http\Controllers;

use App\Models\DiscountCode;
use App\Models\ShippingDiscountCode;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class Cartcontroller extends Controller
{
    //
    public function save_cart(Request $req) {
        $productId = $req->productid_hidden;
        $quantity = $req->qty;
    
        // Lấy thông tin sản phẩm từ cơ sở dữ liệu
        $product_info = DB::table('tbl_product')->where('product_id', $productId)->first();
    
        // Kiểm tra xem sản phẩm có tồn tại không
        if (!$product_info) {
            return Redirect::to('/show-cart')->with('error', 'Không tìm thấy sản phẩm.');
        }
    
        // Kiểm tra số lượng sản phẩm còn trong kho
        if ($product_info->product_quantity <= 0) {
            return Redirect::to('/show-cart')->with('error', 'Sản phẩm đã hết hàng.');
        }
    
        // Kiểm tra số lượng yêu cầu có vượt quá số lượng trong kho không
        if ($quantity > $product_info->product_quantity) {
            return Redirect::to('/show-cart')->with('error', 'Số lượng sản phẩm trong kho không đủ.');
        }
    
        // Loại bỏ dấu phẩy khỏi giá trị product_price
        $price = str_replace(',', '', $product_info->product_price);
    
        // Kiểm tra xem giá có hợp lệ không
        if (!is_numeric($price) || $price <= 0) {
            return Redirect::to('/show-cart')->with('error', 'Giá sản phẩm không hợp lệ.');
        }
    
        // Chuẩn bị dữ liệu cho giỏ hàng
        $data['id'] = $product_info->product_id;
        $data['qty'] = $quantity;
        $data['name'] = $product_info->product_name;
        $data['price'] = $price;
        $data['options']['image'] = $product_info->product_image;
        $data['weight'] = $product_info->weight ?? 0;  // Nếu không có giá trị weight, đặt mặc định là 0.
    
        // Thêm sản phẩm vào giỏ hàng và thiết lập thuế suất 10%
        Cart::add($data)->setTaxRate(10);
    
        // Trừ số lượng sản phẩm trong kho
        DB::table('tbl_product')
            ->where('product_id', $productId)
            ->update([
                'product_quantity' => $product_info->product_quantity - $quantity
            ]);
    
        // Chuyển hướng đến trang hiển thị giỏ hàng với thông báo thành công
        return Redirect::to('/show-cart')->with('message', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }
    

    public function show_cart()
    {
        // Xóa các session liên quan đến giảm giá và phí ship nếu cần thiết
        // Đảm bảo rằng session chỉ xóa khi bắt đầu một phiên mua hàng mới
        if (!Session::has('cart_visited')) {
            Session::forget('discount_amount');
            Session::forget('shipping_discount_amount');
            Session::forget('discount_code');
            Session::forget('shipping_discount_code');
            Session::put('cart_visited', true);
        }

        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('status', '0')->orderBy('id', 'desc')->get();

        $shipping_fee = 25000;

        return view('pages.cart.show_cart')->with('category', $cate_product)->with('brand', $brand_product)->with('shipping_fee', $shipping_fee);
    }


    public function delete_to_cart($rowId){
        Cart::update($rowId,0); // update dựa vào rowId và set giá trị bằng 0
        
        return Redirect::to('/show-cart');
    }

    public function update_cart_quantity(Request $req) {
        $rowId = $req->rowId_cart;
        $qty = $req->cart_quantity;
    
        // Lấy thông tin sản phẩm từ giỏ hàng
        $cartItem = Cart::get($rowId);
    
        // Lấy thông tin sản phẩm từ cơ sở dữ liệu
        $product_info = DB::table('tbl_product')->where('product_id', $cartItem->id)->first();
    
        // Kiểm tra xem sản phẩm có tồn tại không
        if (!$product_info) {
            return Redirect::to('/show-cart')->with('error', 'Không tìm thấy sản phẩm.');
        }
    
        // Kiểm tra số lượng yêu cầu có vượt quá số lượng trong kho không
        if ($qty > $product_info->product_quantity) {
            return Redirect::to('/show-cart')->with('error', 'Số lượng sản phẩm trong kho không đủ.');
        }
    
        // Cập nhật số lượng trong giỏ hàng
        Cart::update($rowId, $qty);
    
        return Redirect::to('/show-cart');
    }
    

    public function applyDiscount(Request $request)
{
    $discountCode = DiscountCode::where('code', $request->discount_code)->first();

    if ($discountCode) {
        if ($discountCode->discount_type == 'fixed') {
            $discountAmount = $discountCode->discount_amount;
        } elseif ($discountCode->discount_type == 'percent') {
            $total = str_replace(',', '', Cart::total(0, ',', ''));
            $discountAmount = ($discountCode->discount_amount / 100) * $total;
        }

        Session::put('discount_amount', $discountAmount);
        Session::put('discount_code', $request->discount_code); // Save discount code in session
        return Redirect::to('/show-cart')->with('success', 'Mã giảm giá đã được áp dụng');
    } else {
        return Redirect::to('/show-cart')->with('error', 'Mã giảm giá không hợp lệ');
    }
}

public function applyShippingDiscount(Request $request)
{
    $shippingDiscountCode = ShippingDiscountCode::where('code', $request->shipping_discount_code)->first();
    $shipping_fee = 25000;
    if ($shippingDiscountCode) {
        if ($shippingDiscountCode->discount_type == 'fixed') {
            $shippingDiscountAmount = $shippingDiscountCode->discount_amount;
        } elseif ($shippingDiscountCode->discount_type == 'percent') {
            $shippingDiscountAmount = ($shippingDiscountCode->discount_amount / 100) * $shipping_fee;
        }

        Session::put('shipping_discount_amount', $shippingDiscountAmount);
        Session::put('shipping_discount_code', $request->shipping_discount_code); // Save shipping discount code in session
        return Redirect::to('/show-cart')->with('success', 'Mã giảm phí ship đã được áp dụng');
    } else {
        return Redirect::to('/show-cart')->with('error', 'Mã giảm phí ship không hợp lệ');
    }
}
}
