<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    {{-- <style>
        .main {
            height: 100vh;
        }

        .login-box {
            width: 500px;
            padding: 30px;
        }

        form div {
            margin: 15px;
        }
    </style> --}}

    {{-- <div class="main d-flex flex-column justify-content-center align-items-center"> --}}
        {{-- @if (session('status'))
        <div class="alert alert-danger">
            {{ session('message') }}
        </div>
        @endif --}}
        {{-- <div class="login-box">
            <form action="" method="post">
                @csrf
                <div>
                    <label class="form-label" for="username">Username</label>
                    <input class="form-control" type="text" name="username" id="username" required>
                </div>
                <div>
                    <label class="form-label" for="password">Password</label>
                    <input class="form-control" type="password" name="password" id="password" required>
                </div>

                <div>
                    <button class="btn btn-primary form-control" type="submit">Login</button>
                </div>
            </form>
            <a href="/register">register</a>
        </div>
    </div> --}}


    <section class="vh-100">
        <div class="container py-5 h-100">
          <div class="row d-flex align-items-center justify-content-center h-100">
            <div class="col-md-8 col-lg-7 col-xl-6">
              <img src="{{asset ( 'sb-my-admin/img/color.png' )}}"
                class="img-fluid" alt="Phone image">
            </div>
            <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                <form action="" method="post">
                @csrf
                @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

        @endif
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
        @endif
                <h2 class="mb-3">Login</h2>
                <!-- Email input -->
                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="text" id="username" name="username" class="form-control form-control-lg" required/>
                  <label class="form-label" for="form1Example13">Username</label>
                </div>

                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="password" id="password" name="password" class="form-control form-control-lg" required/>
                  <label class="form-label" for="form1Example23">Password</label>
                </div>




                <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block form-control">Sign in</button>
                <div class="d-flex  align-items-center mb-4 mt-3">
                    <b>Belum punya akun?
                    <a href="/register"> Register</a>
                </b>
                  </div>


              </form>
            </div>
          </div>
        </div>
      </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
