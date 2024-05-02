@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <table class="table table-responsive" id="movieTable" style="display: block;" >
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">ID</th>
                <th scope="col">Tên phim</th>
                <th scope="col">Tên chính thức</th>
                <th scope="col">Hình ảnh phim</th>
                <th scope="col">Poster</th>
                <th scope="col">Slug</th>
                <th scope="col">Year</th>
                <th scope="col">Manage</th>
              </tr>
            </thead>
            <tbody class="order_position">
            @foreach ($resp['items'] as $key =>$res)
              <tr >
                <th scope="row">{{$key}}</th>
                <td>{{$res['_id']}}</td>
                <td>{{$res['name']}}</td>
                <td>{{$res['origin_name']}}</td>
                <td><img src="{{$resp['pathImage'].$res['thumb_url']}}" alt="" height="80px" width="80px"></td>
                <td><img src="{{$resp['pathImage'].$res['poster_url']}}" alt="" height="80px" width="80px"></td>
                <td>{{$res['slug']}}</td>
                <td>{{$res['year']}}</td>
                <td>
                  <a href="{{route('leech-detail',$res['slug'])}}" class="btn btn-primary btn-sm">Chi tiết phim</a>
                  <a href="{{route('leech-episode',$res['slug'])}}" class="btn btn-primary btn-sm">Số tập phim</a>
                  @php
                      $movie = \App\Models\Movie::where('slug',$res['slug'])->first();
                  @endphp
                  @if(!$movie)
                  <form method="POST" action="{{route('leech-store',$res['slug'])}}">
                    @csrf
                  <input type="submit" class="btn btn-success btn-sm" value="Thêm phim">
                  </form>
                  @else
                  {!! Form::open(['method'=>'DELETE','route'=>['movie.destroy',$movie->id],'onsubmit'=>'return confirm("Are you sure?")']) !!}
                  {!! Form::submit("Xóa", ['class'=>'btn btn-danger btn-sm']) !!}
                  {!! Form::close() !!}
                  @endif
                </td>
                {{-- <td>
                    {!! Form::open(['method'=>'DELETE','route'=>['category.destroy',$cate->id],'onsubmit'=>'return confirm("Are you sure?")']) !!}
                    {!! Form::submit("Xóa", ['class'=>'btn btn-danger']) !!}
                    {!! Form::close() !!}
                    <a href={{route('category.edit',$cate->id)}} class="btn btn-warning">Sửa</a>
                </td> --}}
              </tr>
              @endforeach
            </tbody>
          </table>
    </div>
</div>
@endsection
