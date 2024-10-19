<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandProduct;
use App\Http\Controllers\Cartcontroller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryProduct;
use App\Http\Controllers\Checkoutcontroller;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DiscountCodeController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
// frontend

    // Trang Chủ
Route::get('/', [HomeController::class, 'index']);
Route::get('/Trang-chu', [HomeController::class, 'index']);
Route::post('/tim-kiem', [HomeController::class, 'search']);



    //Danh mục sản phẩm trang chủ
Route::get('/danh-muc-san-pham/{category_id}', [CategoryProduct::class, 'show_category_home']);
Route::get('/thuong-hieu-san-pham/{brand_id}', [BrandProduct::class, 'show_brand_home']);
Route::get('/chi-tiet-san-pham/{product_id}', [ProductController::class, 'details_product']);





//backend

     // Trang login để vào dashboard
Route::get('/Admin', [AdminController::class, 'index']);
     // Trang Quản Lý
Route::get('/Dashboard', [AdminController::class, 'show_Dashboard']);
     // trang logout để về lại trang admin
Route::get('/logout', [AdminController::class, 'logout']);
     // kiểm tra xem đã đăng nhập thành công hay chưa ( sử dụng phương thức POST)
Route::post('/admin-dashboard', [AdminController::class, 'dashboard']);


    //Category Product

      // trang hiển thị thêm danh mục 
Route::get('/add-category-product', [CategoryProduct::class, 'add_category_product']);
      // trang hiển thị chỉnh sử danh mục
Route::get('/edit-category-product/{category_product_id}', [CategoryProduct::class, 'edit_category_product']);
      // Xóa Danh mục
Route::get('/delete-category-product/{category_product_id}', [CategoryProduct::class, 'delete_category_product']);
      // trang layout hiển thị tất cả danh mục
Route::get('/all-category-product', [CategoryProduct::class, 'all_category_product']);

Route::get('/unactive-category-product/{category_product_id}', [CategoryProduct::class, 'unactive_category_product']);
Route::get('/active-category-product/{category_product_id}', [CategoryProduct::class, 'active_category_product']);

      // Đẩy dữ liệu mới từ trang /add-category-product lên database ( sử dụng phương thức POST )
Route::post('/save-category-product', [CategoryProduct::class, 'save_category_product']);
      // Đẩy dữ liệu mới chỉnh sửa từ trang /edit-category-product/{category_product_id} lên database (sử dụng phương thức POST)
Route::post('/update-category-product/{category_product_id}', [CategoryProduct::class, 'update_category_product']);




    //Brand Product
Route::get('/add-brand-product', [BrandProduct::class, 'add_brand_product']);
Route::get('/edit-brand-product/{brand_product_id}', [BrandProduct::class, 'edit_brand_product']);
Route::get('/delete-brand-product/{brand_product_id}', [BrandProduct::class, 'delete_brand_product']);
Route::get('/all-brand-product', [BrandProduct::class, 'all_brand_product']);

Route::get('/unactive-brand-product/{brand_product_id}', [BrandProduct::class, 'unactive_brand_product']);
Route::get('/active-brand-product/{brand_product_id}', [BrandProduct::class, 'active_brand_product']);

Route::post('/save-brand-product', [BrandProduct::class, 'save_brand_product']);
Route::post('/update-brand-product/{brand_product_id}', [BrandProduct::class, 'update_brand_product']);



    //Product
Route::get('/add-product', [ProductController::class, 'add_product']);
Route::get('/edit-product/{product_id}', [ProductController::class, 'edit_product']);
Route::get('/delete-product/{product_id}', [ProductController::class, 'delete_product']);
Route::get('/all-product', [ProductController::class, 'all_product']);

Route::get('/unactive-product/{product_id}', [ProductController::class, 'unactive_product']);
Route::get('/active-product/{product_id}', [ProductController::class, 'active_product']);

Route::post('/save-product', [ProductController::class, 'save_product']);
Route::post('/update-product/{product_id}', [ProductController::class, 'update_product']);



    //Cart
Route::get('/show-cart', [Cartcontroller::class, 'show_cart']);
Route::post('/save-cart', [Cartcontroller::class, 'save_cart']);
Route::post('/update-cart-quantity', [Cartcontroller::class, 'update_cart_quantity']);
Route::get('/delete-to-cart/{rowId}', [Cartcontroller::class, 'delete_to_cart']);

Route::post('/apply-discount', [CartController::class, 'applyDiscount']);
Route::post('/apply-shipping-discount', [CartController::class, 'applyShippingDiscount']);



    //checkout
