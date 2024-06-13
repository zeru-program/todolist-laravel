<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>LOGIN</title>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap'>
  <link rel="stylesheet" href="{{ asset('css/auth/style.css') }}">
  </head>
    <body>
      <!-- partial:index.partial.html -->
      <div class="screen-1">
        <div style="width:100%;justify-content:center;align-items:center;display:flex;">
          <img src="{{ asset('img/login-1.svg') }}" class="logo"></img />
      </div>
      @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
      @endif
      @if (session('cancel'))
      <div class="alert alert-danger">
        {{ session('cancel') }}
      </div>
      @endif
      <form class="screen-1" action="{{ route('login.post') }}" method="POST">
        @csrf
        <div class="email">
          <label for="email">Username</label>
          <div class="sec-2">
            <ion-icon name="mail-outline"></ion-icon>
            <input type="text" name="username" placeholder="Username mu..." />
        </div>
      </div>
      <div class="password">
        <label for="password">Password</label>
        <div class="sec-2">
          <ion-icon name="lock-closed-outline"></ion-icon>
          <input class="pas" type="password" name="password" placeholder="············" />
      </div>
    </div>
    <button class="login">Login </button>
    </form>
    <div class="footer">
    <span style="border-bottom:.5px solid #8C6EFF; padding:5px;" onclick="window.location.href = '/auth/register'">Register</span><span style="border-bottom:.5px solid #8C6EFF; padding:5px;">Forgot Password?</span>
    </div>
    </div>
    <!-- partial -->

  </body>
</html>