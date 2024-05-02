<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Episode;
use App\Models\Movie_Genre;
use App\Models\Movie_Category;
use Carbon\Carbon;

use File;
class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Movie::with('category','country','movie_genre','genre')->withCount('episode')->orderBy('id', 'DESC')->get();
        $path = public_path()."/json/";
        $category = Category::pluck('title','id');
        $country = Country::pluck('title','id');
        if(!is_dir($path)){
            mkdir($path,0777,true);
        }
        File::put($path.'movies.json',json_encode($list));
        return view('admin.movie.index',compact('list','category','country'));
    }
    public function category_choose(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->category_id = $data['category_id'];
        $movie->save();
       
    }
    public function country_choose(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->country_id = $data['country_id'];
        $movie->save();
       
    }
    public function trangthai_choose(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->status = $data['trangthai_val'];
        $movie->save();
       
    }
    public function update_image_movie_ajax(Request $request){
        $get_image = $request->file('file');
        $movie_id = $request->movie_id;
        if($get_image){
            $movie =  Movie::find($movie_id);
            unlink('uploads/movie/'.$movie->image);
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image= $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('uploads/movie',$new_image);
            $movie->image = $new_image;
            $movie->save();

        }

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_year(Request $request)
    {
      $data = $request->all();
      $movie = Movie::find($data['id_phim']);
      $movie->year = $data['year'];
      $movie->save();
    }
    public function update_season(Request $request)
    {
      $data = $request->all();
      $movie = Movie::find($data['id_phim']);
      $movie->season = $data['season'];
      $movie->save();
    }
    public function update_topview(Request $request)
    {
      $data = $request->all();
      $movie = Movie::find($data['id_phim']);
      $movie->topview = $data['topview'];
      $movie->save();
    }
    public function filter_topview(Request $request)
    {
      $data = $request->all();
      $movie = Movie::where('topview',$data['value'])->orderBy('ngaycapnhat','DESC')->take(5)->get();
      $output ='';
     foreach($movie as $key => $mov){
            if($mov->resolution==0){
                $text = 'HD';
                                    }
                                    elseif($mov->resolution==1){
                                        $text = 'SD';
                                    }
                                    elseif($mov->resolution==2){
                                        $text = 'Cam';
                                    }
                                    elseif($mov->resolution==3){
                                        $text = 'Full HD';
                                    }
                                    else{
                                        $text = 'Trailer';
                                    }
        $output.='<div class="item">
                            <a href="'.url('phim/'.$mov->slug).'" title="'.$mov->title.'">
                            <div class="item-link">
                                <img src="'.url($mov->image).'" class="lazy post-thumb" alt="'.$mov->title.'" title="'.$mov->title.'" />
                                <span class="is_trailer">'.$text.'</span>
                            </div>
                            <p class="title">'.$mov->title.'</p>
                            </a>
                            <div class="viewsCount" style="color: #9d9d9d;">3.2K lượt xem</div>
                            <div style="float: left;">
                            <ul class="list-inline rating"   title="Average Rating">';
                                for($count=1; $count<=5; $count++){
                                    $output.='<li title="star_rating" 
                                    class="rating" 
                                    style="cursor:pointer; color:#ffcc00; font-size:18px; padding:0;">&#9733;</li>';
                                }
                               
                                $output.='<ul class="list-inline rating"   title="Average Rating">
                            </div>
        </div>';
    }
    
     echo $output;
}
    public function filter_default(Request $request)
    {
      $data = $request->all();
      $movie = Movie::where('topview',0)->orderBy('ngaycapnhat','DESC')->take(5)->get();
      $output ='';
     foreach($movie as $key => $mov){
            if($mov->resolution==0){
                                $text = 'HD';
                            }
                            elseif($mov->resolution==1){
                                $text = 'SD';
                            }
                            elseif($mov->resolution==2){
                                $text = 'Cam';
                            }
                            elseif($mov->resolution==3){
                                $text = 'Full HD';
                            }
                            else{
                                $text = 'Trailer';
                            }

            $output.='<div class="item">
                                    <a href="'.url('phim/'.$mov->slug).'" title="'.$mov->title.'">
                                    <div class="item-link">
                                        <img src="'.url($mov->image).'" class="lazy post-thumb" alt="'.$mov->title.'" title="'.$mov->title.'" />
                                        <span class="is_trailer">'.$text.'</span>
                                    </div>
                                    <p class="title">'.$mov->title.'</p>
                                    </a>
                                    <div class="viewsCount" style="color: #9d9d9d;">3.2K lượt xem</div>
                                    <div style="float: left;">
                                        <ul class="list-inline rating"   title="Average Rating">';
                                            for($count=1; $count<=5; $count++){
                                                $output.='<li title="star_rating" 
                                                class="rating" 
                                                style="cursor:pointer; color:#ffcc00; font-size:18px; padding:0;">&#9733;</li>';
                                            }
                                        
                                            $output.='<ul class="list-inline rating"   title="Average Rating">
                                    </div>
                                </div>';
     }
    
     echo $output;
    }
    public function create()
    {
        $category = Category::pluck('title','id');
        $country = Country::pluck('title','id');
        $genre = Genre::pluck('title','id');
        $list_genre = Genre::all();
        $list_category = Category::all();
         return view('admin.movie.form',compact( 'category', 'genre', 'country','list_genre','list_category'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $movie = new Movie();
        $movie->title = $data['title'];
        $movie->trailer = $data['trailer'];
        $movie->sotap = $data['sotap'];
        $movie->tags = $data['tags'];
        $movie->thoiluongphim = $data['thoiluongphim'];
        $movie->resolution = $data['resolution'];
        $movie->name_eng = $data['name_eng'];
        $movie->phude = $data['phude'];
        $movie->phim_hot = $data['phim_hot'];
        $movie->description =$data['description'];
        $movie->slug =$data['slug'];
        $movie->status =$data['status'];
        // $movie->category_id =$data['category_id'];
        $movie->thuocphim =$data['thuocphim'];
        $movie->country_id =$data['country_id'];
        $movie->count_views = rand(100,9999);
        $movie->ngaytao =Carbon::now('Asia/Ho_Chi_Minh');
        $movie->ngaycapnhat =Carbon::now('Asia/Ho_Chi_Minh');
        foreach($data['genre'] as $key =>$gen)
         {   
            $movie->genre_id =$gen[0];
        }
        foreach($data['category'] as $key =>$cate)
        {   
           $movie->category_id =$cate[0];
       }
        $get_image = $request->file('image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image= $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('uploads/movie/',$new_image);
            $movie->image = $new_image;
        }
        $movie->save();
        //them nhieu the loai
        $movie->movie_genre()->attach($data['genre']);
        $movie->movie_category()->sync($data['category']);
        toastr()->success('Thêm phim thành công');
        return redirect()->route('movie.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::pluck('title','id');
        $country = Country::pluck('title','id');
        $genre = Genre::pluck('title','id');
        $movie = Movie::find($id);
        $list_category = Category::all();
        $list_genre = Genre::all();
        $movie_genre = $movie->movie_genre;
        $movie_category = $movie->movie_category;
        return view('admin.movie.form',compact( 'category', 'genre', 'country','movie','list_genre','movie_genre','list_category','movie_category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $data = $request->all();
        $movie = Movie::find($id);
        $movie->title = $data['title'];
        $movie->trailer = $data['trailer'];
        $movie->sotap = $data['sotap'];
        $movie->tags = $data['tags'];
        $movie->thoiluongphim = $data['thoiluongphim'];
        $movie->resolution = $data['resolution'];
        $movie->name_eng = $data['name_eng'];
        $movie->phude = $data['phude'];
        $movie->phim_hot = $data['phim_hot'];
        $movie->description =$data['description'];
        $movie->slug =$data['slug'];
        $movie->status =$data['status'];
        // $movie->category_id =$data['category_id'];
        $movie->thuocphim =$data['thuocphim'];
        $movie->country_id =$data['country_id'];
        $movie->ngaycapnhat =Carbon::now('Asia/Ho_Chi_Minh');
        foreach($data['genre'] as $key =>$gen)
         {   
            $movie->genre_id =$gen[0];
        }
        foreach($data['category'] as $key =>$cate)
        {   
           $movie->category_id =$cate[0];
       }
        $get_image = $request->file('image');
        if($get_image){
                unlink('uploads/movie/'.$movie->image);
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.',$get_name_image));
                $new_image= $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
                $get_image->move('uploads/movie/',$new_image);
                $movie->image = $new_image;
            // if(file_exists('uploads/movie/'.$movie->image)){
            //     unlink('uploads/movie/'.$movie->image);
            // }else{
            //     $get_name_image = $get_image->getClientOriginalName();
            //     $name_image = current(explode('.',$get_name_image));
            //     $new_image= $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            //     $get_image->move('/uploads/movie',$new_image);
            //     $movie->image = $new_image;
            // }  
        }
       
        $movie->save();
        $movie->movie_genre()->sync($data['genre']);
        $movie->movie_category()->sync($data['category']);
        toastr()->success('Cập nhật thành công');
        return redirect()->route('movie.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $movie = Movie::find($id);
       //xoa anh
       if(file_exists('uploads/movie/'.$movie->image)){
        unlink('uploads/movie/'.$movie->image);
       }
       //xoa the loai
        Movie_Genre::whereIn('movie_id',[$movie->id])->delete();
        //xoa tap phim
        Episode::whereIn('movie_id',[$movie->id])->delete();
        $movie->delete();
       return redirect()->back();
    }
}
