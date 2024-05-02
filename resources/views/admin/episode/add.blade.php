@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
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
                            {!! Form::label('movie_title','Phim', []) !!}
                            {!! Form::text('movie_title',isset($movie) ? $movie->title : '', ['class'=>'form-control','readonly']) !!}
                            {!! Form::hidden('movie_id', isset($movie) ? $movie->id : '',) !!}
                        </div>
                        <div class="form-group my-2 ">
                            {!! Form::label('link', 'Link phim', []) !!}
                            {!! Form::text('link', isset($episode) ? $episode->linkphim : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...','required'=>'required']) !!}
                        </div>
                        @if(isset($episode))
                            <div class="form-group my-2 ">
                                {!! Form::label('episode', 'Tập phim', []) !!}
                                {!! Form::text('episode', isset($episode) ? $episode->episode : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...','required'=>'required', isset($episode) ? 'readonly' : '']) !!}
                            </div>
                        @else
                        <div class="form-group my-2 ">
                            {!! Form::label('episode', 'Tập phim', []) !!}
                            {!! Form::selectRange('episode',1,$movie->sotap,$movie->sotap,['class'=>'form-control','required'=>'required'])!!}
                        </div>
                        @endif
                        <div class="form-group my-2 ">
                            {!! Form::label('linkserver', 'Link Movie', []) !!}
                            {!! Form::select('linkserver',$linkmovie,'',['class'=>'form-control','required'=>'required']) !!}
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
    <div class="col-md-12">
  
        <table class="table table-responsive" id="movieTable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Tên phim</th>
                <th scope="col">Hình ảnh phim</th>
                <th scope="col">Tập phim</th>
                <th scope="col">Link phim</th>
                <th scope="col">Server phim</th>
                {{-- <th scope="col">Active</th> --}}
                <th scope="col">Manage</th>
              </tr>
            </thead>
            <tbody class="order_position">
            @foreach ($list_episode as $key => $episode)
              
              <tr>
                <th scope="row">{{$key}}</th>
                <td>{{$episode->movie->title}}</td>
                <td><img width="100px" height="100px" src="{{asset('/uploads/movie/'.$episode->movie->image)}}"></td>
                <td>{{$episode->episode}}</td>
                <td>{{$episode->linkphim}}</td>
                <td>
                    @foreach ($listserver as $key => $server_link)
                        @if($episode->server==$server_link->id)
                        {{$server_link->title}}
                        @endif
                    @endforeach
                </td>
                {{-- <td>
                    @if($cate->status)
                        Hiển thị
                    @else
                        Không hiển thị
                    @endif
                </td> --}}
                <td>
                    {!! Form::open(['method'=>'DELETE','route'=>['episode.destroy',$episode->id],'onsubmit'=>'return confirm("Are you sure?")']) !!}
                    {!! Form::submit("Xóa", ['class'=>'btn btn-danger']) !!}
                    {!! Form::close() !!}
                    <a href={{route('episode.edit',$episode->id)}} class="btn btn-warning">Sửa</a>
                </td>
              </tr>
       
              @endforeach
            </tbody>
          </table>
        </div>
    </div>
</div>
@endsection
