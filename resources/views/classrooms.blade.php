<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            @if(Session::has('message'))
                <h4>{{ Session::get('message') }}</h4>
            @endif

            @auth
                <p>Bonjour {{ Auth::user()->name }} {{Auth::user()->created_at->diffForHumans()}} {{Auth::user()->created_at->diffInMinutes()}} minutes</p>
            @endauth

            @guest
                <p>Au revoir utilisateur</p>
            @endauth


            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>
                <img src="{{ $a }}">
                <table style="width: 100%; margin-bottom:25px">
                    <tr>
                        <th>Id</th>
                        <th>Tables</th>
                        <th>Computers</th>
                        <th>Title</th>
                        <th>Students</th>
                    </tr>
                    @foreach ($cl as $value)
                    <tr>
                        <td> {{ $value->id }} </td>
                        <td> {{ $value->tables }} </td>
                        <td> {{ $value->computers }} </td>
                        <td> {{ $value->title }} </td>
                        <td> {{ $value->students_count }} </td>
                        @auth
                        <td> <a href="{{ route('handleDeleteClassroom', ['id'=>$value->id]) }}"><button style="color:red">Effacer</button></a> </td>
                        <td> <a href="{{ route('showClassroom', ['id'=>$value->id]) }}"><button style="color:red">Editer</button></a> </td>
                        @endauth
                        <td> <a href="{{ route('showStudents', ['id'=>$value->id]) }}"><button style="color:red">Etudiants</button></a> </td>
                    </tr>
                    @endforeach
                </table>

                @auth
                    <a href="{{ route('handleLogout') }}"><button style="color:green">Logout</button></a>
                @endauth

                @guest
                    <a href="{{ route('handleLogin') }}"><button style="color:green">Login</button></a>
                @endauth
                <div class="links">
                    <a href="https://laravel.com/docs">Docs</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>
    </body>
</html>