Route::get('/login-checkout', [Checkoutcontroller::class, 'login_checkout']);
Route::get('/logout-checkout', [Checkoutcontroller::class, 'logout_checkout']);
Route::post('/add-customer', [Checkoutcontroller::class, 'add_customer']);
Route::post('/order-place', [Checkoutcontroller::class, 'order_place']);
Route::post('/login-customer', [Checkoutcontroller::class, 'login_customer']);
Route::get('/checkout', [Checkoutcontroller::class, 'checkout']);
Route::get('/payment', [Checkoutcontroller::class, 'payment']);
Route::post('/save-checkout-customer', [Checkoutcontroller::class, 'save_checkout_customer']);

Route::get('/review-order', [Checkoutcontroller::class, 'review_order']);
Route::post('/update-shipping-info', [Checkoutcontroller::class, 'update_shipping_info']);






    //Discount

        //mã giảm giá 

Route::get('/all-discount', [DiscountCodeController::class, 'all_discount']);
Route::get('/add-discount', [DiscountCodeController::class, 'add_discount']);
Route::post('/save-discount', [DiscountCodeController::class, 'save_discount']);
Route::get('/edit-discount/{id}', [DiscountCodeController::class, 'edit_discount']);
Route::post('/update-discount/{id}', [DiscountCodeController::class, 'update_discount']);
Route::get('/delete-discount/{id}', [DiscountCodeController::class, 'delete_discount']);

        // mã giảm phí ship


Route::get('/all-shipping-discount', [DiscountCodeController::class, 'all_shipping_discount']);
Route::get('/add-shipping-discount', [DiscountCodeController::class, 'add_shipping_discount']);
Route::post('/save-shipping-discount', [DiscountCodeController::class, 'save_shipping_discount']);
Route::get('/edit-shipping-discount/{id}', [DiscountCodeController::class, 'edit_shipping_discount']);
Route::post('/update-shipping-discount/{id}', [DiscountCodeController::class, 'update_shipping_discount']);
Route::get('/delete-shipping-discount/{id}', [DiscountCodeController::class, 'delete_shipping_discount']);






    //order
Route::get('/manage-order', [Checkoutcontroller::class, 'manage_order']);
Route::get('/view-order/{order_Id}', [Checkoutcontroller::class, 'view_order']); //{{URL::to('/view-order/'.$order->order_id)}}
Route::post('/update-order-status/{order_id}', [CheckoutController::class, 'update_order_status']); 
Route::get('/edit-order/{id}', [OrderController::class, 'editOrder'])->name('edit.order');


   //contact
Route::get('/contact', [ContactController::class, 'contact']);
Route::post('/contact', [ContactController::class, 'submitContactForm'])->name('contact.submit');
Route::get('/contact-list', [ContactController::class, 'listContacts']);
Route::get('/admin/contact/reply/{id}', [ContactController::class, 'showReplyForm'])->name('admin.contact.reply');
Route::post('/admin/contact/reply/{id}', [ContactController::class, 'sendReply'])->name('admin.contact.sendReply');


    // tin tức
Route::get('/tintuc', [NewsController::class, 'tintuc']);


    //email
Route::post('/password-reset', [Checkoutcontroller::class, 'sendPasswordResetLink']);


    //Users
Route::get('/users', [UserController::class, 'show_users'])->name('users.index');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');



    //pagelike
Route::get('/add-favorite/{id}', [FavoriteController::class, 'addFavorite'])->name('add.favorite');
Route::get('/favorites', [FavoriteController::class, 'showFavorites'])->name('favorites');
Route::delete('/remove-favorite/{id}', [FavoriteController::class, 'removeFavorite'])->name('remove.favorite');



    // theo dõi đơn đặt hàng : 
Route::get('/track-order', [OrderController::class, 'trackOrder'])->name('track-order');

Route::get('/order-details/{order_id}', [OrderController::class, 'showOrderDetails'])->name('order.details');

// tìm kiếm sản phẩm
Route::post('/search-admin', [ProductController::class, 'search_admin']);

Route::get('/admin/profile', [UserController::class, 'view_profile'])->name('admin.profile');

// Route::get('/view-order/{order_Id}', 'OrderController@viewOrder');
Route::get('/view-order/{order_id}', [OrderController::class, 'viewOrder']);
// Route::get('/view-order/{id}', [OrderController::class, 'viewOrder'])->name('view_order');

Route::get('/orders/{orderId}', [OrderController::class, 'viewOrder'])->name('admin.view_order');






