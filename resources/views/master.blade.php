<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$pageTitle ?? 'BedSpace'}}</title>
    <link rel="stylesheet" href="{{ url('css\app.css') }}">
    <link rel="shortcut icon" href="{{ url('logo.png') }}">
    <script src="https://kit.fontawesome.com/3f3847c76f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{url('css\lightbox.css')}}">
</head>

<body>
    <!--This is a comment-->
    <nav class="navbar">
        <x-navbar />
    </nav>
    <main>
        <div class="bg-gray alignCenter" id="loader">
            <div>
                <img src="{{ asset('images/loading.svg') }}" />
                <p></p>
                Loading...
            </div>
        </div>
        <div style="overflow: hidden;width: 100%;position: absolute; height:100px;">
            <div class="messageModal success">{{Session::get('flash')}}</div>
            <div class="messageModal error"></div>
        </div>
        @yield('main-content')

    </main>
    <script>
        const baseURL =  '{{URL::to('/')}}';
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="{{ url('js/loader.js') }}"></script>
    <script src="{{ url('js/navbar.js') }}"></script>
    <script src="{{ url('js/cartFunctions.js') }}"></script>
    <script src="{{ url('js/lightbox.js') }}"></script>
    <script src="{{ url('js/generalFunctions.js') }}"></script>



    @include('popper::assets')
</body>

</html>
