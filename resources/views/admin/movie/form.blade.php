@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{-- <div class="col-md-4 my-1"> <a href="{{route('movie.index')}}" class="btn btn-primary">Show Movie</a></div> --}}
            <div class="card">
                <div class="card-header">Quản lý phim</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                @if(!isset($movie))
                {!! Form::open(['route'=>'movie.store','method'=>'POST','enctype'=>'multipart/form-data']) !!}
                @else
                {!! Form::open(['route'=>['movie.update',$movie->id],'method'=>'PUT']) !!}
                @endif
                    <div class="form-group my-2 ">
                        {!! Form::label('title', 'Tên phim', []) !!}
                        {!! Form::text('title', isset($movie) ? $movie->title : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...','id'=>'slug','onkeyup'=>'ChangeToSlug()','required'=>'required']) !!}
                    </div>
                    <div class="form-group my-2 ">
                        {!! Form::label('trailer', 'Trailer', []) !!}
                        {!! Form::text('trailer', isset($movie) ? $movie->trailer : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...']) !!}
                    </div>
                    <div class="form-group my-2 ">
                        {!! Form::label('thoiluongphim', 'Thời lượng phim', []) !!}
                        {!! Form::text('thoiluongphim', isset($movie) ? $movie->thoiluongphim : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...','required'=>'required']) !!}
                    </div>
                    <div class="form-group my-2 ">
                        {!! Form::label('sotap', 'Số tập', []) !!}
                        {!! Form::text('sotap', isset($movie) ? $movie->sotap : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...','required'=>'required']) !!}
                    </div>
                    <div class="form-group my-2 ">
                        {!! Form::label('Tên tiếng anh', 'Tên tiếng anh', []) !!}
                        {!! Form::text('name_eng', isset($movie) ? $movie->name_eng : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...','required'=>'required']) !!}
                    </div>
                    <div class="form-group my-2 ">
                        {!! Form::label('slug', 'Slug', []) !!}
                        {!! Form::text('slug', isset($movie) ? $movie->slug : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...','id'=>'convert_slug','required'=>'required']) !!}
                    </div>
                    <div class="form-group my-2 ">
                        {!! Form::label('description', 'Mô tả', []) !!}
                        {!! Form::textarea('description',  isset($movie) ? $movie->description : '', ['style'=>'resize:none','class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...','id'=>'description','required'=>'required']) !!}
                    </div>
                    <div class="form-group my-2 ">
                        {!! Form::label('tags', 'Tags phim', []) !!}
                        {!! Form::textarea('tags',  isset($movie) ? $movie->tags : '', ['style'=>'resize:none','class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...','required'=>'required']) !!}
                    </div>

                    <div class="form-group my-2 ">
                        {!! Form::label('active', 'Trạng thái', []) !!}
                        {!! Form::select('status',['1'=>'Hiển thị','0'=>"Không hiển thị"],isset($movie) ? $movie->status : '', ['class'=>'form-control','required'=>'required']) !!}
                    </div>
                    <div class="form-group my-2 ">
                        {!! Form::label('Category', 'Danh mục', []) !!}
                        @foreach ($list_category as $key => $cate)
                        @if(isset($movie))
                        {!! Form::checkbox('category[]', $cate->id,isset($movie_category) && $movie_category->contains($cate->id)? true:false) !!}
                        @else
                        {!! Form::checkbox('category[]', $cate->id,'') !!}
                        @endif
                        {!! Form::label('category', $cate->title) !!}
                        @endforeach
                    </div>
                    <div class="form-group my-2 ">
                        {!! Form::label('thuocphim', 'Thuộc thể loại phim', []) !!}
                        {!! Form::select('thuocphim',['phimle'=>'Movie','phimbo'=>"Series"],isset($movie) ? $movie->thuocphim : '', ['class'=>'form-control','required'=>'required']) !!}
                    </div>
                    <div class="form-group my-2 ">
                        {!! Form::label('genre', 'Thể loại', []) !!}
                        @foreach ($list_genre as $key => $gen)
                        @if(isset($movie))
                        {!! Form::checkbox('genre[]', $gen->id,isset($movie_genre) && $movie_genre->contains($gen->id)? true:false) !!}
                        @else
                        {!! Form::checkbox('genre[]', $gen->id,'') !!}
                        @endif
                        {!! Form::label('genre', $gen->title) !!}
                        @endforeach
                    </div>
                    <div class="form-group my-2 ">
                        {!! Form::label('country', 'quốc gia', []) !!}
                        {!! Form::select('country_id',$country,isset($movie) ? $movie->country_id : '', ['class'=>'form-control','required'=>'required']) !!}
                    </div>
                    <div class="form-group my-2 ">
                        {!! Form::label('hot', 'Hot', []) !!}
                        {!! Form::select('phim_hot',['1'=>'Có','0'=>"Không"],isset($movie) ? $movie->phim_hot : '', ['class'=>'form-control','required'=>'required']) !!}
                    </div>
                    <div class="form-group my-2 ">
                        {!! Form::label('resolution', 'Định dạng', []) !!}
                        {!! Form::select('resolution',['0'=>'HD','1'=>"SD","2"=>"Cam","3"=>"Full HD","4"=>"Trailer"],isset($movie) ? $movie->resolution : '', ['class'=>'form-control','required'=>'required']) !!}
                    </div>
                    <div class="form-group my-2 ">
                        {!! Form::label('phude', 'Phụ đề ', []) !!}
                        {!! Form::select('phude',['0'=>'Vietsub','1'=>"Thuyết Minh"],isset($movie) ? $movie->phude : '', ['class'=>'form-control','required'=>'required']) !!}
                    </div>
                    <div class="form-group my-2 ">
                        {!! Form::label('image', 'Image', []) !!}
                        {!! Form::file('image', ['class'=>'form-control-file']) !!}
                        @if(isset($movie))
                        <td><img width="30%" height="30%" src="{{asset('/uploads/movie/'.$movie->image)}}"></td>
                        @endif
                    </div>
                  
                    @if(!isset($movie))
                    {!! Form::submit('Thêm dữ liệu', ['class'=>'btn btn-primary']) !!}
                    @else
                    {!! Form::submit('Cập nhật', ['class'=>'btn btn-primary']) !!}
                    @endif
                
                {!! Form::close() !!}
                </div>
            </div>
        </div>
      
       
    </div>
</div>
@endsection
