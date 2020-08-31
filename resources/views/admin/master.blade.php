<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$pageTitle ?? 'BedSpace'}}</title>
    <link rel="stylesheet" href="{{ url('css\admin.css') }}">
    <link rel="shortcut icon" href="{{ url('logo.png') }}">
    <script src="https://kit.fontawesome.com/3f3847c76f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{url('css\lightbox.css')}}">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="navbar">
        <a href="{{url('/')}}"><img src="{{ url('logo.png') }}" class="siteLogo" alt="BedSpace-Logo" /></a>
        <ul id="navLinks">
            <li>
                <a href="{{url('/admin/products')}}"
                    {{(Request::path() == 'admin/products') ? 'class=active': ''}}>Products</a>
            </li>
            <li>
                <a href="{{url('/admin/categories')}}"
                    {{(Request::path() == 'admin/categories') ? 'class=active': ''}}>Categories</a>
            </li>
            <li>
                <a href="{{url('/admin/pages')}}" {{(Request::path() == 'admin/pages') ? 'class=active': ''}}>Pages</a>
            </li>
            <li>
                <a href="{{url('/admin/orders')}}"
                    {{(Request::path() == 'admin/orders') ? 'class=active': ''}}>Orders</a>
            </li>
            <li>
                <a href="{{url('/')}}" {{(Request::path() == '/') ? 'class=active': ''}}>Back to Site</a>
            </li>
        </ul>
        <div class="navButtons">
            <span>Logged in as: <strong>{{Session::get("username") ?? 'Admin'}}</strong></span>
            <a href='{{url('api/logout')}}'>
                <i class="fas fa-sign-out-alt" {{ Popper::pop('Sign out') }}></i>
            </a>
            <i class="fa fa-bars" id="mobileMenu"></i>
        </div>
    </nav>
    <main>
        <div class="confirmBackground">
            <div class="confirmModal box">
                <h2>Are you sure?</h2>
                <div id="confirmText">
                    Are you sure you want to delete this?
                </div>
                <div class="confirmButtons">
                    <div class="button" id="remove">Yes</div>
                    <div class="button" id="cancel">No</div>
                </div>
            </div>
        </div>
        <div class="bg-gray alignCenter" id="loader">
            <div>
                <img src="{{ asset('images/loading.svg') }}" />
                <p></p>
                Loading...
            </div>
        </div>
        <div style="width: 100%;position: fixed;z-index: 10;">
            <div class="messageModal success">{{Session::get('flash')}}</div>
            <div class="messageModal error"></div>
        </div>
        <div class="container">
            @yield('content')
        </div>
    </main>
    <script>
        const baseURL =  '{{URL::to('/')}}';
    </script>

    <script src="{{ url('js/loader.js') }}"></script>
    <script src="{{ url('js/navbar.js') }}"></script>
    <script src="{{ url('js/cartFunctions.js') }}"></script>
    <script src="{{ url('js/lightbox.js') }}"></script>
    <script src="{{ url('js/generalFunctions.js') }}"></script>
    <script src="{{ url('js/dropzone.js') }}"></script>

    @include('popper::assets')
</body>

</html>
