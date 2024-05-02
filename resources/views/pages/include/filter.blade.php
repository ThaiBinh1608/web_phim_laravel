
<form action="{{route('locphim')}}" method="GET">
    {{-- @csrf --}}
    <div class="col-md-3">
          <div class="form-group">
             <select class="form-control" name="order" id="exampleFormControlSelect1">
             <option value="">--Sắp xếp--</option>
             <option value="date">Ngày đăng</option>
             {{-- <option value="year_release">Năm sản xuất</option> --}}
             <option value="name_a_z">Tên phim a-z</option>
             {{-- <option value="watch_views">Lượt xem</option> --}}
             </select>
          </div>
          <input type="submit"  value="Lọc phim" class="btn btn-primary"></input>
    </div>
       <div class="col-md-3">
          <div class="form-group">
             <select class="form-control" name="genre" id="exampleFormControlSelect1">
                <option value="">--Thể loại--</option>
                @foreach($genre_home  as $key => $gen_filter)
                <option {{(isset($_GET['genre']) && $_GET['genre']==$gen_filter->id) ? 'selected':''}} value="{{$gen_filter->id}}">{{$gen_filter->title}}</option>
                @endforeach
             </select>
          </div>
       </div>
       <div class="col-md-3">
          <div class="form-group">
             <select class="form-control" name="country" id="exampleFormControlSelect1">
                <option value="">--Quốc gia--</option>
                @foreach($country_home  as $key => $coun_filter)
                <option {{(isset($_GET['country']) && $_GET['country']==$coun_filter->id) ? 'selected':''}} value="{{$coun_filter->id}}">{{$coun_filter->title}}</option>
                @endforeach
             </select>
          </div>
       </div>
       <div class="col-md-3">
          <div class="form-group">
            @php
                if(isset($_GET['year']))
                  {$year= $_GET['year'];}
                else
                {$year = null;}
              
            @endphp
             {!! Form::selectYear('year',2000,2024,$year,['class'=>'form-control','placeholder'=>'--Năm--'])!!}
          </div>
       
       </div>              

</form>
