<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Main\Index as MainIndex ;
use App\Http\Livewire\Admin\Index as AdminIndex ;
use App\Http\Livewire\Admin\Posts as AdminPosts ;
use App\Http\Livewire\Admin\Comments as AdminComments ;
use App\Http\Livewire\Posts\Index as PostsIndex ;

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


Route::get('/', MainIndex::class)->name('main');
Route::get('/posts/{blog}', PostsIndex::class)->name('post.index');


Route::middleware('auth')->group(function () {
    Route::get('/admin',AdminIndex::class)->name('admin.index')->middleware('AdminUser');
    Route::get('/admin/posts',AdminPosts::class)->name('admin.posts')->middleware('AdminUser');
    Route::get('/admin/comments',AdminComments::class)->name('admin.comments')->middleware('AdminUser');
});