<?php 

namespace App\Http\Controllers;
use App\Models\Order; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function editOrder($id)
    {
        // Truy vấn trực tiếp bảng tbl_order
        $order = DB::table('tbl_order')->where('order_id', $id)->first();

        // Kiểm tra nếu đơn hàng không tồn tại
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found');
        }

        // Trả về view và truyền dữ liệu đơn hàng
        return view('admin.edit_order', compact('order'));
    }

    public function trackOrder(Request $request)
    {
        $customer_id = Session::get('customer_id');
        if (!$customer_id) {
            return redirect('/login')->with('message', 'Vui lòng đăng nhập để theo dõi đơn hàng');
        }
    
        // Lấy danh sách các đơn hàng
        $orders = DB::table('tbl_order')
            ->where('customer_id', $customer_id)
            ->join('tbl_shipping', 'tbl_order.shipping_id', '=', 'tbl_shipping.shipping_id')
            ->select('tbl_order.*', 'tbl_shipping.shipping_address')
            ->orderBy('tbl_order.created_at', 'desc')
            ->get();
    
        // Lấy chi tiết cho từng đơn hàng
        foreach ($orders as $order) {
            $order->order_total = floatval($order->order_total);
            $order->shipping_fee = 25000; // Gán giá trị mặc định cho shipping_fee
    
            $order->items = DB::table('tbl_order_details')
                ->where('order_id', $order->order_id)
                ->select('product_name', 'product_price', 'product_sales_quatity')
                ->get();
    
            foreach ($order->items as $item) {
                $item->product_price = floatval($item->product_price);
            }
        }
    
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('status','0')->orderBy('id','desc')->get();
    
        return view('pages.order.track_order')
            ->with('orders', $orders)
            ->with('category',$cate_product)
            ->with('brand',$brand_product);
    }
    public function viewOrder($orderId)
    {
        // Lấy thông tin chi tiết của đơn hàng dựa trên order_id
        $order = Order::with(['customer','shipping', 'orderDetails.product'])->find($orderId);
    
        // Kiểm tra xem đơn hàng có tồn tại không
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }
    
        // Trả về view để hiển thị chi tiết đơn hàng
        return view('admin.view_order', compact('order'));
    }
    
   
    


}
