<?php

use App\Http\Controllers\admin\BlogsController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\CountryController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\frontend\account\AccountController;
use App\Http\Controllers\frontend\account\ProductController;
use App\Http\Controllers\frontend\BlogController;
use App\Http\Controllers\frontend\IndexController;
use App\Http\Controllers\frontend\MemberController;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::middleware(['web'])->group(function () {
    Route::get('/', [MemberController::class, 'login_page']);
    
    Route::post('/', [MemberController::class, 'login']);
    
    Route::get('/logout', [IndexController::class, 'logout']);
    
    Route::get('/frontend/register', [MemberController::class, 'index']);
    
    Route::post('/frontend/register', [MemberController::class, 'create']);
    
    Route::get('/index', [IndexController::class, 'index']);
    
    Route::get('/blog', [BlogController::class, 'index']);

    Route::get('/shop/product', [IndexController::class, 'shop']);

    Route::get('/account/my-product/add', [ProductController::class, 'add_page']);

    Route::get('/account/my-account', [AccountController::class, 'index']);

    Route::get('/account/my-product', [ProductController::class, 'index']);

    Route::get('/cart', [IndexController::class, 'cart']);

    Route::group(['prefix' => 'frontend'], function () {

        // route blog

        Route::get('/frontend/blog/blog-detail/{id}', [BlogController::class, 'detail']);

        Route::post('/frontend/blog/blog-detail/rate', [BlogController::class, 'rating']);

        Route::post('/frontend/blog/blog-detail/comment', [BlogController::class, 'comment']);

        // route index
        

        Route::post('/index', [IndexController::class, 'index_add_cart']);

        Route::post('/index/price-range', [IndexController::class, 'range_price']);

        Route::post('/search', [IndexController::class, 'search']);

        Route::post('/search/add_cart', [IndexController::class, 'search_add_cart']);

        Route::post('/shop/product', [IndexController::class, 'research']);

        // route account

        Route::post('/account/my-account', [AccountController::class, 'update']);


        // product
        
        Route::post('/account/my-product/add', [ProductController::class, 'create']);

        Route::get('/account/my-product/edit/{id}', [ProductController::class, 'show']);

        Route::post('/account/my-product/edit/{id}', [ProductController::class, 'update']);

        Route::get('/product/product-detail/{id}', [IndexController::class, 'show_product']);

        Route::post('/product/product-detail/add_cart', [IndexController::class, 'add_cart']);


        Route::post('/cart', [IndexController::class, 'action_update']);

        Route::get('/check-out', [IndexController::class, 'check_out']);

        // route email
        Route::get('/check-out/send-mail', [MailController::class, 'index']);
    });
});

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/admin/login', function () {
        return view('auth/login');
    });

    Route::get('/admin/register', function () {
        return view('auth/register');
    });

    Route::group(['prefix' => 'admin'], function () {
        Route::get('/admin/dashboard', [App\Http\Controllers\HomeController::class, 'index']);

        Route::get('/admin/pages-profile', [DashboardController::class, 'profile']);

        Route::post('/admin/pages-profile', [DashboardController::class, 'update_profile']);

        Route::get('/admin/form-basic', function () {
            return view('admin/dashboards/form-basic');
        });

        // route blog
        Route::get('/admin/blog/list', [BlogsController::class, 'index']);

        Route::get('/admin/blog/add', [BlogsController::class, 'add']);

        Route::post('/admin/blog/add', [BlogsController::class, 'create']);

        Route::get('/admin/blog/edit/{id}', [BlogsController::class, 'edit']);

        Route::post('/admin/blog/edit/{id}', [BlogsController::class, 'update']);

        Route::get('/admin/blog/delete/{id}', [BlogsController::class, 'delete']);

        // route dashboard country
        Route::get('/admin/country', [CountryController::class, 'index']);

        Route::get('/admin/country/add', [CountryController::class, 'add']);

        Route::post('/admin/country/add', [CountryController::class, 'create']);

        Route::get('/admin/country/edit/{id}', [CountryController::class, 'edit']);

        Route::post('/admin/country/edit/{id}', [CountryController::class, 'update']);

        Route::get('/admin/country/delete/{id}', [CountryController::class, 'delete']);

        Route::get('/admin/table-basic', function () {
            return view('admin/dashboards/table-basic');
        });

        Route::get('/admin/icon-material', function () {
            return view('admin/dashboards/icon-material');
        });

        Route::get('/admin/starter-kit', function () {
            return view('admin/dashboards/starter-kit');
        });

        Route::get('/admin/error-404', function () {
            return view('admin/dashboards/error-404');
        });

        // route brand
        Route::get('/admin/brand/index', [BrandController::class, 'index']);

        Route::get('/admin/brand/add', [BrandController::class, 'add_page']);

        Route::post('/admin/brand/add', [BrandController::class, 'create']);

        Route::get('/admin/brand/edit/{id}', [BrandController::class, 'show']);

        Route::post('/admin/brand/edit/{id}', [BrandController::class, 'edit']);

        Route::get('/admin/brand/delete/{id}', [BrandController::class, 'destroy']);

        // route category

        Route::get('/admin/category/index', [CategoryController::class, 'index']);

        Route::get('/admin/category/add', [CategoryController::class, 'add_page']);

        Route::post('/admin/category/add', [CategoryController::class, 'create']);

        Route::get('/admin/category/edit/{id}', [CategoryController::class, 'show']);

        Route::post('/admin/category/edit/{id}', [CategoryController::class, 'edit']);

        Route::get('/admin/category/delete/{id}', [CategoryController::class, 'destroy']);
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('admin/dashboards/dashboard');
