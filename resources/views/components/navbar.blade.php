<a href="{{url('/')}}"><img src="{{ url('logo.png') }}" class="siteLogo" alt="BedSpace-Logo" /></a>
<ul id="navLinks">
    <li>
        <a href="{{url('/')}}" class="{{Request::is('/') ? 'active': ''}}">Home</a>
    </li>
    <li>
        <a href="{{url('shop/categories')}}" class="{{Request::is('categories') ? 'active': ''}}">Shop</a>
    </li>


    @foreach ($navItems as $nav)
    <li>
        <a href="{{url($nav->navURL)}}" class="{{Request::is($nav->navURL) ? 'active': ''}}">{{$nav->navName}}</a>
    </li>
    @endforeach

    @if(Session::has("isAdmin"))
    <li>
        <a href="{{url('/admin')}}" class="{{Request::is('admin') ? 'active': ''}}">Admin Console</a>
    </li>
    @endif
</ul>
<div class="searchBarContainer">
    <input type="text" class="searchBar" placeholder="Search for a product" oninput="findProduct(this.value)" />
    <i class="fa fa-search"></i>
    <div class="searchResults"></div>
</div>
<div class="navButtons">
    <i class="fa fa-times" id="closeSearch" {{ Popper::pop('Close search bar') }}></i>
    <i class="fa fa-search" id="openSearch" {{ Popper::pop('Open search bar') }}></i>
    @if(!Session::has("user_id"))
    <i class="fa fa-user" id="openLogin" {{Popper::pop('Sign in')}}></i>
    <x-user-login />
    @else
    <a href='{{url('account')}}'>
        <i class="fas fa-user-cog" {{ Popper::pop('My account') }}></i>
    </a>
    <a href='{{url('api/logout')}}'>
        <i class="fas fa-sign-out-alt" {{ Popper::pop('Sign out') }}></i>
    </a>
    @endif
    <span>
        <i class="fa fa-shopping-cart" onclick="openCart()" id="openCart" {{ Popper::pop('Shopping cart') }}></i>
        @if(Session::get("cart")->count()>0)
        {{Session::get("cart")->count()}}
        @endif
    </span>
    <x-shopping-cart />
    <i class="fa fa-bars" id="mobileMenu"></i>
</div>
