<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sign in for @yield('role') - X University</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{asset('css/login-single.css')}}"/>
    </head>

    <body>
    <div class="wrapper">
        <div class="center">
            <h1>Sign in</h1>
            <div class="text-center">
                <i>This is the sign in page for <span class="text-capitalize">@yield('role')</span></i>
                @yield('warn')
            </div>
            <form action="{{route('login-handler')}}" method="post">
                @csrf
                <input type="hidden" name="role" value="@yield('role')">
                <div class="txt_field">
                    <input type="text" name="email" required>
                    <span></span>
                    <label>Email</label>
                </div>
                <div class="txt_field">
                    <input type="password" name="password" required>
                    <span></span>
                    <label>Password</label>
                </div>
                <div>
                    <div class="pass">Remember me?
                        <div class="button-switch">
                            <input type="checkbox" id="switch-blue" class="switch" name="remember">
                            <label for="switch-blue" class="lbl-off">No</label>
                            <label for="switch-blue" class="lbl-on">Yes</label>
                        </div>
                    </div>
                </div>
                <input type="submit" value="Login">
            </form>
        </div>
    </div>
    </body>
</html>
