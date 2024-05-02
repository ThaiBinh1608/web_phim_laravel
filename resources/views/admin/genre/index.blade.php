@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Quản lý thể loại</div>

                <div class="card-body">
                </div>
            </div>
        </div>
        <table class="table" id="movieTable"  >
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Tên</th>
                <th scope="col">Mô tả</th>
                <th scope="col">Slug</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Quản lý</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($list as $key =>$cate)
              <tr>
                <th scope="row">{{$key}}</th>
                <td>{{$cate->title}}</td>
                <td>{{$cate->description}}</td>
                <td>{{$cate->slug}}</td>
                <td>
                    @if($cate->status)
                        Hiển thị
                    @else
                        Không hiển thị
                    @endif
                </td>
                <td>
                    {!! Form::open(['method'=>'DELETE','route'=>['genre.destroy',$cate->id],'onsubmit'=>'return confirm("Are you sure?")']) !!}
                    {!! Form::submit("Xóa", ['class'=>'btn btn-danger']) !!}
                    {!! Form::close() !!}
                    <a href={{route('genre.edit',$cate->id)}} class="btn btn-warning">Sửa</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
    </div>
</div>
@endsection
