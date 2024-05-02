@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{-- <div class="col-md-4 my-1"> <a href="{{route('episode.index')}}" class="btn btn-primary">Show Episode</a></div> --}}
            <div class="card">
                <div class="card-header">Quản lý tập phim</div>
                <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                        @if(!isset($episode))
                        {!! Form::open(['route'=>'episode.store','method'=>'POST','enctype'=>'multipart/form-data']) !!}
                        @else
                        {!! Form::open(['route'=>['episode.update',$episode->id],'method'=>'PUT']) !!}
                        @endif
                        <div class="form-group my-2 ">
                            {!! Form::label('movie', 'Chọn phim', []) !!}
                            {!! Form::select('movie_id',['0'=>'Chọn phim','Phim'=>$list_movie],isset($episode) ? $episode->movie_id : '', ['class'=>'form-control select-movie','required'=>'required']) !!}
                        </div>
                        <div class="form-group my-2 ">
                            {!! Form::label('link', 'Link phim', []) !!}
                            {!! Form::text('link', isset($episode) ? $episode->linkphim : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...','required'=>'required']) !!}
                        </div>
                        @if(isset($episode))
                            <div class="form-group my-2 ">
                                {!! Form::label('episode', 'Tập phim', ['required'=>'required']) !!}
                                {!! Form::text('episode', isset($episode) ? $episode->episode : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...', isset($episode) ? 'readonly' : '','required'=>'required']) !!}
                            </div>
                        @else
                        <div class="form-group my-2 ">
                            {!! Form::label('episode', 'Tập phim', ['required'=>'required']) !!}
                            <select name="episode" id="show_movie" class="form-control">
                           
                           </select>
                        </div>
                        @endif
                        <div class="form-group my-2 ">
                            {!! Form::label('linkserver', 'Link Movie', []) !!}
                            {!! Form::select('linkserver',$linkmovie,$episode->server,['class'=>'form-control','required'=>'required']) !!}
                        </div>
                       
                        @if(!isset($episode))
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
