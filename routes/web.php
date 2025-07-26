<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\frontpage\BlogController;
use App\Http\Controllers\frontpage\HomeController;
use App\Http\Controllers\frontpage\AboutController;
use App\Http\Controllers\frontpage\ContactController;
use App\Http\Controllers\frontpage\ProjectController;
use App\Http\Controllers\frontpage\ServiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/ms-admin-ikhsannawawi', function () {
//     Artisan::call('migrate:fresh --seed');
//     return redirect()->route('index');
// });

Route::get('/', [HomeController::class, 'index'])->name('web.index');
Route::get('/getService', [HomeController::class, 'getService'])->name('web.getService');
Route::get('/getProject', [HomeController::class, 'getProject'])->name('web.getProject');
Route::get('/getBlog', [HomeController::class, 'getBlog'])->name('web.getBlog');
Route::get('/getGallery', [HomeController::class, 'getGallery'])->name('web.getGallery');
Route::get('/getBanner', [HomeController::class, 'getBanner'])->name('web.getBanner');
Route::get('/count', [HomeController::class, 'count'])->name('web.count');

Route::get('/project', [ProjectController::class, 'index'])->name('web.project');
Route::get('/project/fetchData', [ProjectController::class, 'fetchData'])->name('web.project.fetchData');
Route::get('/project/{slug}', [ProjectController::class, 'detail'])->name('web.project.slug');
Route::post('/project/{slug}/comment', [ProjectController::class, 'comment'])->name('web.project.slug.comment');
Route::post('/project/{slug}/comment/reply', [ProjectController::class, 'reply'])->name('web.project.slug.comment.reply');
Route::get('/project/fetchData/comment', [ProjectController::class, 'fetchDataComment'])->name('web.project.fetchData.comment');

Route::get('/service', [ServiceController::class, 'index'])->name('web.service');
Route::get('/service/getService', [ServiceController::class, 'getService'])->name('web.service.getService');
Route::get('/service/getClient', [ServiceController::class, 'getClient'])->name('web.service.getClient');

Route::get('/about', [AboutController::class, 'index'])->name('web.about');
Route::get('/about/getService', [AboutController::class, 'getService'])->name('web.about.getService');
Route::get('/about/getAbout', [AboutController::class, 'getAbout'])->name('web.about.getAbout');

Route::get('/blog', [BlogController::class, 'index'])->name('web.blog');
Route::get('/blog/fetchData', [BlogController::class, 'fetchData'])->name('web.blog.fetchData');
Route::get('/blog/{slug}', [BlogController::class, 'detail'])->name('web.blog.slug');
Route::post('/blog/{slug}/comment', [BlogController::class, 'comment'])->name('web.blog.slug.comment');
Route::post('/blog/{slug}/comment/reply', [BlogController::class, 'reply'])->name('web.blog.slug.comment.reply');
Route::get('/blog/fetchData/comment', [BlogController::class, 'fetchDataComment'])->name('web.blog.fetchData.comment');

Route::get('/contact', [ContactController::class, 'index'])->name('web.contact');