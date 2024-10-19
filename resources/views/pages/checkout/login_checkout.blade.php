@extends('welcome')
@section('content')

<section id="form"><!--form-->
    <div class="register-req">
        <p>Vui lòng đăng ký hoặc đăng nhập để thanh toán giỏ hàng và xem trang các sản phẩm yêu thích của bạn</p>
    </div><!--/register-req-->
    <div class="container">  
        <div class="row">
            <!-- Display error messages -->
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            
            <div class="col-sm-4 col-sm-offset-1">
                <div class="login-form"><!--login form-->
                    <h2>Đăng Nhập Tài Khoản</h2>
                    <form action="{{ URL::to('/login-customer') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="text" name="email_account" placeholder="Tài Khoản" />
                        <input type="password" name="password_account" placeholder="Mật Khẩu" />
                        <span>
                            <input type="checkbox" class="checkbox"> 
                            Ghi Nhớ Lần Đăng Nhập
                        </span>
                        <button type="submit" class="btn btn-default">Đăng Nhập</button>
                        <a href="#" data-toggle="modal" data-target="#forgotPasswordModal">Quên mật khẩu?</a>
                    </form>
                </div><!--/login form-->
            </div>
            <div class="col-sm-1">
                <h2 class="or">Hoặc</h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form"><!--sign up form-->
                    <h2>Đăng Ký</h2>
                    <form action="{{ URL::to('/add-customer') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="text" name="customer_name" placeholder="Họ Và Tên" required/>
                        <input type="email" name="customer_email" placeholder="Địa Chỉ email" required/>
                        <input type="password" name="customer_password" placeholder="Mật Khẩu" required/>
                        <input type="text" name="customer_phone" placeholder="Phone" required/>
                        <button type="submit" class="btn btn-default">Đăng Ký</button>
                    </form>
                </div><!--/sign up form-->
            </div>
        </div>
    </div>
</section><!--/form-->

<!-- Forgot Password Modal -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forgotPasswordModalLabel">Quên Mật Khẩu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ URL::to('/password-reset') }}" method="POST">
          {{ csrf_field() }}
          <div class="form-group">
            <label for="email">Địa Chỉ Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email của bạn" required>
          </div>
          <button type="submit" class="btn btn-primary">Gửi Email Khôi Phục</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
