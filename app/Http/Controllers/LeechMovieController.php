<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Country;
use Carbon\Carbon;
use App\Models\Genre;
use App\Models\Episode;
use App\Models\LinkMovie;
class LeechMovieController extends Controller
{
    public function leech_movie()
    {
        $resp = Http::get("https://ophim1.com/danh-sach/phim-moi-cap-nhat?page=1")->json();
        return view('admin.leech.index',compact('resp'));
    }
    public function leech_detail($slug)
    {
        $resp = Http::get("https://ophim1.com/phim/".$slug)->json();
        $resp_movie[] =  $resp['movie'];
        return view('admin.leech.leech_detail',compact('resp','resp_movie'));
    }
    public function leech_episode($slug)
    {
        $resp = Http::get("https://ophim1.com/phim/".$slug)->json();
        return view('admin.leech.leech_episode',compact('resp'));
    }
    public function leech_episode_store(Request $request,$slug)
    {
        $movie = Movie::where('slug',$slug)->first();
        $resp = Http::get("https://ophim1.com/phim/".$slug)->json();
        foreach ($resp['episodes'] as $key =>$res){
            foreach ($res['server_data'] as $key_data =>$val){
            $episode = new Episode();
            $episode->movie_id = $movie->id;
            $episode->linkphim = '<iframe width="100%" height="315" src="'.$val['link_embed'].'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';
         
            $episode->episode = $val['name'];
            if($key_data){
                $linkmovie = LinkMovie::orderBy('id','DESC')->first();
                $episode->server = $linkmovie->id;
            }else{
                $linkmovie = LinkMovie::orderBy('id','ASC')->first();
                $episode->server = $linkmovie->id;
            }
            $episode->ngaytao = Carbon::now('Asia/Ho_Chi_Minh');
            $episode->ngaycapnhat = Carbon::now('Asia/Ho_Chi_Minh');
            toastr()->success('Tạo mới thành công');
            $episode->save();
            }
        }
        return redirect()->back();
    }
    public function leech_store(Request $request,$slug)
    {
        $resp = Http::get("https://ophim1.com/phim/".$slug)->json();
        $resp_movie[] =  $resp['movie'];
        $movie = new Movie();
        foreach ($resp_movie as $key => $res) {
            $movie->title = $res['name'];
            $movie->trailer = $res['trailer_url'];
            $movie->sotap = $res['episode_total'];
            $movie->tags = $res['name'].','.$res['slug'];
            $movie->thoiluongphim = $res['time'];
            $movie->resolution = 0;
            $movie->name_eng = $res['origin_name'];
            $movie->phude = 0;
            $movie->phim_hot = 1;
            $movie->description =$res['content'];
            $movie->slug =$res['slug'];
            $movie->status =1;

            $category = Category::orderby('id','DESC')->first();
            $movie->category_id =  $category->id;
            $movie->thuocphim ='phimle';
            $country = Country::orderby('id','DESC')->first();
            $movie->country_id = $country->id;
            $genre = Genre::orderby('id','DESC')->first();
            $movie->genre_id = $genre->id;

            $movie->count_views = rand(100,9999);
            $movie->ngaytao =Carbon::now('Asia/Ho_Chi_Minh');
            $movie->ngaycapnhat =Carbon::now('Asia/Ho_Chi_Minh');
            $movie->image =$res['thumb_url'];
            $movie->save();
            $movie->movie_genre()->attach($genre);
            $movie->movie_category()->sync($category);
            toastr()->success('Thêm phim thành công');
        }
        return redirect()->back();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
