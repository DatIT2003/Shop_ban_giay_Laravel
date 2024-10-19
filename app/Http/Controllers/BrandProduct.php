<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;


class BrandProduct extends Controller
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

    public function add_brand_product(){

        $this->CheckLogin();


        return view("admin.add_brand_product");
    }

    public function all_brand_product(){

        $this->CheckLogin();


        $all_brand_product = DB::table('tbl_brand')->get();
        $manager_brand_product = view('admin.all_brand_product')->with('all_brand_product',$all_brand_product);

        return view("admin_layout")->with('admin.all_brand_product',$manager_brand_product);
        
    }

    public function save_brand_product(Request $req) {

        $this->CheckLogin();

        $data = array();

        // cột trong database = cột trong Dom
        $data['name'] = $req->brand_product_name;
        $data['desc'] = $req->brand_product_desc;
        $data['status'] = $req->brand_product_status;

        DB::table('tbl_brand')->insert($data);
        Session::put('message','Thêm Thương Hiệu sản phẩm thành công');
        return redirect::to('add-brand-product');
    }

    public function unactive_brand_product($brand_product_id){

        $this->CheckLogin();

        DB::table('tbl_brand')->where('brand_id',$brand_product_id)->update(['brand_status'=>1]);
        Session::put('message','không kích hoạt Thương Hiệu sản phẩm thành công');
        return redirect::to('all-brand-product');

    }
    public function active_brand_product($brand_product_id){

        $this->CheckLogin();

        DB::table('tbl_brand')->where('id',$brand_product_id)->update(['status'=>0 ]);
        Session::put('message','kích hoạt Thương Hiệu sản phẩm thành công');
        return redirect::to('all-brand-product');
    }

    public function edit_brand_product($brand_product_id){

        $this->CheckLogin();

        $edit_brand_product = DB::table('tbl_brand')->where('brand_id',$brand_product_id)->get();
        $manager_brand_product = view('admin.edit_brand_product')->with('edit_brand_product',$edit_brand_product);
        return view("admin_layout")->with('admin.edit_brand_product',$manager_brand_product);
    }

    public function update_brand_product(Request $req,$brand_product_id){

        $this->CheckLogin();

        $data = array();
        $data['brand_name'] = $req->brand_product_name;
        $data['brand_desc'] = $req->brand_product_desc;
        DB::table('tbl_brand')->where('brand_id',$brand_product_id)->update($data);
        Session::put('message','Cập Nhập Thương Hiệu sản phẩm thành công');
        return redirect::to('all-brand-product');
    }

    public function delete_brand_product($brand_product_id) {

        $this->CheckLogin();

        DB::table('tbl_brand')->where('id',$brand_product_id)->delete();
        Session::put('message','Xóa Thương Hiệu sản phẩm thành công');
        return redirect::to('all-brand-product');
    }

    //End function Admin pages
    public function show_brand_home($brand_id){
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('status','0')->orderBy('id','desc')->get();


        $brand_by_id = DB::table('tbl_product')
        ->join('tbl_brand','tbl_product.brand_id','=','tbl_brand.id')
        ->where('tbl_product.brand_id',$brand_id)
        ->get();

        $brand_name = DB::table('tbl_brand')->where('tbl_brand.id',$brand_id)->limit(1)->get();

        return view('pages.brand.show_brand')
                ->with('category',$cate_product)
                ->with('brand',$brand_product)
                ->with('brand_by_id',$brand_by_id)
                ->with('brand_name',$brand_name);;
    }
}
