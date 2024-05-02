<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="{{route('home')}}">Dashboard</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item ">
        <a class="nav-link" href="{{route('category.create')}}">Danh mục phim</a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="{{route('genre.create')}}">Thể loại</a>
      </li>
    
      <li class="nav-item">
        <a class="nav-link " href="{{route('country.create')}}">Quốc gia</a>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="{{route('movie.index')}}">Phim</a>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="{{route('episode.index')}}">Tập phim</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="{{route('infor.create')}}">Thông tin Website</a>
      </li>
 
      <!-- <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li> -->
    
    </ul>
    {{-- <form class="form-inline my-2 my-lg-0">
      <input class="form-control my-2 mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button  class="btn btn-primary mb-2" type="submit">Tìm kiếm</button>
    </form> --}}
    
  </div>
</nav>