<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\HomeController;
// admin
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\InforController;
use App\Http\Controllers\LinkMovieController;
use App\Http\Controllers\LeechMovieController;
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

Route::get('/',[IndexController::class, 'home'])->name('homepage');
Route::get('/danh-muc/{slug}',[IndexController::class, 'category'])->name('category');
Route::get('/the-loai/{slug}',[IndexController::class, 'genre'])->name('genre');
Route::get('/quoc-gia/{slug}',[IndexController::class, 'country'])->name('country');

Route::get('/phim/{slug}',[IndexController::class, 'movie'])->name('movie');
Route::get('/xem-phim/{slug}/{tap}/{server_active}',[IndexController::class, 'watch']);
Route::get('/so-tap',[IndexController::class, 'episode'])->name('so-tap');
Route::get('/nam/{year}',[IndexController::class, 'year']);
Route::get('/tag/{tag}',[IndexController::class, 'tag']);
Route::get('/tim-kiem',[IndexController::class, 'tim_kiem'])->name('tim-kiem');
Route::get('/locphim',[ IndexController::class,'locphim'])->name('locphim');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
//admin
Route::resource('category', CategoryController::class);
Route::resource('genre', GenreController::class);
Route::resource('country', CountryController::class);
Route::resource('movie', MovieController::class);
Route::resource('linkmovie', LinkMovieController::class);


Route::resource('episode', EpisodeController::class);
Route::get('select-movie',[ EpisodeController::class,'select_movie'])->name('select-movie');
Route::get('add-episode/{id}',[ EpisodeController::class,'add_episode'])->name('add-episode');
Route::post('/add-rating', [IndexController::class, 'add_rating'])->name('add-rating');

Route::get('/update-year-phim', [MovieController::class, 'update_year']);
Route::get('/update-topview-phim', [MovieController::class, 'update_topview']);
Route::post('/filter-topview-phim', [MovieController::class, 'filter_topview']);
Route::get('/filter-topview-default', [MovieController::class, 'filter_default']);
Route::get('/update-season-phim', [MovieController::class, 'update_season']);
//thong tin web
Route::resource('infor', InforController::class);


//choose ajax admin
Route::get('/category-choose', [MovieController::class, 'category_choose'])->name('category-choose');
Route::get('/country-choose', [MovieController::class, 'country_choose'])->name('country-choose');
Route::get('/trangthai-choose', [MovieController::class, 'trangthai_choose'])->name('trangthai-choose');
Route::post('/update-image-movie-ajax', [MovieController::class, 'update_image_movie_ajax'])->name('update-image-movie-ajax');
//leech movie
Route::get('/leech-movie', [LeechMovieController::class, 'leech_movie'])->name('leech-movie');
Route::get('/leech-detail/{slug}', [LeechMovieController::class, 'leech_detail'])->name('leech-detail');
Route::get('/leech-episode/{slug}', [LeechMovieController::class, 'leech_episode'])->name('leech-episode');
Route::post('/leech-store/{slug}', [LeechMovieController::class, 'leech_store'])->name('leech-store');
Route::post('/leech-episode-store/{slug}', [LeechMovieController::class, 'leech_episode_store'])->name('leech-episode-store');

//
Route::get('/create_sitemap',function(){
    return Artisan::call('sitemap:create');
});