<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Movie;
use App\Models\Episode;
use App\Models\Movie_Genre;
use App\Models\Rating;
use App\Models\Infor;
use Carbon\Carbon;
use DB;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $phimhot_sidebar= Movie::where('phim_hot',1)->where('status',1)->orderby('ngaycapnhat','DESC')->take(5)->get();
        $category = Category::orderby('id','DESC')->where('status',1)->get();
        $genre = Genre::orderby('id','DESC')->where('status',1)->get();
        $country = Country::orderby('id','DESC')->where('status',1)->get();
        //thong ke
        $category_total = Category::all()->count();
        $genre_total = Genre::all()->count();
        $country_total = Country::all()->count();
        $movie_total = Movie::all()->count();

        // /tracking user
        // $total_user = DB::table('tracker_sessions')->count();   
        // $total_user_week = DB::table('tracker_sessions')->where('created_at','>=',Carbon::now('Asia/Ho_Chi_Minh')->subDays(7))->count();   
        // $total_user_month = DB::table('tracker_sessions')->where('created_at','>=',Carbon::now('Asia/Ho_Chi_Minh')->subMonth())->count();   
        // $total_user_3month = DB::table('tracker_sessions')->where('created_at','>=',Carbon::now('Asia/Ho_Chi_Minh')->subMonths(3))->count();   
        // $total_user_year = DB::table('tracker_sessions')->where('created_at','>=',Carbon::now('Asia/Ho_Chi_Minh')->subYear())->count();   



        $infor = Infor::find(1);
        View::share([
            'infor' => $infor,
            'phimhot_sidebar' => $phimhot_sidebar,
            'category_home' => $category,
            'genre_home' => $genre,
            'country_home' => $country,
            'category_total' => $category_total,
            'genre_total' => $genre_total,
            'country_total' => $country_total,
            'movie_total' => $movie_total,

            // 'total_user' => $total_user,
            // 'total_user_week' => $total_user_week,
            // 'total_user_month' => $total_user_month,
            // 'total_user_3month' => $total_user_3month,
            // 'total_user_year' => $total_user_year,
        ]);
    }
}
