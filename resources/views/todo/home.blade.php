<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
      <link rel="stylesheet" href="{{ asset('css/home/style.css') }}">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
     <link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap'>
</head>

<body class="bg-light" style="font-family:'Poppins';background: rgb(140,110,255);background: linear-gradient(0deg, rgba(140,110,255,1) 5%, rgba(255,255,255,1) 90%);background-repeat:no-repeat;width:100%;height:auto;">
    <!-- 00. Navbar -->
    		<nav style="width:100%;z-index:999;display:flex;justify-content:center;align-items:center;border-radius:500px 500px 0 0;position:fixed;bottom:0;height:60px;background:white;box-shadow:0 0 5px #8C6EFF;">
  	<i class="bi bi-house d-flex justify-content-center align-items-center text-dark bg-light" style="backdrop-filter:blur(5px);box-shadow:0 0 5px #8C6EFF;border-radius:50%;width:50px;height:50px;" onclick='window.location.href="/"'></i>
    		</nav>

    <div class="container mt-4" style="margin-bottom:100px;">
        <!-- 01. Content-->
        @auth
        <div class="d-block position-relative mb-4 flex-column text-left">
        <h5 class="m-0" style="font-weight:300;">Hallo,</h5>
        <h2 class="" style="color:#8C6EFF;font-weight:800;font-size:2.5em;margin-top:-5px;">{{ Auth::user()->name }}!</h2>
        <button class="btn position-absolute fw-bold btn-danger px-3" style="right:0; top:0;" onclick="window.open('/auth/logout/')"><i class="bi bi-box-arrow-right"></i></button>
        </div>
        @endauth
        @guest
         <div class="d-block mb-4 flex-column text-left">
        <h5 class="m-0" style="font-weight:300;font-size:.9em;">Uups, kamu belum login,</h5>
        <h2 class="" style="color:#8C6EFF;font-weight:800;font-size:2.5em;margin-top:-5px;">Yuk login!</h2>
        <button class="btn fw-bold btn-primary px-4" style="background:#8C6EFF !important;" onclick="window.open('/auth/login/')">Login</button>
        </div>
        @endguest
        <h1 class="text-center mb-4 fw-bold" style="margin-top:50px;">Aktivitas <font style="color:#8C6EFF;">Mu</font></h1>
        <div class="row justify-content-center">
            <div class="col-md-8">
             <div class="card mb-3">
                <div class="card-body">
                      @if (session('success'))
                          <div class="alert alert-success">
                              {{ session('success') }}
                            </div>
                      @endif
                       @if ($errors->any())
                            <div class="alert alert-danger">
                              <ul>  
                                @foreach ($errors->all() as $error)
                                    <li> {{ $error }}
                                    </li>
                                    @endforeach
                              </ul>
                            </div>
                            @endif
                    <!-- 02. Form input data -->
                    <form id="todo-form" style="display: {{ isset($data) ? 'flex' : 'none' }};" action="{{ route('todo.post') }}" method="post">
                        @csrf
                        <div class="input-group mb-3">
                         <input type="text" class="form-control" name="task" id="todo-input" placeholder="Tambah task baru" required>
                            <button class="btn btn-primary" style="background:#8C6EFF !important;" type="submit">
                                Simpan
                            </button>
                        </div>
                    </form> 
                    <!-- 03. Searching -->
                        <form id="todo-form" action="{{ route('todo') }}" method="get">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="search" value="{{ request('search') }}" 
                                    placeholder="masukkan kata kunci">
                                <button class="btn btn-secondary px-4" type="submit">
                                    Cari
                                </button>
                            </div>
                        </form>
                        
                  </div>
                </div>
                <div class="">
                    <div class="card-body">
                        <ul class="list-group mb-4 gap-3" id="todo-list">
                            <!-- 04. Display Data -->
                            @if (isset($newbie))
                            <li class="list-group-item d-flex justify-content-between align-items-center rounded-3 py-3">
                            {{ $newbie }}
                            </li>
                            @endif
                            @if (isset($data) && count($data) > 0)
                            @foreach ($data as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center rounded-3 py-3">
                            <div class="d-flex flex-column">
                            {!! $item->is_done == '1' ? '<del>' : '' !!}    
                              {{ $item->task }}
                            {!! $item->is_done == '1' ? '</del>' : '' !!}    
                             <p class="m-0" style="font-size:.7em;">
                            <font style="color:#8C6EFF;"> {{ $item->is_done == '1' ? 'Sudah' : 'Belum' }} </font> dikerjakan.
                             </p>
                              </div>
                                <input type="text" class="form-control edit-input" style="display: none;"
                                    value="{{ $item->task }}">
                                <div class="btn-group">
                                   <form class="w-100 vh-100 justify-content-center align-items-center position-fixed top-0" id='formDel' style="left:0;display:none;backdrop-filter:blur(4px);z-index:99;" action="{{ url('/'.$item->id) }}" method="POST">
                                       @csrf
                                       @method('delete')
                                       <div class="d-flex flex-column gap-2 bg-light text-center align-items-center justify-content-center rounded-3" style='width:300px;height:400px;'>
                                       <p>Apa kamu yakin untuk menghapus?</p>
                                        <button class="btn btn-warning btn-sm" onclick="document.getElementById('formDel').style.display = 'none'">NO</button>
                                        <button class="btn btn-danger btn-sm delete-btn" type="submit">YES</button>
                                       </div>
                                       </form>
                                           <button class="btn btn-danger btn-sm delete-btn" onclick="document.getElementById('formDel').style.display = 'flex';document.getElementById('formDel').style.flexDirection = 'column';">✕</button>
                                    <button class="btn mx-1 btn-primary btn-sm edit-btn" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-{{ $loop->index }}" aria-expanded="false">✎</button>
                                </div>
                            </li>
                            <!-- 05. Update Data -->
                            <li class="list-group-item collapse" id="collapse-{{ $loop->index }}">
                                <form action="{{ url('/'.$item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="task"
                                                value="{{ $item->task }}">
                                            <button class="btn btn-outline-primary" type="submit">Update</button>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="radio px-2">
                                            <label>
                                                <input type="radio" value="1" name="is_done" {{ $item->is_done == '1' ? 'checked' : '' }}> Selesai
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" value="0" name="is_done" {{ $item->is_done == '0' ? 'checked' : '' }}> Belum
                                            </label>
                                        </div>
                                    </div>
                                </form>
                            </li>
                                    @endforeach
                                    
                        </ul>
                                    {{ $data->links() }}
                                    @endif
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
   
     @include('todo.footer')
    <!-- Bootstrap JS Bundle (popper.js included) -->
   <script href="{{ asset('js/bootstrap.min.js') }}"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>