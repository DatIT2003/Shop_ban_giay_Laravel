<?php

namespace App\Http\Controllers;

use App\Models\DiscountCode;
use App\Models\ShippingDiscountCode;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
class DiscountCodeController extends Controller
{
    // mã giảm giá

    public function all_discount()
    {
        $all_discount_codes = DiscountCode::all();
        return view('admin.all_discount',compact('all_discount_codes'));
    }

    public function add_discount()
    {
        return view('admin.add_discount');
    }

    public function save_discount(Request $request)
    {
        $data = $request->all();
        $discount_code = new DiscountCode();
        $discount_code->name = $data['discount_code_name'];
        $discount_code->code = $data['discount_code'];
        $discount_code->discount_amount = $data['discount_amount'];
        $discount_code->discount_type = $data['discount_type'];
        $discount_code->save();
        
        Session::put('message', 'Thêm mã giảm giá thành công');
        return Redirect::to('/all-discount');
    }

    public function edit_discount($discount_code_id)
    {
        $edit_discount_code = DiscountCode::find($discount_code_id);
        if ($edit_discount_code) {
            return view('admin.edit_discount',compact('edit_discount_code'));
        } else {
            Session::put('message', 'Không tìm thấy mã giảm giá');
            return Redirect::to('/all-discount');
        }
    }

    public function update_discount(Request $request, $id)
    {
        $data = $request->all();
        $discount_code = DiscountCode::find($id);
        $discount_code->name = $data['discount_code_name'];
        $discount_code->code = $data['discount_code'];
        $discount_code->discount_amount = $data['discount_amount'];
        $discount_code->discount_type = $data['discount_type'];
        $discount_code->save();
        
        Session::put('message', 'Cập nhật mã giảm giá thành công');
        return Redirect::to('/all-discount');
    }

    public function delete_discount($id)
    {
        $discount_code = DiscountCode::find($id);
        $discount_code->delete();
        
        Session::put('message', 'Xóa mã giảm giá thành công');
        return Redirect::to('/all-discount');
    }


    // mã giảm giá phí ship

    public function all_shipping_discount()
    {
        $all_discount_codes = ShippingDiscountCode::all();
        return view('admin.all_shipping_discount',compact('all_discount_codes'));
    }

    public function add_shipping_discount()
    {
        return view('admin.add_shipping_discount');
    }

    public function save_shipping_discount(Request $request)
    {
        $data = $request->all();
        $discount_code = new ShippingDiscountCode();
        $discount_code->name = $data['discount_code_name'];
        $discount_code->code = $data['discount_code'];
        $discount_code->discount_amount = $data['discount_amount'];
        $discount_code->discount_type = $data['discount_type'];
        $discount_code->save();
        
        Session::put('message', 'Thêm mã giảm giá Phí Ship thành công');
        return Redirect::to('/all-shipping-discount');
    }

    public function edit_shipping_discount($discount_code_id)
    {
        $edit_discount_code = ShippingDiscountCode::find($discount_code_id);
        if ($edit_discount_code) {
            return view('admin.edit_shipping_discount',compact('edit_discount_code'));
        } else {
            Session::put('message', 'Không tìm thấy mã giảm giá Phí Ship');
            return Redirect::to('/all-shipping-discount');
        }
    }

    public function update_shipping_discount(Request $request, $id)
    {
        $data = $request->all();
        $discount_code = ShippingDiscountCode::find($id);
        $discount_code->name = $data['discount_code_name'];
        $discount_code->code = $data['discount_code'];
        $discount_code->discount_amount = $data['discount_amount'];
        $discount_code->discount_type = $data['discount_type'];
        $discount_code->save();
        
        Session::put('message', 'Cập nhật mã giảm giá Phí Ship thành công');
        return Redirect::to('/all-shipping-discount');
    }

    public function delete_shipping_discount($id)
    {
        $discount_code = ShippingDiscountCode::find($id);
        $discount_code->delete();
        
        Session::put('message', 'Xóa mã giảm giá Phí Ship thành công');
        return Redirect::to('/all-shipping-discount');
    }


    
}