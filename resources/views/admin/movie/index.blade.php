@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
    <div class="col-md-12">
    {{-- <a href="{{route('movie.create')}}" class="btn btn-primary">Create Movie</a> --}}
    <table class="table table-responsive" id="movieTable" style="display: block;">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Tên phim</th>
                <th scope="col"> Phim</th>
                <th scope="col">Số tập</th>
                <th scope="col">Trailer</th>
                <th scope="col">Tags</th>
                <th scope="col">Ảnh bìa</th>
                <th scope="col">Thời lượng</th>
                <th scope="col">Mô tả</th>
                <th scope="col">Slug</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Danh mục</th>
                <th scope="col">Thể loại</th>
                <th scope="col">Quốc gia</th>      
                <th scope="col">Thuộc thể loại</th>
                <th scope="col">Hot</th>     
                <th scope="col">Định dạng</th>     
                <th scope="col">Phụ đề</th>         
                <th scope="col">Ngày tạo</th>     
                <th scope="col">Ngày cập nhật</th>
                <th scope="col">Năm phim</th>
                <th scope="col">Season</th>
                <th scope="col">Lượt xem</th>
                <th scope="col">Top view</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($list as $key =>$cate)
                        <tr>
                            <th scope="row">{{$key}}</th>
                            <td>{{$cate->title}}</td>      
                            <td><a href="{{route('add-episode',$cate->id)}}" class="btn btn-primary btn-sm">Thêm</a></td>   
                            <td>{{$cate->episode_count}}/{{$cate->sotap}}</td>   
                            <td>
                                @if($cate->trailer!=NULL)
                                {{substr($cate->trailer,0,10)}}...
                                @else
                                Chưa có trailer
                                @endif
                            </td>     
                            <td>
                                @if($cate->tags!=NULL)
                                {{substr($cate->tags,0,10)}}...
                                @else
                                Chưa có tags
                                @endif
                            </td>  
                            <td>
                               @php
                                   $image_check=substr($cate->image,0,5);
                               @endphp
                               @if($image_check=='https')
                                <img width="100px" height="100px" src="{{$cate->image}}">
                               @else 
                                <img width="100px" height="100px" src="{{asset('/uploads/movie/'.$cate->image)}}">
                               @endif
                            
                                <input type="file" id="file-{{$cate->id}}" data-movie_id="{{$cate->id}}" class="form-control-file file_image" accept="image/*">
                                <span id="success_image"></span>
                            </td>
                            <td>{{$cate->thoiluongphim}}</td>
                            <td>
                                @if($cate->description!=NULL)
                                {{substr($cate->description,0,10)}}...
                                @else
                                Chưa có mô tả
                                @endif
                            </td>
                            <td>{{$cate->slug}}</td>
                            <td>
                              
                                <select class="trangthai_choose" id="{{$cate->id}}">
                                @if($cate->status==0)
                                <option value="1">Hiển thị</option>
                                <option selected value="0">Không</option>
                                @else
                                <option selected value="1">Hiển thị</option>
                                <option value="0">Không</option>
                                @endif
                                </select>
                            </td>
                            {{-- <td>
                       
                                {!! Form::select('category_id',$category,isset($cate) ? $cate->category->id : '', ['class'=>'form-control category_choose','id'=>$cate->id]) !!}
                            </td> --}}
                            <td>
                                @foreach($cate->movie_category as $catego)
                                <span class="badge badge-primary" style="background-color:blue">{{$catego->title}}</span>
                                @endforeach
                            </td>
                            <td>
                                @foreach($cate->movie_genre as $gen)
                                <span class="badge badge-primary" style="background-color:blue">{{$gen->title}}</span>
                                @endforeach
                            </td>
                        
                            <td>
                                {!! Form::select('country_id',$country,isset($cate) ? $cate->country->id : '', ['class'=>'form-control country_choose','id'=>$cate->id]) !!}
                            </td>

                            <td>@if(@$cate->thuocphim == 'phimle')
                                    Movie
                                @else
                                    Series
                                @endif
                            </td>
                            <td>
                            @if($cate->phim_hot==1)
                                Có
                            @else
                                Không
                            @endif
                            </td>
                        <td>
                            @if($cate->resolution==0)
                            HD
                            @elseif($cate->resolution==1)
                                SD
                            @elseif($cate->resolution==2)
                                Cam
                            @elseif($cate->resolution==3)
                                Full HD
                            @elseif($cate->resolution==4)
                                Trailer
                            @endif
                        </td>
                        <td>
                            @if($cate->phude==0)
                                Vietsub
                            @elseif($cate->resolution==1)
                                Thuyết minh
                            @endif
                        </td>
                        <td>{{$cate->ngaytao}}</td>
                        <td>{{$cate->ngaycapnhat}}</td>
                        <td>
                                {!! Form::selectYear('year',2000,2024,isset($cate->year)? $cate->year :'',['class'=>'select-year','id'=>$cate->id,'placeholder'=>'--Năm phim--'])!!}
                        </td>
                        <td>
                            {!! Form::selectRange('season',0,20,isset($cate->season)? $cate->season :'',['class'=>'select-season','placeholder'=>'--Season--','id'=>$cate->id])!!}
                        </td>
                        <td>{{$cate->count_views}}</td>
                        <td> 
                            {!! Form::select('topview',['0'=>'Ngày','1'=>"Tuần",'2'=>"Tháng"], isset($cate->topview) ? $cate->topview : '', ['class'=>'select-topview','placeholder'=>'--View--','id'=>$cate->id]) !!}
                        </td>
                        
                        <td>
                            {!! Form::open(['method'=>'DELETE','route'=>['movie.destroy',$cate->id],'onsubmit'=>'return confirm("Are you sure?")']) !!}
                            {!! Form::submit("Xóa", ['class'=>'btn btn-danger']) !!}
                            {!! Form::close() !!}
                            <a href={{route('movie.edit',$cate->id)}} class="btn btn-warning">Sửa</a>
                        </td> 
                        </tr>
                        @endforeach
                </tbody>
    </table>
    </div>
    </div>
</div>
@endsection
