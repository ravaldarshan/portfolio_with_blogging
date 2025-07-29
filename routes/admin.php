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
use App\Http\Controllers\admin\CategoryBlogController;
use App\Http\Controllers\admin\CommentBlogController;
use App\Http\Controllers\admin\CategoryProjectController;
use App\Http\Controllers\admin\CommentProjectController;
use App\Http\Controllers\admin\TeamController;

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
        Route::get('users/generateCode',[UserController::class, 'generateCode'])->name('admin.users.generateCode');
        Route::post('users/checkEmail',[UserController::class, 'checkEmail'])->name('admin.users.checkEmail');
        Route::post('users/checkCode',[UserController::class, 'checkCode'])->name('admin.users.checkCode');

        Route::get('users/archives',[UserController::class, 'archives'])->name('admin.users.archives');
        Route::get('users/archives/getDataArchives',[UserController::class, 'getDataArchives'])->name('admin.users.getDataArchives');
        Route::put('users/archives/restore',[UserController::class, 'restore'])->name('admin.users.restore');
        Route::get('users/archives/forceDelete',[UserController::class, 'forceDelete'])->name('admin.users.forceDelete');
        
        //Profile
        Route::get('profile/{code}', [ProfileController::class, 'index'])->name('admin.profile');
        Route::get('profile/getData', [ProfileController::class, 'getData'])->name('admin.profile.getData');
        Route::put('profile/update', [ProfileController::class, 'update'])->name('admin.profile.update');
        Route::get('profile/getDetail-{code}', [ProfileController::class, 'getDetail'])->name('admin.profile.getDetail');
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
        Route::get('settings/frontpage/general/deleteSocialMedia', [SettingController::class, 'frontpage_general_deleteSocialMedia'])->name('admin.settings.frontpage.general.deleteSocialMedia');
        
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

        //Category Project
        Route::get('category-project', [CategoryProjectController::class, 'index'])->name('admin.category_project');
        Route::get('category-project/add', [CategoryProjectController::class, 'add'])->name('admin.category_project.add');
        Route::get('category-project/getData', [CategoryProjectController::class, 'getData'])->name('admin.category_project.getData');
        Route::post('category-project/save', [CategoryProjectController::class, 'save'])->name('admin.category_project.save');
        Route::get('category-project/edit/{id}', [CategoryProjectController::class, 'edit'])->name('admin.category_project.edit');
        Route::put('category-project/update', [CategoryProjectController::class, 'update'])->name('admin.category_project.update');
        Route::get('category-project/delete', [CategoryProjectController::class, 'delete'])->name('admin.category_project.delete');
        Route::get('category-project/getDetail-{id}', [CategoryProjectController::class, 'getDetail'])->name('admin.category_project.getDetail');
        Route::post('category-project/checkNama',[CategoryProjectController::class, 'checkNama'])->name('admin.category_project.checkNama');

        Route::get('category-project/archives',[CategoryProjectController::class, 'archives'])->name('admin.category_project.archives');
        Route::get('category-project/archives/getDataArchives',[CategoryProjectController::class, 'getDataArchives'])->name('admin.category_project.getDataArchives');
        Route::put('category-project/archives/restore',[CategoryProjectController::class, 'restore'])->name('admin.category_project.restore');
        Route::get('category-project/archives/forceDelete',[CategoryProjectController::class, 'forceDelete'])->name('admin.category_project.forceDelete');

        //Project
        Route::get('project', [ProjectController::class, 'index'])->name('admin.project');
        Route::get('project/add', [ProjectController::class, 'add'])->name('admin.project.add');
        Route::get('project/getData', [ProjectController::class, 'getData'])->name('admin.project.getData');
        Route::get('project/getDataCategoryProject', [ProjectController::class, 'getDataCategoryProject'])->name('admin.project.getDataCategoryProject');
        Route::post('project/save', [ProjectController::class, 'save'])->name('admin.project.save');
        Route::get('project/edit/{id}', [ProjectController::class, 'edit'])->name('admin.project.edit');
        Route::get('project/detail/{slug}', [ProjectController::class, 'detail'])->name('admin.project.detail');
        Route::put('project/update', [ProjectController::class, 'update'])->name('admin.project.update');
        Route::get('project/delete', [ProjectController::class, 'delete'])->name('admin.project.delete');
        Route::get('project/deleteImage', [ProjectController::class, 'deleteImage'])->name('admin.project.deleteImage');
        Route::get('project/getDetail-{id}', [ProjectController::class, 'getDetail'])->name('admin.project.getDetail');
        Route::post('project/checkNama',[ProjectController::class, 'checkNama'])->name('admin.project.checkNama');

        Route::get('project/archives',[ProjectController::class, 'archives'])->name('admin.project.archives');
        Route::get('project/archives/getDataArchives',[ProjectController::class, 'getDataArchives'])->name('admin.project.getDataArchives');
        Route::put('project/archives/restore',[ProjectController::class, 'restore'])->name('admin.project.restore');
        Route::get('project/archives/forceDelete',[ProjectController::class, 'forceDelete'])->name('admin.project.forceDelete');

        //Service
        Route::get('service', [ServiceController::class, 'edit'])->name('admin.service');
        Route::put('service/update', [ServiceController::class, 'update'])->name('admin.service.update');
        
        //Category Blog
        Route::get('category-blog', [CategoryBlogController::class, 'index'])->name('admin.category_blog');
        Route::get('category-blog/add', [CategoryBlogController::class, 'add'])->name('admin.category_blog.add');
        Route::get('category-blog/getData', [CategoryBlogController::class, 'getData'])->name('admin.category_blog.getData');
        Route::post('category-blog/save', [CategoryBlogController::class, 'save'])->name('admin.category_blog.save');
        Route::get('category-blog/edit/{id}', [CategoryBlogController::class, 'edit'])->name('admin.category_blog.edit');
        Route::put('category-blog/update', [CategoryBlogController::class, 'update'])->name('admin.category_blog.update');
        Route::get('category-blog/delete', [CategoryBlogController::class, 'delete'])->name('admin.category_blog.delete');
        Route::get('category-blog/getDetail-{id}', [CategoryBlogController::class, 'getDetail'])->name('admin.category_blog.getDetail');
        Route::post('category-blog/checkNama',[CategoryBlogController::class, 'checkNama'])->name('admin.category_blog.checkNama');

        Route::get('category-blog/archives',[CategoryBlogController::class, 'archives'])->name('admin.category_blog.archives');
        Route::get('category-blog/archives/getDataArchives',[CategoryBlogController::class, 'getDataArchives'])->name('admin.category_blog.getDataArchives');
        Route::put('category-blog/archives/restore',[CategoryBlogController::class, 'restore'])->name('admin.category_blog.restore');
        Route::get('category-blog/archives/forceDelete',[CategoryBlogController::class, 'forceDelete'])->name('admin.category_blog.forceDelete');

        //Blog
        Route::get('blog', [BlogController::class, 'index'])->name('admin.blog');
        Route::get('blog/add', [BlogController::class, 'add'])->name('admin.blog.add');
        Route::get('blog/getData', [BlogController::class, 'getData'])->name('admin.blog.getData');
        Route::get('blog/getDataCategory', [BlogController::class, 'getDataCategory'])->name('admin.blog.getDataCategory');
        Route::post('blog/save', [BlogController::class, 'save'])->name('admin.blog.save');
        Route::get('blog/edit/{id}', [BlogController::class, 'edit'])->name('admin.blog.edit');
        Route::get('blog/detail/{slug}', [BlogController::class, 'detail'])->name('admin.blog.detail');
        Route::put('blog/update', [BlogController::class, 'update'])->name('admin.blog.update');
        Route::get('blog/delete', [BlogController::class, 'delete'])->name('admin.blog.delete');
        Route::get('blog/deleteImage', [BlogController::class, 'deleteImage'])->name('admin.blog.deleteImage');
        Route::get('blog/getDetail-{id}', [BlogController::class, 'getDetail'])->name('admin.blog.getDetail');
        Route::post('blog/checkNama',[BlogController::class, 'checkNama'])->name('admin.blog.checkNama');

        Route::get('blog/archives',[BlogController::class, 'archives'])->name('admin.blog.archives');
        Route::get('blog/archives/getDataArchives',[BlogController::class, 'getDataArchives'])->name('admin.blog.getDataArchives');
        Route::put('blog/archives/restore',[BlogController::class, 'restore'])->name('admin.blog.restore');
        Route::get('blog/archives/forceDelete',[BlogController::class, 'forceDelete'])->name('admin.blog.forceDelete');

        //Comment Blog
        Route::get('Comment-blog', [CommentBlogController::class, 'index'])->name('admin.blog_comments');
        Route::get('Comment-blog/getData', [CommentBlogController::class, 'getData'])->name('admin.blog_comments.getData');
        Route::get('Comment-blog/delete', [CommentBlogController::class, 'delete'])->name('admin.blog_comments.delete');
        Route::get('Comment-blog/detail/{id}', [CommentBlogController::class, 'detail'])->name('admin.blog_comments.detail');
        Route::get('Comment-blog/detail/getData/{id}', [CommentBlogController::class, 'getDataDetail'])->name('admin.blog_comments.detail.getData');
        Route::get('Comment-blog/detail/delete', [CommentBlogController::class, 'deleteDetail'])->name('admin.blog_comments.detail.delete');
        
        //Comment Project
        Route::get('Comment-project', [CommentProjectController::class, 'index'])->name('admin.comment_project');
        Route::get('Comment-project/getData', [CommentProjectController::class, 'getData'])->name('admin.comment_project.getData');
        Route::get('Comment-project/delete', [CommentProjectController::class, 'delete'])->name('admin.comment_project.delete');
        Route::get('Comment-project/detail/{id}', [CommentProjectController::class, 'detail'])->name('admin.comment_project.detail');
        Route::get('Comment-project/detail/getData/{id}', [CommentProjectController::class, 'getDataDetail'])->name('admin.comment_project.detail.getData');
        Route::get('Comment-project/detail/delete', [CommentProjectController::class, 'deleteDetail'])->name('admin.comment_project.detail.delete');

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

        //Teams
        Route::get('teams', [TeamController::class, 'index'])->name('admin.teams');
        Route::get('teams/getData', [TeamController::class, 'getData'])->name('admin.teams.getData');
        Route::get('teams/add', [TeamController::class, 'add'])->name('admin.teams.add');
        Route::post('teams/save', [TeamController::class, 'save'])->name('admin.teams.save');
        Route::get('teams/edit/{id}', [TeamController::class, 'edit'])->name('admin.teams.edit');
        Route::put('teams/update', [TeamController::class, 'update'])->name('admin.teams.update');
        Route::get('teams/delete', [TeamController::class, 'delete'])->name('admin.teams.delete');
        Route::get('teams/deleteImage', [TeamController::class, 'deleteImage'])->name('admin.teams.deleteImage');
        Route::get('teams/detail/{id}', [TeamController::class, 'detail'])->name('admin.teams.detail');
    });
});

Route::fallback(function () {
    return redirect()->route('admin.dashboard');
});