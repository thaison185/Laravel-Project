<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script
            src="https://kit.fontawesome.com/64d58efce2.js"
            crossorigin="anonymous"
        ></script>
        <title>X University - Sign in</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{asset('css/login.css')}}"/>
    </head>

    <body>
        <div class="container">
            <div class="forms-container">
              <div class="signin-signup">
                <form action="{{route('login-handler')}}" method="POST" class="sign-in-form">
                    @csrf
                    <h2 class="title">Sign in</h2>
                    <i>Student</i>
                    @foreach($errors->all() as $message)
                        {{$message}} <br/>
                    @endforeach
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Email" name="email"/>
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Password" name="password"/>
                    </div>
                    <div class="pass">Remember me?
                        <div class="button-switch">
                            <input type="checkbox" id="switch-blue" class="switch" name="remember">
                            <label for="switch-blue" class="lbl-off">No</label>
                            <label for="switch-blue" class="lbl-on">Yes</label>
                        </div>
                    </div>
                    <input type="hidden" name="role" value="student">
                    <input type="submit" value="Login" class="btn solid" />
                </form>

                <form action="{{route('login-handler')}}" method="POST" class="sign-up-form">
                    @csrf
                    <h2 class="title">Sign in</h2>
                    <i>Lecturer</i>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Email" name="email"/>
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Password" name="password"/>
                    </div>
                    <div class="pass">Remember me?
                        <div class="button-switch">
                            <input type="checkbox" id="switch-blue" class="switch" name="remember">
                            <label for="switch-blue" class="lbl-off">No</label>
                            <label for="switch-blue" class="lbl-on">Yes</label>
                        </div>
                    </div>
                    <input type="hidden" name="role" value="lecturer">
                    <input type="submit" value="Login" class="btn solid" />
                </form>
              </div>
            </div>

            <div class="panels-container">
              <div class="panel left-panel">
                <div class="content">
                  <h3>You are Lecturer ?</h3>
                  <p>
                    Click the button below and Sign in with your Lecturer Account
                  </p>
                  <button class="btn transparent" id="sign-up-btn">
                    Sign in as Lecturer
                  </button>
                </div>
                <img src="{{asset('img/log.svg')}}" class="image" alt="" />
              </div>
              <div class="panel right-panel">
                <div class="content">
                  <h3>You are student ?</h3>
                  <p>
                    Click the button below and Sign in with your Student Account
                  </p>
                  <button class="btn transparent" id="sign-in-btn">
                    Sign in as Student
                  </button>
                </div>
                <img src="{{asset('img/register.svg')}}" class="image" alt="" />
              </div>
            </div>
          </div>
          <script src="{{asset('js/login.js')}}"></script>
    </body>
</html>
