@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <table class="table table-responsive" id="" style="display: block;" >
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Link Embed</th>
                <th scope="col">Link M3U8</th>
                <th scope="col">Tên phim</th>
                <th scope="col">Slug</th>
                <th scope="col">Số tập</th>
                <th scope="col">Tập phim</th>
                <th scope="col">Manage</th>
            
              </tr>
            </thead>
            <tbody class="order_position">
            @foreach ($resp['episodes'] as $key =>$res)
              <tr >
                <th scope="row">{{$key}}</th>
                <td>
                    @foreach($res['server_data'] as $key => $server_1)
                        <ul>
                            <li>
                                Tập: {{$server_1['name']}}
                                <input type="text" class="form-control" value="{{$server_1['link_embed']}}">
                            </li>
                          
                        </ul>
                    @endforeach
                </td>
                <td>
                    @foreach($res['server_data'] as $key => $server_2)
                        <ul>
                            <li>
                                Tập: {{$server_2['name']}}
                                <input type="text" class="form-control" value="{{$server_2['link_m3u8']}}">
                            </li>
                          
                        </ul>
                    @endforeach
                </td>
                <td>{{$resp['movie']['name']}}</td>
                <td>{{$resp['movie']['slug']}}</td>
                <td>{{$resp['movie']['episode_total']}}</td>
                <td>
                    <td>{{$res['server_name']}}</td>
                </td>
                <td>
                        <form method="POST" action="{{route('leech-episode-store',$resp['movie']['slug'])}}">
                        @csrf
                        <input type="submit" class="btn btn-success" value="Add episode">
                        </form>
                            {{-- {!! Form::open(['method'=>'DELETE','route'=>['movie.destroy',$movie->id],'onsubmit'=>'return confirm("Are you sure?")']) !!}
                            {!! Form::submit("Xóa", ['class'=>'btn btn-danger']) !!}
                            {!! Form::close() !!} --}}
                </td>
            
              </tr>
              @endforeach
            </tbody>
          </table>
    </div>
</div>
@endsection
