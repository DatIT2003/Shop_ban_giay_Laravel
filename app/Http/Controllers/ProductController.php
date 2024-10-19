<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{

    public function CheckLogin() {
        // kiểm tra để đăng nhập vào tất cả các trang

        $admin_id = Session::get('admin_id');
        if($admin_id) {
            return redirect::to('Dashboard');
        }else{
            return redirect::to('Admin')->send();

        }
    }
    //
    public function add_product(){

        $this->CheckLogin();

        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->orderBy('id','desc')->get();
        
        return view("admin.add_product")->with('cate_product',$cate_product)->with('brand_product',$brand_product);

    }

    public function all_product(){

        $this->CheckLogin();


        $all_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.id','=','tbl_product.brand_id')
        ->orderBy('tbl_product.product_id','desc')->get();
        $manager_product = view('admin.all_product')->with('all_product',$all_product);

        return view("admin_layout")->with('admin.all_product',$manager_product);
        
    }

    public function save_product(Request $req) {

        $this->CheckLogin();

        $data = array();

        // cột trong database = name trong Dom
        $data['product_name'] = $req->product_name;
        $data['product_price'] = $req->product_price;
        $data['product_desc'] = $req->product_desc;
        $data['product_content'] = $req->product_content;
        $data['category_id'] = $req->product_cate;
        $data['brand_id'] = $req->product_brand;
        $data['product_status'] = $req->product_status;
        $data['product_quantity'] = $req->product_quantity; // Chỗ này thêm để lưu số lượng sản phẩm

        $get_image =$req->file('product_image');

        if($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/upload/product', $new_image);
            $data['product_image'] = $new_image;
            DB::table('tbl_product')->insert($data);
            Session::put('message','Thêm sản phẩm thành công');
            return redirect::to('add-product');
        }
        $data['product_image'] = '';
        DB::table('tbl_product')->insert($data);
        Session::put('message','Thêm sản phẩm thành công');
        return redirect::to('all-product');
    }

    public function unactive_product($product_id){

        $this->CheckLogin();

        DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status'=>1]);
        Session::put('message','không kích hoạt sản phẩm thành công');
        return redirect::to('all-product');

    }
    public function active_product($product_id){

        $this->CheckLogin();

        DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status'=>0]);
        Session::put('message','Kích hoạt sản phẩm thành công');
        return redirect::to('all-product');
    }

    public function edit_product($product_id){

        $this->CheckLogin();

        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->orderBy('id','desc')->get();

        $edit_product = DB::table('tbl_product')->where('product_id',$product_id)->get();
        $manager_product = view('admin.edit_product')->with('edit_product',$edit_product)
        ->with('cate_product',$cate_product)
        ->with('brand_product',$brand_product);
        return view("admin_layout")->with('admin.edit_product',$manager_product);
    }

    public function update_product(Request $req,$product_id){

        $this->CheckLogin();

        $data = array();
        $data['product_name'] = $req->product_name;
        $data['product_price'] = $req->product_price;
        $data['product_desc'] = $req->product_desc;
        $data['product_content'] = $req->product_content;
        $data['category_id'] = $req->product_cate;
        $data['brand_id'] = $req->product_brand;
        $data['product_status'] = $req->product_status;
        $data['product_quantity'] = $req->product_quantity;

        $get_image=$req->file('product_image');

        if($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/upload/product', $new_image);
            $data['product_image'] = $new_image;
            DB::table('tbl_product')->where('product_id',$product_id)->update($data);
            Session::put('message','Cập Nhập Sản phẩm thành công');
            return redirect::to('all-product');
        }

        DB::table('tbl_product')->where('product_id',$product_id)->update($data);
        Session::put('message','Cập Nhập sản phẩm thành công');
        return redirect::to('all-product');
    }

    public function delete_product($product_id) {

        $this->CheckLogin();

        DB::table('tbl_product')->where('product_id',$product_id)->delete();
        Session::put('message','Xóa sản phẩm thành công');
        return redirect::to('all-product');
    }

    //end admin pages

    public function details_product($product_id) {
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('status','0')->orderBy('id','desc')->get();

        $details_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.id','=','tbl_product.brand_id')
        ->where('tbl_product.product_id',$product_id)->get();

        foreach($details_product as $key => $value){

            $category_id = $value->category_id;
        }

        $related_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.id','=','tbl_product.brand_id')
        ->where('tbl_category_product.category_id',$category_id)
        ->whereNotIn('tbl_product.product_id',[$product_id])
        ->get();

        return view('pages.sanpham.show_detail')->with('category',$cate_product)
        ->with('brand',$brand_product)
        ->with('details_product',$details_product)
        ->with('related',$related_product);

    }
    public function search_admin(Request $req) {
        $keywords = $req->keywords_submit;
    
        // Tìm kiếm sản phẩm theo tên trong bảng sản phẩm
        $search_product = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')
            ->join('tbl_brand', 'tbl_product.brand_id', '=', 'tbl_brand.id')
            ->where('tbl_product.product_name', 'like', '%' . $keywords . '%')
            ->select('tbl_product.*', 'tbl_category_product.category_name', 'tbl_brand.name')
            ->get();
    
        return view('admin.all_product')->with('all_product', $search_product);
    }
    
    
    
    
}
