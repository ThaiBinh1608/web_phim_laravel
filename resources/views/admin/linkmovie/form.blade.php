@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Quản lý link phim</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                @if(!isset($linkmovie))
                {!! Form::open(['route'=>'linkmovie.store','method'=>'POST']) !!}
                @else
                {!! Form::open(['route'=>['linkmovie.update',$linkmovie->id],'method'=>'PUT']) !!}
                @endif
                    <div class="form-group my-2 ">
                        {!! Form::label('title', 'Tên', []) !!}
                        {!! Form::text('title', isset($linkmovie) ? $linkmovie->title : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...','required'=>'required']) !!}
                    </div>
                   
                    <div class="form-group my-2 ">
                        {!! Form::label('description', 'Mô tả', []) !!}
                        {!! Form::textarea('description',  isset($linkmovie) ? $linkmovie->description : '', ['style'=>'resize:none','class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...','id'=>'description','required'=>'required']) !!}
                    </div>
                    <div class="form-group my-2 ">
                        {!! Form::label('active', 'Trạng thái', []) !!}
                        {!! Form::select('status',['1'=>'Hiển thị','0'=>"Không hiển thị"],isset($linkmovie) ? $linkmovie->status : '', ['class'=>'form-control','required'=>'required']) !!}
                    </div>
                    @if(!isset($linkmovie))
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
