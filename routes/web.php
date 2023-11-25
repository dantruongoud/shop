<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\CountryController;
use App\Http\Controllers\admin\BlogsController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\frontend\account\AccountController;
use App\Http\Controllers\frontend\account\ProductController;
use App\Http\Controllers\frontend\BlogController;
use App\Http\Controllers\frontend\IndexController;
use App\Http\Controllers\frontend\MemberController;
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


// route blog

Route::get('/frontend/blog', [BlogController::class, 'index']);

Route::get('/frontend/blog/blog-detail/{id}', [BlogController::class, 'detail']);


Route::post('/frontend/blog/blog-detail/rate', [BlogController::class, 'rating']);


Route::post('/frontend/blog/blog-detail/comment', [BlogController::class, 'comment']);

Route::post('/frontend/blog/blog-detail/reply/{$id}', [BlogController::class, 'reply']);

Route::get('/frontend/index', function () {
    return view('frontend/index');
});


// Route user frontend

Route::get('/', [MemberController::class, 'login_page']);

Route::post('/', [MemberController::class, 'login']);

Route::get('/logout', [IndexController::class, 'logout']);

Route::get('/register', [MemberController::class, 'index']);

Route::post('/register', [MemberController::class, 'create']);


// route account

Route::get('/frontend/account/my-account', [AccountController::class, 'index']);

Route::post('/frontend/account/my-account', [AccountController::class, 'update']);

Route::get('/frontend/account/my-product', [ProductController::class, 'index']);

Route::get('/frontend/account/my-product/add', [ProductController::class, 'add_page']);


Route::post('/frontend/account/my-product/add', [ProductController::class, 'store']);


Route::get('/frontend/account/product-detail', function () {
    return view('frontend/product/product-details');
});

Route::get('/admin/login', function () {
    return view('auth/login');
});

Route::get('/admin/register', function () {
    return view('auth/register');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('admin/dashboards/dashboard');

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
