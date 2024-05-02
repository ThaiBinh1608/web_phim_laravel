@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="table-responsive">
            <table class="table " id="movieTable" >
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">Tên phim</th>
                    <th scope="col">Tên chính thức</th>
                    <th scope="col">Nội dung</th>
                    <th scope="col">Loại phim</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Hình ảnh phim</th>
                    <th scope="col">Poster phim</th>
                    <th scope="col">Thời lượng</th>
                    <th scope="col">Số tập hiện tại</th>
                    <th scope="col">Tổng số tập</th>
                    <th scope="col">Độ phân giải</th>
                    <th scope="col">Ngôn ngữ</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Năm</th>
                    <th scope="col">Diễn viên</th>
                    <th scope="col">Đạo diễn</th>
                    <th scope="col">Thể loại</th>
                    <th scope="col">quốc gia</th>
                  </tr>
                </thead>
                <tbody class="order_position">
                @foreach ($resp_movie as $key =>$res)
                  <tr >
                    <th scope="row">{{$key}}</th>
                    <td>{{$res['_id']}}</td>
                    <td>{{$res['name']}}</td>
                    <td>{{$res['origin_name']}}</td>
                    <td>  {{substr($res['content'],0,50)}}...</td>
                    <td>{{$res['type']}}</td>
                    <td>{{$res['status']}}</td>
                    <td><img src="{{$res['thumb_url']}}" alt="" height="80px" width="80px"></td>
                    <td><img src="{{$res['poster_url']}}" alt="" height="80px" width="80px"></td>
                    <td>{{$res['time']}}</td>
                    <td>{{$res['episode_current']}}</td>
                    <td>{{$res['episode_total']}}</td>
                    <td>{{$res['quality']}}</td>
                    <td>{{$res['lang']}}</td>
                    <td>{{$res['slug']}}</td>
                    <td>{{$res['year']}}</td>
                    <td>
                        @foreach ($res['actor'] as $actor)
                        <span class="badge badge-primary" style="background-color:blue">{{$actor}}</span>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($res['director'] as $director)
                        <span class="badge badge-primary" style="background-color:blue">{{$director}}</span>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($res['category'] as $category)
                        <span class="badge badge-primary" style="background-color:blue">{{$category['name']}}</span>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($res['country'] as $country)
                        <span class="badge badge-primary" style="background-color:blue">{{$country['name']}}</span>
                        @endforeach
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
</div>
@endsection
