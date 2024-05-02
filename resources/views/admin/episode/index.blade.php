@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        {{-- <div class="col-md-12">
          <a href="{{route('episode.create')}}" class="btn btn-primary">Create Episode</a>
        </div> --}}
        <table class="table table-responsive" id="movieTable"  style="display: block;">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Tên phim</th>
                <th scope="col">Hình ảnh phim</th>
                <th scope="col">Tập phim</th>
                <th scope="col">Link phim</th>
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
                <td> {{substr($episode->linkphim,0,100)}}...</td>
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
@endsection
