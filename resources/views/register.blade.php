@extends('master')


@section('main-content')
<div class="registerBG">
    <img src="{{asset('images/registerImage.png')}}" alt="">
    <form action="" method="POST" novalidate=true autocomplete="false">
        @csrf()
        <div class="registerBox" id="personalInformation">
            <h1>Register</h1>
            <h3>Personal Information</h3>
            <span>
                <label for="fullName">Full name:</label>
                <input type="text" name="fullName" value="{{old('fullName')}}">
                @foreach ($errors->get('fullName') as $message)
                <span class="formError">{{$message}}</span>
                @endforeach
            </span>
            <label for="address">Address:</label>
            <input type="text" name="address" value="{{old('address')}}">
            @foreach ($errors->get('address') as $message)
            <span class="formError">{{$message}}</span>
            @endforeach
            <div class="splitColumn">
                <span>
                    <label for="city">City:</label>
                    <input type="text" name="city" value="{{old('city')}}">
                    @foreach ($errors->get('city') as $message)
                    <span class="formError">{{$message}}</span>
                    @endforeach
                </span>
                <span>
                    <label for="postcode">Postcode:</label>
                    <input type="text" name="postcode" value="{{old('postcode')}}">
                    @foreach ($errors->get('postcode') as $message)
                    <span class="formError">{{$message}}</span>
                    @endforeach
                </span>
            </div>
            <input type="button" value="Next" onclick="showAccountInformation()">

            @if ($errors->count() > 0)
            <div class="errorBox">
                There was a problem while submitting. Please check the highlighted fields for errors.
            </div>
            @endif
        </div>
        <div class="registerBox" id="accountInformation">
            <h1>Register</h1>
            <h3>Account Information</h3>
            <label for="emailAddress">Email Address:</label>
            <input type="text" name="emailAddress" value="{{old('emailAddress')}}">
            @foreach ($errors->get('emailAddress') as $message)
            <span class="formError">{{$message}}</span>
            @endforeach
            <label for="password">Password:</label>
            <input type="password" name="password">
            @foreach ($errors->get('password') as $message)
            <span class="formError">{{$message}}</span>
            @endforeach
            <label for="confirmPassword">Confirm password:</label>
            <input type="password" name="confirmPassword">
            @foreach ($errors->get('confirmPassword') as $message)
            <span class="formError">{{$message}}</span>
            @endforeach
            <br>
            <input type="button" value="Previous" onclick="showPersonalInformation()" class="previousButton">
            <input type="submit" value="Register">
            @if ($errors->count() > 0)
            <div class="errorBox">
                There was a problem while submitting. Please check the highlighted fields for errors.
            </div>
            @endif
        </div>
    </form>
</div>

<script>
    function showAccountInformation() {
        $('#accountInformation').css({'left': '0'});
        $('#personalInformation').css({'right': '100vw'});
    }
    function showPersonalInformation() {
        $('#accountInformation').css({'left': '100vw'});
        $('#personalInformation').css({'right': '0'});
    }
</script>
@endsection
