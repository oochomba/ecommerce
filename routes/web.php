<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\SubSubCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\DiscountCodeController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\ShippingChargeController;


use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;


use App\Http\Controllers\PoductController as ProductFront;
use App\Http\Controllers\DashboardController as DashboardFront;

use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CustomerMiddleware;
use Illuminate\Support\Facades\Route;




/**
 * admin routes
 */
Route::get('admin', [AuthController::class, 'login_admin'])->name('admin.login');
Route::post('admin', [AuthController::class, 'auth_login_admin']);
Route::get('admin/logout', [AuthController::class, 'auth_guard_logout_admin']);


Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {
    // Route::group(['middleware' => AdminMiddleware::class], function () {
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::get('customer-contacts', [DashboardController::class, 'customer_contacts']);


    Route::get('admin/list', [AdminController::class, 'index']);
    Route::get('admin/add', [AdminController::class, 'add']);
    Route::post('admin/add', [AdminController::class, 'store']);
    Route::get('admin/edit/{id}', [AdminController::class, 'edit']);
    Route::post('admin/edit/{id}', [AdminController::class, 'update']);
    Route::post('admin/delete/{id}', [AdminController::class, 'delete']);


    Route::get('roles', [RolesController::class, 'index']);
    Route::get('roles/add', [RolesController::class, 'add']);
    Route::post('roles/add', [RolesController::class, 'store']);
    Route::get('roles/edit/{id}', [RolesController::class, 'edit']);
    Route::post('roles/edit/{id}', [RolesController::class, 'update']);
    Route::post('roles/delete/{id}', [RolesController::class, 'delete']);

    Route::get('permission', [RolesController::class, 'permission']);
    Route::get('permission/add', [RolesController::class, 'permission_add']);
    Route::post('permission/add', [RolesController::class, 'permission_store']);
    Route::post('permission/add-crud', [RolesController::class, 'permission_store_crud']);
    Route::post('permission/delete/{id}', [RolesController::class, 'permission_delete']);




    Route::get('category/list', [CategoryController::class, 'index']);
    Route::get('category/add', [CategoryController::class, 'add']);
    Route::post('category/add', [CategoryController::class, 'store']);
    Route::get('category/edit/{id}', [CategoryController::class, 'edit']);
    Route::post('category/edit/{id}', [CategoryController::class, 'update']);
    Route::post('category/delete/{id}', [CategoryController::class, 'delete']);


    Route::get('sub_category/list', [SubCategoryController::class, 'index']);
    Route::get('sub_category/add', [SubCategoryController::class, 'add']);
    Route::post('sub_category/add', [SubCategoryController::class, 'store']);
    Route::get('sub_category/edit/{id}', [SubCategoryController::class, 'edit']);
    Route::post('sub_category/edit/{id}', [SubCategoryController::class, 'update']);
    Route::post('sub_category/delete/{id}', [SubCategoryController::class, 'delete']);
    Route::post('get_sub_category', [SubCategoryController::class, 'get_sub_category']);


    Route::get('sub_SubCategory/list', [SubSubCategoryController::class, 'index']);
    Route::get('sub_SubCategory/add', [SubSubCategoryController::class, 'add']);
    Route::post('sub_SubCategory/add', [SubSubCategoryController::class, 'store']);
    Route::get('sub_SubCategory/edit/{id}', [SubSubCategoryController::class, 'edit']);
    Route::post('sub_SubCategory/edit/{id}', [SubSubCategoryController::class, 'update']);
    Route::post('sub_SubCategory/delete/{id}', [SubSubCategoryController::class, 'delete']);
    Route::post('get_sub_subcategory', [SubSubCategoryController::class, 'get_sub_subcategory']);


    Route::get('product/list', [ProductController::class, 'index']);
    Route::get('product/add', [ProductController::class, 'add']);
    Route::post('product/add', [ProductController::class, 'store']);
    Route::get('product/edit/{id}', [ProductController::class, 'edit']);
    Route::post('product/edit/{id}', [ProductController::class, 'update']);
    Route::post('product/del_product_image/{id}', [ProductController::class, 'deleteProductImage']);
    Route::post('product_image_sortable', [ProductController::class, 'productImageSortable']);

    Route::get('brand/list', [BrandController::class, 'index']);
    Route::get('brand/add', [BrandController::class, 'add']);
    Route::post('brand/add', [BrandController::class, 'store']);
    Route::get('brand/edit/{id}', [BrandController::class, 'edit']);
    Route::post('brand/edit/{id}', [BrandController::class, 'update']);
    Route::post('brand/delete/{id}', [BrandController::class, 'delete']);

    Route::get('color/list', [ColorController::class, 'index']);
    Route::get('color/add', [ColorController::class, 'add']);
    Route::post('color/add', [ColorController::class, 'store']);
    Route::get('color/edit/{id}', [ColorController::class, 'edit']);
    Route::post('color/edit/{id}', [ColorController::class, 'update']);
    Route::post('color/delete/{id}', [ColorController::class, 'delete']);

    Route::get('discountcode/list', [DiscountCodeController::class, 'index']);
    Route::get('discountcode/add', [DiscountCodeController::class, 'add']);
    Route::post('discountcode/add', [DiscountCodeController::class, 'store']);
    Route::get('discountcode/edit/{id}', [DiscountCodeController::class, 'edit']);
    Route::post('discountcode/edit/{id}', [DiscountCodeController::class, 'update']);
    Route::post('discountcode/delete/{id}', [DiscountCodeController::class, 'delete']);

    Route::get('shippingcharge/list', [ShippingChargeController::class, 'index']);
    Route::get('shippingcharge/add', [ShippingChargeController::class, 'add']);
    Route::post('shippingcharge/add', [ShippingChargeController::class, 'store']);
    Route::get('shippingcharge/edit/{id}', [ShippingChargeController::class, 'edit']);
    Route::post('shippingcharge/edit/{id}', [ShippingChargeController::class, 'update']);
    Route::post('shippingcharge/delete/{id}', [ShippingChargeController::class, 'delete']);
});

