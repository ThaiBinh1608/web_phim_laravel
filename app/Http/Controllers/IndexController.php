<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Movie;
use App\Models\LinkMovie;
use App\Models\Episode;
use App\Models\Movie_Genre;
use App\Models\Movie_Category;
use App\Models\Rating;
use App\Models\Infor;
use DB;

class IndexController extends Controller
{
   public function home(){

      $phim_hot= Movie::where('phim_hot',1)->where('status',1)->orderby('ngaycapnhat','DESC')->get();
      $category_home =  Category::with('movie')->orderby('id','DESC')->where('status',1)->get();
      return view('pages.home',compact('category_home','phim_hot'));
   }  
   public function tim_kiem(){
      if($_GET['search']){
         $search = $_GET['search'];
         $movie = Movie::withCount('episode')->where('title','LIKE','%'.$search.'%')->orderby('ngaycapnhat','DESC')->paginate(12);
         return view('pages.timkiem',compact('search','movie'));
      }else{
        return redirect()->to('/');
      }
   }  
   public function locphim(){
    
      //filter
      $sapxep_get = $_GET['order'];
      $genre_get = $_GET['genre'];
      $country_get = $_GET['country'];
      $year_get = $_GET['year'];
      if($sapxep_get == '' && $genre_get == '' && $country_get == '' && $year_get ==''){
         return redirect()->back();
      }else{
         $sapxep = $_GET['order'];
         $genre = $_GET['genre'];
         $country = $_GET['country'];
         $year = $_GET['year'];
         $movie_array = Movie::withCount('episode');
         // if($genre_get){
         //    $movie_array = $movie_array->where('genre_id','=',$genre_get);
         // }
         if($country_get){
            $movie_array = $movie_array->where('country_id','=',$country_get);
         }if($year_get){
            $movie_array = $movie_array->where('year','=',$year_get);
         }if($sapxep=='name_a_z'){
            $movie_array = $movie_array->orderby('title','ASC');
         }if($sapxep=='date'){
            $movie_array = $movie_array->orderby('ngaycapnhat','DESC');
         }
         $movie_array = $movie_array->with('movie_genre');
         $movie = array();
         foreach($movie_array as $mov){
            foreach($mov->movie_genre as $mov_gen){
               $movie = $movie_array->whereIn('genre_id',[$mov_gen->genre_id]);
            }
         }
         $movie = $movie_array->paginate(12);
     
         return view('pages.locphim',compact('movie','movie_'));
      }
     
   }  
   public function category($slug){
    
      $cate_slug = Category::where('slug',$slug)->first();
      //nhieu danh muc
      $movie_category = Movie_Category::where('category_id',$cate_slug->id)->get();
      $many_category=[];
      foreach ($movie_category as $key =>$movi){
         $many_category[] = $movi->movie_id;
      }
      $movie = Movie::whereIn('id',$many_category)->orderby('ngaycapnhat','DESC')->paginate(12);

      return view('pages.category',compact('cate_slug','movie'));
     }  
     public function year($year){
      $year =  $year;
      $movie = Movie::where('year',$year)->orderby('ngaycapnhat','DESC')->paginate(12);
      return view('pages.year',compact('year','movie'));
     }  
     public function tag($tag){
      $tag =  $tag;
      $movie = Movie::where('tags','LIKE','%'.$tag.'%')->orderby('ngaycapnhat','DESC')->paginate(12);
      return view('pages.tag',compact('tag','movie'));
     }  
     public function genre($slug){
      $gen_slug = Genre::where('slug',$slug)->first();
      //nhieu the loai
      $movie_genre = Movie_Genre::where('genre_id',$gen_slug->id)->get();
      $many_genre=[];
      foreach ($movie_genre as $key =>$movi){
         $many_genre[] = $movi->movie_id;
      }
      $movie = Movie::whereIn('id',$many_genre)->orderby('ngaycapnhat','DESC')->paginate(12);
      return view('pages.genre',compact('gen_slug','movie'));
     }  
     public function country($slug){
      $count_slug = Country::where('slug',$slug)->first();
      $movie = Movie::where('country_id',$count_slug->id)->orderby('ngaycapnhat','DESC')->paginate(12);
      return view('pages.country',compact('count_slug','movie'));
     }  
     public function movie($slug){
      $movie = Movie::with('category','genre','country','movie_genre')->where('slug',$slug)->where('status',1)->first();
      //phim lien quan
      $related = Movie::with('category','genre','country')->where('category_id',$movie->category->id)->orderBy(DB::raw('RAND()'))->whereNotIn('slug',[$slug])->get();
      //tap phim
      $episode_tapdau = Episode::With('movie')->Where('movie_id',$movie->id)->orderBy('episode','ASC')->take(1)->first();
      $episode_current_list = Episode::With('movie')->Where('movie_id',$movie->id)->get();
      $episode_current_list_count = $episode_current_list->count();
      //danh gia
      $rating = Rating::where('movie_id',$movie->id)->avg('rating');
      $rating = round($rating);
      $count_total = Rating::where('movie_id',$movie->id)->count();
      //cong luot xem
      $count_views =  $movie->count_views;
      $count_views=  $count_views+1;
      $movie->count_views =  $count_views;
      $movie->save();

     return view('pages.movie', compact('movie','related','episode_tapdau','episode_current_list_count','rating','count_total'));

  }
      public function add_rating(Request $request){
         $data = $request->all();
         $ip_address= $request->ip();
         $rating_count = Rating::where('movie_id',$data['movie_id'])->where('ip_address',$ip_address)->count();
         if($rating_count>0){
            echo"exist";
         }else{
            $rating = new Rating();
            $rating->movie_id = $data['movie_id'];
            $rating->rating = $data['index'];
            $rating->ip_address = $ip_address;
            $rating->save();
            echo'done';
         }
      }
     public function watch($slug,$tap,$server_active){
      $movie = Movie::with('category','genre','country','movie_genre','movie_category','episode')->where('slug',$slug)->where('status',1)->first();
      $related = Movie::with('category','genre','country')->where('category_id',$movie->category->id)->orderBy(DB::raw('RAND()'))->whereNotIn('slug',[$slug])->get();
      if(isset($tap)){
     
         $tapphim = $tap;
         $tapphim=substr($tap,4,20);
         $episode = Episode::where('movie_id',$movie->id)->where('episode',$tapphim)->first();
       
      }else{
         $tapphim = 1;
         $episode = Episode::where('movie_id',$movie->id)->where('episode',$tapphim)->first();
      }
      
      $server = LinkMovie::orderBy('id','DESC')->get();
      $episode_movie = Episode::where('movie_id',$movie->id)->orderBy('episode','ASC')->get()->unique('server');
      $episode_list = Episode::where('movie_id',$movie->id)->orderBy('episode','ASC')->get();
      return view('pages.watch',compact('movie','episode','tapphim','related','server','episode_movie','episode_list','server_active'));
     }  
     public function episode(){
      return view('pages.episode');
     }  
     
}
