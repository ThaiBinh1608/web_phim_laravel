@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Quản lý link phim</div>

                <div class="card-body">
              
                </div>
            </div>
        </div>
        <table class="table" id="movieTable"  >
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Slug</th>
                <th scope="col">Description</th>
                <th scope="col">Active</th>
                <th scope="col">Manage</th>
              </tr>
            </thead>
            <tbody class="order_position">
            @foreach ($list as $key =>$linkmovie)
              <tr id="{{$linkmovie->id}}">
                <th scope="row">{{$key}}</th>
                <td>{{$linkmovie->title}}</td>
                <td>{{$linkmovie->description}}</td>
                <td>
                    @if($linkmovie->status)
                        Hiển thị
                    @else
                        Không hiển thị
                    @endif
                </td>
                <td>
                    {!! Form::open(['method'=>'DELETE','route'=>['linkmovie.destroy',$linkmovie->id],'onsubmit'=>'return confirm("Are you sure?")']) !!}
                    {!! Form::submit("Xóa", ['class'=>'btn btn-danger']) !!}
                    {!! Form::close() !!}
                    <a href={{route('linkmovie.edit',$linkmovie->id)}} class="btn btn-warning">Sửa</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
    </div>
</div>
@endsection
