<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use App\Mail\PasswordResetMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class Checkoutcontroller extends Controller
{
    //

    public function CheckLogin() {
        // kiểm tra để đăng nhập vào tất cả các trang

        $admin_id = Session::get('admin_id');
        if($admin_id) {
            return redirect::to('Dashboard');
        }else{
            return redirect::to('Admin')->send();

        }
    }

    public function view_order($order_Id) {
        $this->CheckLogin();


        $order_by_id = DB::table('tbl_order')
        ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
        ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
        ->join('tbl_order_details','tbl_order.order_id','=','tbl_order_details.order_id')
        ->select('tbl_order.*','tbl_customers.*','tbl_shipping.*','tbl_order_details.*')
        ->first();
        $manager_order_by_id = view('admin.view_order')->with('order_by_id',$order_by_id);

        return view("admin_layout")->with('admin.view_order',$manager_order_by_id);

    }

   public function login_checkout() {
    $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderBy('category_id','desc')->get();
    $brand_product = DB::table('tbl_brand')->where('status','0')->orderBy('id','desc')->get();

    return view("pages.checkout.login_checkout")->with('category',$cate_product)->with('brand',$brand_product);
   }


   public function add_customer(Request $req) {
    // Check if the email or phone number already exists in the database
    $existingCustomer = DB::table('tbl_customers')
        ->where('customer_email', $req->customer_email)
        ->orWhere('customer_phone', $req->customer_phone)
        ->first();

    if ($existingCustomer) {
        // If the customer already exists, return an error message
        Session::put('error', 'Email hoặc số điện thoại đã tồn tại. Vui lòng đăng nhập hoặc sử dụng thông tin khác.');
        return Redirect::to('/login-checkout');
    }

    // Proceed with registration if no duplicates found
    $data = array();
    $data['customer_name'] = $req->customer_name;
    $data['customer_email'] = $req->customer_email;
    $data['customer_password'] = md5($req->customer_password); // Consider using bcrypt instead of md5 for security
    $data['customer_phone'] = $req->customer_phone;

    // Insert the new customer and set session variables
    $customer_id = DB::table('tbl_customers')->insertGetId($data);
    Session::put('customer_id', $customer_id);
    Session::put('customer_name', $req->customer_name);

    return Redirect::to('/checkout');
}


   public function checkout() {


    $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderBy('category_id','desc')->get();
    $brand_product = DB::table('tbl_brand')->where('status','0')->orderBy('id','desc')->get();

    return view("pages.checkout.show_checkout")->with('category',$cate_product)->with('brand',$brand_product);

   }

   public function review_order()
   {
       $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderBy('category_id', 'desc')->get();
       $brand_product = DB::table('tbl_brand')->where('status', '0')->orderBy('id', 'desc')->get();
       $shipping_id = Session::get('shipping_id');
       $shipping_info = DB::table('tbl_shipping')->where('shipping_id', $shipping_id)->first();
   
       $content = Cart::content();
       $shipping_fee = 25000;
   
       return view('pages.checkout.review_order')
           ->with('category', $cate_product)
           ->with('brand', $brand_product)
           ->with('shipping_info', $shipping_info)
           ->with('content', $content)
           ->with('shipping_fee', $shipping_fee);
   }

public function update_shipping_info(Request $req)
{
    $shipping_id = Session::get('shipping_id');

    $data = array();
    $data['shipping_name'] = $req->shipping_name;
    $data['shipping_phone'] = $req->shipping_phone;
    $data['shipping_email'] = $req->shipping_email;
    $data['shipping_notes'] = $req->shipping_notes;
    $data['shipping_address'] = $req->shipping_address;

    DB::table('tbl_shipping')->where('shipping_id', $shipping_id)->update($data);

    return Redirect::to('/payment');
}

   

   public function save_checkout_customer(Request $request) {
    $validatedData = $request->validate([
        'shipping_email' => 'required|email|max:255',
        'shipping_name' => 'required|string|max:255',
        'shipping_address' => 'required|string|max:255',
        'shipping_phone' => 'required|digits_between:10,11',
    ]);

    // If validation passes, process the shipping information
    $data = array();
    $data['shipping_email'] = $request->shipping_email;
    $data['shipping_name'] = $request->shipping_name;
    $data['shipping_address'] = $request->shipping_address;
    $data['shipping_phone'] = $request->shipping_phone;
    $data['shipping_notes'] = $request->shipping_notes;

    // Insert shipping information into the database
    $shipping_id = DB::table('tbl_shipping')->insertGetId($data);

    // Store shipping_id in session
    Session::put('shipping_id', $shipping_id);

    // Redirect to the payment page
    return redirect('/payment')->with('message', 'Thông tin giao hàng đã được lưu.');
}

   public function payment() {
    $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderBy('category_id','desc')->get();
    $brand_product = DB::table('tbl_brand')->where('status','0')->orderBy('id','desc')->get();

    return view("pages.checkout.payment")->with('category',$cate_product)->with('brand',$brand_product);

   }
   


   
   public function order_place(Request $req)
{
    $shipping_fee = 25000;

    // insert payment method
    $data = array();
    $data['payment_method'] = $req->payment_option;
    $data['payment_status'] = 'Đang chờ xử lý';

    $payment_id = DB::table('tbl_payment')->insertGetId($data);

    // insert order
    $order_data = array();
    $order_data['customer_id'] = Session::get('customer_id');
    $order_data['shipping_id'] = Session::get('shipping_id');
    $order_data['payment_id'] = $payment_id;

    // Tính tổng số tiền
    $total = str_replace(',', '', Cart::total(0, ',', '')) + $shipping_fee;
    if (Session::has('discount_amount')) {
        $total -= Session::get('discount_amount');
    }
    if (Session::has('shipping_discount_amount')) {
        $total -= Session::get('shipping_discount_amount');
    }

    $order_data['order_total'] = $total;
    $order_data['order_status'] = 'Đang chờ xử lý';

    $order_id = DB::table('tbl_order')->insertGetId($order_data);

    // insert order detail
    $content = Cart::content();
    foreach ($content as $v_content) {
        $order_d_data = array();
        $order_d_data['order_id'] = $order_id;
        $order_d_data['product_id'] = $v_content->id;
        $order_d_data['product_name'] = $v_content->name;
        $order_d_data['product_price'] = $v_content->price;
        $order_d_data['product_sales_quatity'] = $v_content->qty;

        DB::table('tbl_order_details')->insert($order_d_data);
    }


    // Gửi email cho khách hàng
    $shipping_id = Session::get('shipping_id');
    $shipping = DB::table('tbl_shipping')->where('shipping_id', $shipping_id)->first();
    Mail::to($shipping->shipping_email)->send(new OrderMail($order_data, $shipping_fee, $total));

    // Điều hướng đến trang cảm ơn
    if ($data['payment_method'] == 1) {
        echo 'thanh toán bằng thẻ ATM';
    } elseif ($data['payment_method'] == 2) {
        // Xóa giỏ hàng và xóa các session khác như là mã giảm và mã phí ship
        Cart::destroy();
        Session::forget('discount_amount');
        Session::forget('shipping_discount_amount');
        Session::forget('discount_code');
        Session::forget('shipping_discount_code');
        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('status', '0')->orderBy('id', 'desc')->get();

        return view('pages.checkout.handcash')->with('category', $cate_product)->with('brand', $brand_product);
    } else {
        echo 'Thẻ ghi nợ';
    }
}



   public function logout_checkout() {
    Session::flush();
    return Redirect::to('/login-checkout');

   }

   public function login_customer(Request $req) {
    $email = $req->email_account;
    $password = md5($req->password_account);

    $result = DB::table('tbl_customers')
    ->where('customer_email',$email)
    ->where('customer_password',$password)
    ->first();

    if($result) {
        Session::put('customer_id',$result->customer_id);
        Session::flash('message', 'Đăng nhập thành công!');
        return Redirect::to('/checkout');

    }else{
        Session::flash('error', 'Đăng nhập không thành công. Vui lòng kiểm tra lại email và mật khẩu.');
        return Redirect::to('/login-checkout');

    }

   }


   public function sendPasswordResetLink(Request $request) {
    $email = $request->input('email');

    // Kiểm tra email có tồn tại không
    $customer = DB::table('tbl_customers')->where('customer_email', $email)->first();

    if ($customer) {
        // Gửi email chứa mật khẩu đã mã hóa bằng MD5
        Mail::to($email)->send(new PasswordResetMail($customer->customer_password));

        return back()->with('message', 'Email chứa mật khẩu đã được gửi!');
    } else {
        return back()->with('error', 'Email không tồn tại!');
    }
}

   public function manage_order() {
        $this->CheckLogin();


        $all_order = DB::table('tbl_order')
        ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
        ->select('tbl_order.*','tbl_customers.*')
        ->orderBy('tbl_order.order_id','desc')->get();
        $manager_order = view('admin.manage_order')->with('all_order',$all_order);

        return view("admin_layout")->with('admin.manager_order',$manager_order);
   }


   public function edit_order($order_id)
{
    $this->CheckLogin();

    $order = DB::table('tbl_order')
        ->join('tbl_customers', 'tbl_order.customer_id', '=', 'tbl_customers.customer_id')
        ->join('tbl_shipping', 'tbl_order.shipping_id', '=', 'tbl_shipping.shipping_id')
        ->join('tbl_order_details', 'tbl_order.order_id', '=', 'tbl_order_details.order_id')
        ->select('tbl_order.*', 'tbl_customers.*', 'tbl_shipping.*')
        ->where('tbl_order.order_id', $order_id)
        ->first();

    $order->details = DB::table('tbl_order_details')->where('order_id', $order_id)->get();

    return view('admin.edit_order')->with('order', $order);
}

public function update_order_status(Request $request, $order_id)
{
    $this->CheckLogin();

    $shipping_fee = 25000;

    // Lấy thông tin đơn hàng hiện tại
    $order = DB::table('tbl_order')->where('order_id', $order_id)->first();
    
    // Cập nhật tình trạng đơn hàng
    DB::table('tbl_order')
        ->where('order_id', $order_id)
        ->update(['order_status' => $request->order_status]);

    // Tính tổng số tiền sau giảm giá
    $total = $order->order_total;
    if (Session::has('discount_amount')) {
        $total -= Session::get('discount_amount');
    }
    if (Session::has('shipping_discount_amount')) {
        $total -= Session::get('shipping_discount_amount');
    }
    $total_after_discount = $total;

    // Gửi email cho khách hàng về tình trạng đơn hàng
    $shipping = DB::table('tbl_shipping')->where('shipping_id', $order->shipping_id)->first();
    $order->order_status = $request->order_status;
    Mail::to($shipping->shipping_email)->send(new OrderMail($order, $shipping_fee, $total_after_discount));

    // Tạo dữ liệu cho view
    $orderDetails = DB::table('tbl_order_details')->where('order_id', $order_id)->get();
    $cartContent = collect();
    foreach ($orderDetails as $detail) {
        $cartContent->push((object)[
            'name' => $detail->product_name,
            'price' => $detail->product_price,
            'qty' => $detail->product_sales_quatity,
        ]);
    }

    return Redirect::to('/manage-order')
    ->with('message', 'Cập nhật tình trạng đơn hàng thành công')
    ->with('order', $order)
    ->with('cartContent', $cartContent)
    ->with('shipping_fee', $shipping_fee)
    ->with('total_after_discount', $total_after_discount)
    ->with('subtotal', $order->order_total - $shipping_fee - $total_after_discount)
    ->with('tax', 0) // Điều chỉnh giá trị thuế nếu cần thiết
    ->with('total', $order->order_total);;
}

}

