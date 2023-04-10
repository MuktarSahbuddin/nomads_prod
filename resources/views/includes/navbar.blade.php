  <!-- Navbar -->
  <div class="container">
    <nav class="row navbar navbar-expand-lg navbar-light bg-white">
        <a href="" class="navbar-brand">
            <img src="frontend/images/logo.png" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navb" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        
          <div class="collapse navbar-collapse" id="navb">
            <ul class="navbar-nav ml-auto mr-3">
              <li class="nav-item  mx-md-2">
                <a class="nav-link active" href="#">Home</a>
              </li>
              <li class="nav-item  mx-md-2 ">
                <a class="nav-link" href="#">Paket Travel</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" 
                href="#" role="button" data-toggle="dropdown" id="navbardrop">
                  Service
                </a>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a> 
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </li>
              <li class="nav-item  mx-md-2 ">
                <a class="nav-link" href="#">Testimonial</a>
              </li>
            </ul>
            
         
            @guest
                     <!--  mobile button -->
              <form  class="form-inline d-sm-block d-md-none">
                <button class="btn btn-login my-2 my-sm-0"  type="button"
                onclick="event.preventDefault(); location.href='{{url('login')}}'">
                    Masuk
                </button>
              </form>

              <!-- Dekstop button -->
              <form  class="form-inline my-2 my-lg-0 d-none d-md-block">
                <button class="btn btn-login btn-navbar-right my-2 my-sm-0 px-4" type="button"
                onclick="event.preventDefault(); location.href='{{url('login')}}'">
                    Masuk
                </button>
              </form>
            @endguest

              @auth
                     <!--  mobile button -->
              <form  class="form-inline d-sm-block d-md-none" action="{{url('logout')}}"
               method="POST"> 
               @csrf
                <button class="btn btn-login my-2 my-sm-0"  type="submit">
                    Keluar
                </button>
              </form>

              <!-- Dekstop button -->
              <form  class="form-inline my-2 my-lg-0 d-none d-md-block" action="{{url('logout')}}"
              method="POST">
              @csrf
                <button class="btn btn-login btn-navbar-right my-2 my-sm-0 px-4" type="submit">
                    Keluar
                </button>
              </form>
            @endauth


        </div>
    </nav>
</div>