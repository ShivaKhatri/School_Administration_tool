<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{--title for the page--}}
    <title>School Administration System</title>
    {{--used bootstrap css--}}
    <link href="{!! asset('css/bootstrap.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/bootstrap-grid.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/bootstrap-reboot.css') !!}" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    {{--initial syles given by laravel--}}
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
<body style="display:flex; flex-direction: column;">
<div>
    <h1 class="title" style="text-align: center;">Welcome</h1>
</div>

{{--using flex property in the div  so the contents can be aligned in center of the page.--}}
<div class="flex-center position-ref full-height" style="justify-content: space-around;">
    {{--used card class to use the card type style to represent login of each user--}}
    <div class="card" style="width: 18rem; background-color:#cac8b9;">
        {{--using asset function to point the path to public folder of the project and then giving path from there inside the brackets to access the picture --}}
        <img class="card-img-top" src="{{asset('images/welcomePage/student.svg')}}" alt="Card image cap">
        <div class="card-body" style="display:flex; flex-direction: column;">
            <h5 class="card-title" style="text-align: center;">Student</h5>
            <a href="{{ route('loginStudent') }}" class="btn btn-primary" >Log In</a>
        </div>
    </div>

    <div class="card" style="width: 18rem; background-color:#cac8b9;" >
        {{--using asset function to point the path to public folder of the project and then giving path from there inside the brackets to access the picture --}}
        <img class="card-img-top" src="{{asset('images/welcomePage/family.svg')}}" alt="Card image cap">
        <div class="card-body" style="display:flex; flex-direction: column;">
            <h5 class="card-title" style="text-align: center;">Guardian</h5>
            <a href="{{ route('loginGuardian') }}" class="btn btn-primary" >Log In</a>
        </div>
    </div>

    <div class="card" style="width: 18rem; background-color:#cac8b9;">
        {{--using asset function to point the path to public folder of the project and then giving path from there inside the brackets to access the picture --}}
        <img class="card-img-top" src="{{asset('images/welcomePage/teacher.svg')}}" alt="Card image cap">
        <div class="card-body" style="display:flex; flex-direction: column;">
            <h5 class="card-title" style="text-align: center;">Staff</h5>
            <a href="{{ route('loginStaff') }}" class="btn btn-primary">Log In</a>
        </div>
    </div>

</div>
</body>
{{--scripts of bootstraps--}}
<script src="{!! asset('bower_components/jquery/dist/jquery.min.js')!!}"></script>

<script src="{!! asset('js/bootstrap.bundle.js') !!}"></script>
<script src="{!! asset('js/bootstrap.js') !!}"></script>
</html>
