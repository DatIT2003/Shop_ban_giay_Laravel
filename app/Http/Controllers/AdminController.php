<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

// use DB;

class AdminController extends Controller
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
    public function index(){
        return view('admin_login');
    }

    public function show_Dashboard() {

        $this->CheckLogin();

        return view('admin.dashboard');
    }

    public function dashboard(Request $req) {
        $admin_email = $req->admin_email;
        $admin_password = md5($req->admin_password);

        $result = DB::table('tbl_admin')->where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
       if($result) {
        Session::put('admin_name',$result->admin_name);
        Session::put('admin_id',$result->admin_id);
        return Redirect::to('/Dashboard');
       }else {
        Session::put('message','Tài khoản hoặc mật khẩu bị sai !! vui lòng đăng nhập lại');
        return Redirect::to('/Admin');
       }

    }

    public function logout() {

        $this->CheckLogin();

        Session::put('admin_name',null);
        Session::put('admin_id',null);
        return Redirect::to('/Admin');
    }
}
