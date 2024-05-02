@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Quản lý danh mục</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
               
                {!! Form::open(['route'=>['infor.update',$infor->id],'method'=>'PUT','enctype'=>'multipart/form-data']) !!}
            
                    <div class="form-group my-2 ">
                        {!! Form::label('title', 'Tên', []) !!}
                        {!! Form::text('title', isset($infor) ? $infor->title : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...','required'=>'required']) !!}
                    </div>
                    <div class="form-group my-2 ">
                        {!! Form::label('description', 'Mô tả', []) !!}
                        {!! Form::textarea('description',  isset($infor) ? $infor->description : '', ['style'=>'resize:none','class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...','id'=>'description','required'=>'required']) !!}
                    </div>
                    <div class="form-group my-2 ">
                        {!! Form::label('image', 'Image', []) !!}
                        {!! Form::file('image', ['class'=>'form-control-file']) !!}
                        @if(isset($infor))
                        <td><img width="30%" height="30%" src="{{asset('/uploads/logo/'.$infor->logo)}}"></td>
                        @endif
                    </div>
                    {!! Form::submit('Cập nhật', ['class'=>'btn btn-primary']) !!}
                
                {!! Form::close() !!}
                </div>
            </div>
        </div>
        {{-- <table class="table" id="movieTable">
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
            @foreach ($list as $key =>$cate)
              <tr id="{{$cate->id}}">
                <th scope="row">{{$key}}</th>
                <td>{{$cate->title}}</td>
                <td>{{$cate->slug}}</td>
                <td>{{$cate->description}}</td>
                <td>
                    @if($cate->status)
                        Hiển thị
                    @else
                        Không hiển thị
                    @endif
                </td>
                <td>
                    {!! Form::open(['method'=>'DELETE','route'=>['infor.destroy',$cate->id],'onsubmit'=>'return confirm("Are you sure?")']) !!}
                    {!! Form::submit("Xóa", ['class'=>'btn btn-danger']) !!}
                    {!! Form::close() !!}
                    <a href={{route('infor.edit',$cate->id)}} class="btn btn-warning">Sửa</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table> --}}
    </div>
</div>
@endsection
