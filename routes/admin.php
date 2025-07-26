<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\BlogController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\viewController;
use App\Http\Controllers\admin\AboutController;
use App\Http\Controllers\admin\BannerController;
use App\Http\Controllers\admin\ClientController;
use App\Http\Controllers\admin\ModuleController;
use App\Http\Controllers\admin\ContactController;
use App\Http\Controllers\admin\GalleryController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\admin\ProjectController;
use App\Http\Controllers\admin\ServiceController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\LogSystemController;
use App\Http\Controllers\admin\UserGroupController;
use App\Http\Controllers\admin\KategoriBlogController;
use App\Http\Controllers\admin\KomentarBlogController;
use App\Http\Controllers\admin\KategoriProjectController;
use App\Http\Controllers\admin\KomentarProjectController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ------------------------------------------  Admin -----------------------------------------------------------------
Route::prefix('admin')->group(function () {
    Route::post('login/checkEmail', [AuthController::class, 'checkEmail'])->name('admin.login.checkEmail');
    Route::post('login/checkPassword', [AuthController::class, 'checkPassword'])->name('admin.login.checkPassword');
    Route::get('login', [AuthController::class, 'login'])->name('admin.login');
    Route::post('loginProses', [AuthController::class, 'loginProses'])->name('admin.loginProses');
    Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');
    
    Route::get('main-admin', [viewController::class, 'main_admin'])->name('main_admin');

    Route::middleware(['auth.admin'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('dashboard/fetchData', [DashboardController::class, 'fetchData'])->name('admin.dashboard.fetchData');

        //Log Systems
        Route::get('log-systems', [LogSystemController::class, 'index'])->name('admin.logSystems');
        Route::get('log-systems/getData', [LogSystemController::class, 'getData'])->name('admin.logSystems.getData');
        Route::get('log-systems/getDataModule', [LogSystemController::class, 'getDataModule'])->name('admin.logSystems.getDataModule');
        Route::get('log-systems/getDataUser', [LogSystemController::class, 'getDataUser'])->name('admin.logSystems.getDataUser');
        Route::get('log-systems/getDetail{id}', [LogSystemController::class, 'getDetail'])->name('admin.logSystems.getDetail');
        Route::get('log-systems/clearLogs', [LogSystemController::class, 'clearLogs'])->name('admin.logSystems.clearLogs');
        Route::get('log-systems/generatePDF', [LogSystemController::class, 'generatePDF'])->name('admin.logSystems.generatePDF');
    
        //User Group
        Route::get('user-groups', [UserGroupController::class, 'index'])->name('admin.user_groups');
        Route::get('user-groups/add', [UserGroupController::class, 'add'])->name('admin.user_groups.add');
        Route::get('user-groups/getData', [UserGroupController::class, 'getData'])->name('admin.user_groups.getData');
        Route::post('user-groups/save', [UserGroupController::class, 'save'])->name('admin.user_groups.save');
        Route::get('user-groups/edit/{id}', [UserGroupController::class, 'edit'])->name('admin.user_groups.edit');
        Route::put('user-groups/update', [UserGroupController::class, 'update'])->name('admin.user_groups.update');
        Route::get('user-groups/delete', [UserGroupController::class, 'delete'])->name('admin.user_groups.delete');
        Route::get('user-groups/getDetail-{id}', [UserGroupController::class, 'getDetail'])->name('admin.user_groups.getDetail');
        Route::post('user-groups/changeStatus',[UserGroupController::class, 'changeStatus'])->name('admin.user_groups.changeStatus');
        Route::post('user-groups/checkName',[UserGroupController::class, 'checkName'])->name('admin.user_groups.checkName');
        
        //User
        Route::get('users', [UserController::class, 'index'])->name('admin.users');
        Route::get('users/add', [UserController::class, 'add'])->name('admin.users.add');
        Route::get('users/getData', [UserController::class, 'getData'])->name('admin.users.getData');
        Route::post('users/save', [UserController::class, 'save'])->name('admin.users.save');
        Route::get('users/edit/{id}', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('users/update', [UserController::class, 'update'])->name('admin.users.update');
        Route::get('users/delete', [UserController::class, 'delete'])->name('admin.users.delete');
        Route::get('users/getDetail-{id}', [UserController::class, 'getDetail'])->name('admin.users.getDetail');
        Route::get('users/getUserGroup', [UserController::class, 'getUserGroup'])->name('admin.users.getUserGroup');
        Route::post('users/changeStatus',[UserController::class, 'changeStatus'])->name('admin.users.changeStatus');
        Route::get('users/generateKode',[UserController::class, 'generateKode'])->name('admin.users.generateKode');
        Route::post('users/checkEmail',[UserController::class, 'checkEmail'])->name('admin.users.checkEmail');
        Route::post('users/checkKode',[UserController::class, 'checkKode'])->name('admin.users.checkKode');

        Route::get('users/arsip',[UserController::class, 'arsip'])->name('admin.users.arsip');
        Route::get('users/arsip/getDataArsip',[UserController::class, 'getDataArsip'])->name('admin.users.getDataArsip');
        Route::put('users/arsip/restore',[UserController::class, 'restore'])->name('admin.users.restore');
        Route::get('users/arsip/forceDelete',[UserController::class, 'forceDelete'])->name('admin.users.forceDelete');
        
        //Profile
        Route::get('profile/{kode}', [ProfileController::class, 'index'])->name('admin.profile');
        Route::get('profile/getData', [ProfileController::class, 'getData'])->name('admin.profile.getData');
        Route::put('profile/update', [ProfileController::class, 'update'])->name('admin.profile.update');
        Route::get('profile/getDetail-{kode}', [ProfileController::class, 'getDetail'])->name('admin.profile.getDetail');
        Route::post('profile/checkEmail',[ProfileController::class, 'checkEmail'])->name('admin.profile.checkEmail');
        
        //Setting
        Route::get('settings', [SettingController::class, 'main'])->name('admin.settings');
        Route::get('settings/admin', [SettingController::class, 'admin'])->name('admin.settings.admin');
        Route::get('settings/frontpage', [SettingController::class, 'frontpage'])->name('admin.settings.frontpage');

        //Setting Admin
        Route::get('settings/admin/general', [SettingController::class, 'index'])->name('admin.settings.admin.general');
        Route::put('settings/admin/general/update', [SettingController::class, 'update'])->name('admin.settings.admin.general.update');

        //Setting Frontpage Footer
        Route::get('settings/frontpage/footer', [SettingController::class, 'frontpage_footer_index'])->name('admin.settings.frontpage.footer');
        Route::put('settings/frontpage/footer/update', [SettingController::class, 'frontpage_footer_update'])->name('admin.settings.frontpage.footer.update');
        Route::get('settings/frontpage/footer/deleteLink', [SettingController::class, 'frontpage_footer_deleteLink'])->name('admin.settings.frontpage.footer.deleteLink');

        //Setting Frontpage General
        Route::get('settings/frontpage/general', [SettingController::class, 'frontpage_general_index'])->name('admin.settings.frontpage.general');
        Route::put('settings/frontpage/general/update', [SettingController::class, 'frontpage_general_update'])->name('admin.settings.frontpage.general.update');
        Route::get('settings/frontpage/general/deleteSosmed', [SettingController::class, 'frontpage_general_deleteSosmed'])->name('admin.settings.frontpage.general.deleteSosmed');
        
        //Setting Frontpage Homepage
        Route::get('settings/frontpage/homepage', [SettingController::class, 'frontpage_homepage_index'])->name('admin.settings.frontpage.homepage');
        Route::put('settings/frontpage/homepage/update', [SettingController::class, 'frontpage_homepage_update'])->name('admin.settings.frontpage.homepage.update');

        //Modul dan Modul Akses
        Route::get('module', [ModuleController::class, 'index'])->name('admin.module');
        Route::get('module/add', [ModuleController::class, 'add'])->name('admin.module.add');
        Route::get('module/getData', [ModuleController::class, 'getData'])->name('admin.module.getData');
        Route::post('module/save', [ModuleController::class, 'save'])->name('admin.module.save');
        Route::get('module/edit/{id}', [ModuleController::class, 'edit'])->name('admin.module.edit');
        Route::put('module/update', [ModuleController::class, 'update'])->name('admin.module.update');
        Route::get('module/delete', [ModuleController::class, 'delete'])->name('admin.module.delete');
        Route::get('module/getDetail-{id}', [ModuleController::class, 'getDetail'])->name('admin.module.getDetail');

        //Kategori Project
        Route::get('kategori-project', [KategoriProjectController::class, 'index'])->name('admin.kategori_project');
        Route::get('kategori-project/add', [KategoriProjectController::class, 'add'])->name('admin.kategori_project.add');
        Route::get('kategori-project/getData', [KategoriProjectController::class, 'getData'])->name('admin.kategori_project.getData');
        Route::post('kategori-project/save', [KategoriProjectController::class, 'save'])->name('admin.kategori_project.save');
        Route::get('kategori-project/edit/{id}', [KategoriProjectController::class, 'edit'])->name('admin.kategori_project.edit');
        Route::put('kategori-project/update', [KategoriProjectController::class, 'update'])->name('admin.kategori_project.update');
        Route::get('kategori-project/delete', [KategoriProjectController::class, 'delete'])->name('admin.kategori_project.delete');
        Route::get('kategori-project/getDetail-{id}', [KategoriProjectController::class, 'getDetail'])->name('admin.kategori_project.getDetail');
        Route::post('kategori-project/checkNama',[KategoriProjectController::class, 'checkNama'])->name('admin.kategori_project.checkNama');

        Route::get('kategori-project/arsip',[KategoriProjectController::class, 'arsip'])->name('admin.kategori_project.arsip');
        Route::get('kategori-project/arsip/getDataArsip',[KategoriProjectController::class, 'getDataArsip'])->name('admin.kategori_project.getDataArsip');
        Route::put('kategori-project/arsip/restore',[KategoriProjectController::class, 'restore'])->name('admin.kategori_project.restore');
        Route::get('kategori-project/arsip/forceDelete',[KategoriProjectController::class, 'forceDelete'])->name('admin.kategori_project.forceDelete');

        //Project
        Route::get('project', [ProjectController::class, 'index'])->name('admin.project');
        Route::get('project/add', [ProjectController::class, 'add'])->name('admin.project.add');
        Route::get('project/getData', [ProjectController::class, 'getData'])->name('admin.project.getData');
        Route::get('project/getDataKategoriProject', [ProjectController::class, 'getDataKategoriProject'])->name('admin.project.getDataKategoriProject');
        Route::post('project/save', [ProjectController::class, 'save'])->name('admin.project.save');
        Route::get('project/edit/{id}', [ProjectController::class, 'edit'])->name('admin.project.edit');
        Route::get('project/detail/{slug}', [ProjectController::class, 'detail'])->name('admin.project.detail');
        Route::put('project/update', [ProjectController::class, 'update'])->name('admin.project.update');
        Route::get('project/delete', [ProjectController::class, 'delete'])->name('admin.project.delete');
        Route::get('project/deleteImage', [ProjectController::class, 'deleteImage'])->name('admin.project.deleteImage');
        Route::get('project/getDetail-{id}', [ProjectController::class, 'getDetail'])->name('admin.project.getDetail');
        Route::post('project/checkNama',[ProjectController::class, 'checkNama'])->name('admin.project.checkNama');

        Route::get('project/arsip',[ProjectController::class, 'arsip'])->name('admin.project.arsip');
        Route::get('project/arsip/getDataArsip',[ProjectController::class, 'getDataArsip'])->name('admin.project.getDataArsip');
        Route::put('project/arsip/restore',[ProjectController::class, 'restore'])->name('admin.project.restore');
        Route::get('project/arsip/forceDelete',[ProjectController::class, 'forceDelete'])->name('admin.project.forceDelete');

        //Service
        Route::get('service', [ServiceController::class, 'edit'])->name('admin.service');
        Route::put('service/update', [ServiceController::class, 'update'])->name('admin.service.update');
        
        //Kategori Blog
        Route::get('kategori-blog', [KategoriBlogController::class, 'index'])->name('admin.kategori_blog');
        Route::get('kategori-blog/add', [KategoriBlogController::class, 'add'])->name('admin.kategori_blog.add');
        Route::get('kategori-blog/getData', [KategoriBlogController::class, 'getData'])->name('admin.kategori_blog.getData');
        Route::post('kategori-blog/save', [KategoriBlogController::class, 'save'])->name('admin.kategori_blog.save');
        Route::get('kategori-blog/edit/{id}', [KategoriBlogController::class, 'edit'])->name('admin.kategori_blog.edit');
        Route::put('kategori-blog/update', [KategoriBlogController::class, 'update'])->name('admin.kategori_blog.update');
        Route::get('kategori-blog/delete', [KategoriBlogController::class, 'delete'])->name('admin.kategori_blog.delete');
        Route::get('kategori-blog/getDetail-{id}', [KategoriBlogController::class, 'getDetail'])->name('admin.kategori_blog.getDetail');
        Route::post('kategori-blog/checkNama',[KategoriBlogController::class, 'checkNama'])->name('admin.kategori_blog.checkNama');

        Route::get('kategori-blog/arsip',[KategoriBlogController::class, 'arsip'])->name('admin.kategori_blog.arsip');
        Route::get('kategori-blog/arsip/getDataArsip',[KategoriBlogController::class, 'getDataArsip'])->name('admin.kategori_blog.getDataArsip');
        Route::put('kategori-blog/arsip/restore',[KategoriBlogController::class, 'restore'])->name('admin.kategori_blog.restore');
        Route::get('kategori-blog/arsip/forceDelete',[KategoriBlogController::class, 'forceDelete'])->name('admin.kategori_blog.forceDelete');

        //Blog
        Route::get('blog', [BlogController::class, 'index'])->name('admin.blog');
        Route::get('blog/add', [BlogController::class, 'add'])->name('admin.blog.add');
        Route::get('blog/getData', [BlogController::class, 'getData'])->name('admin.blog.getData');
        Route::get('blog/getDataKategori', [BlogController::class, 'getDataKategori'])->name('admin.blog.getDataKategori');
        Route::post('blog/save', [BlogController::class, 'save'])->name('admin.blog.save');
        Route::get('blog/edit/{id}', [BlogController::class, 'edit'])->name('admin.blog.edit');
        Route::get('blog/detail/{slug}', [BlogController::class, 'detail'])->name('admin.blog.detail');
        Route::put('blog/update', [BlogController::class, 'update'])->name('admin.blog.update');
        Route::get('blog/delete', [BlogController::class, 'delete'])->name('admin.blog.delete');
        Route::get('blog/deleteImage', [BlogController::class, 'deleteImage'])->name('admin.blog.deleteImage');
        Route::get('blog/getDetail-{id}', [BlogController::class, 'getDetail'])->name('admin.blog.getDetail');
        Route::post('blog/checkNama',[BlogController::class, 'checkNama'])->name('admin.blog.checkNama');

        Route::get('blog/arsip',[BlogController::class, 'arsip'])->name('admin.blog.arsip');
        Route::get('blog/arsip/getDataArsip',[BlogController::class, 'getDataArsip'])->name('admin.blog.getDataArsip');
        Route::put('blog/arsip/restore',[BlogController::class, 'restore'])->name('admin.blog.restore');
        Route::get('blog/arsip/forceDelete',[BlogController::class, 'forceDelete'])->name('admin.blog.forceDelete');

        //Komentar Blog
        Route::get('komentar-blog', [KomentarBlogController::class, 'index'])->name('admin.komentar_blog');
        Route::get('komentar-blog/getData', [KomentarBlogController::class, 'getData'])->name('admin.komentar_blog.getData');
        Route::get('komentar-blog/delete', [KomentarBlogController::class, 'delete'])->name('admin.komentar_blog.delete');
        Route::get('komentar-blog/detail/{id}', [KomentarBlogController::class, 'detail'])->name('admin.komentar_blog.detail');
        Route::get('komentar-blog/detail/getData/{id}', [KomentarBlogController::class, 'getDataDetail'])->name('admin.komentar_blog.detail.getData');
        Route::get('komentar-blog/detail/delete', [KomentarBlogController::class, 'deleteDetail'])->name('admin.komentar_blog.detail.delete');
        
        //Komentar Project
        Route::get('komentar-project', [KomentarProjectController::class, 'index'])->name('admin.komentar_project');
        Route::get('komentar-project/getData', [KomentarProjectController::class, 'getData'])->name('admin.komentar_project.getData');
        Route::get('komentar-project/delete', [KomentarProjectController::class, 'delete'])->name('admin.komentar_project.delete');
        Route::get('komentar-project/detail/{id}', [KomentarProjectController::class, 'detail'])->name('admin.komentar_project.detail');
        Route::get('komentar-project/detail/getData/{id}', [KomentarProjectController::class, 'getDataDetail'])->name('admin.komentar_project.detail.getData');
        Route::get('komentar-project/detail/delete', [KomentarProjectController::class, 'deleteDetail'])->name('admin.komentar_project.detail.delete');

        //About
        Route::get('about', [AboutController::class, 'index'])->name('admin.about');
        Route::get('about/getDataGallery', [AboutController::class, 'getDataGallery'])->name('admin.about.getDataGallery');
        Route::put('about/update', [AboutController::class, 'update'])->name('admin.about.update');
        
        //Gallery
        Route::get('gallery', [GalleryController::class, 'index'])->name('admin.gallery');
        Route::get('gallery/add', [GalleryController::class, 'add'])->name('admin.gallery.add');
        Route::get('gallery/getGalleryData', [GalleryController::class, 'getGalleryData'])->name('admin.gallery.getGalleryData');
        Route::post('gallery/save', [GalleryController::class, 'save'])->name('admin.gallery.save');
        Route::get('gallery/deleteImage', [GalleryController::class, 'deleteImage'])->name('admin.gallery.deleteImage');

        //Client
        Route::get('client', [ClientController::class, 'index'])->name('admin.client');
        Route::get('client/add', [ClientController::class, 'add'])->name('admin.client.add');
        Route::get('client/getData', [ClientController::class, 'getData'])->name('admin.client.getData');
        Route::post('client/save', [ClientController::class, 'save'])->name('admin.client.save');
        Route::get('client/edit/{id}', [ClientController::class, 'edit'])->name('admin.client.edit');
        Route::put('client/update', [ClientController::class, 'update'])->name('admin.client.update');
        Route::get('client/delete', [ClientController::class, 'delete'])->name('admin.client.delete');
        Route::get('client/deleteImage', [ClientController::class, 'deleteImage'])->name('admin.client.deleteImage');
        Route::get('client/detail/{id}', [ClientController::class, 'detail'])->name('admin.client.detail');
        
        //Banner
        Route::get('banner', [BannerController::class, 'edit'])->name('admin.banner');
        Route::put('banner/update', [BannerController::class, 'update'])->name('admin.banner.update');

        //Contact
        Route::get('contact', [ContactController::class, 'index'])->name('admin.contact');
        Route::put('contact/update', [ContactController::class, 'update'])->name('admin.contact.update');

    });
});