Route::group(['middleware' => 'auth:customer'], function () {
    Route::get('dashboard', [DashboardFront::class, 'index']);
});


Route::get('', [HomeController::class, 'index'])->name('home');
Route::get('contact', [HomeController::class, 'contact']);
Route::post('contact', [HomeController::class, 'contact_post']);


Route::post('register-customer', [AuthController::class, 'register_customer']);
Route::post('login-customer', [AuthController::class, 'login_customer'])->name('customer.login');
Route::get('activate/{id}', [AuthController::class, 'activate_customer']);
Route::get('logout', [AuthController::class, 'auth_logout_user']);
Route::get('forgot-password', [AuthController::class, 'forgot_password']);
Route::post('forgot-password', [AuthController::class, 'forgot_password_confirm']);
Route::get('password-reset/{token}', [AuthController::class, 'password_reset']);
Route::post('password-reset/{token}', [AuthController::class, 'password_reset_confirm']);


Route::post('product/add-to-cart', [PaymentController::class, 'add_to_cart']);
Route::get('cart', [PaymentController::class, 'cart']);
Route::get('delete-cart-item/{id}', [PaymentController::class, 'delete_cart_item']);
Route::post('update-cart', [PaymentController::class, 'update_cart']);
Route::get('checkout', [PaymentController::class, 'checkout']);
Route::post('apply-discount', [PaymentController::class, 'apply_discount']);
Route::post('place-order', [PaymentController::class, 'place_order']);
Route::get('payment', [PaymentController::class, 'payment']);
Route::get('paypal/success-payment', [PaymentController::class, 'paypal_success_payment']);






Route::get('search', [ProductFront::class, 'searchProduct']);
Route::get('shop', [ProductFront::class, 'shop']);
Route::get('{category?}/{subcategory?}', [ProductFront::class, 'index']);
Route::post('product_filter_ajax', [ProductFront::class, 'productFilterAjax']);
