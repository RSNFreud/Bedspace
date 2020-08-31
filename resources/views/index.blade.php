@extends('master')


@section('main-content')
<div class="bg-gray">
    <div class="alignCenter">
        <div class="mainContent">
            <div class="welcomeMessage">
                <img src="{{asset('images/promoImage.png')}}" alt="Welcome image">
                <div>
                    @if (isset($pageContents))
                    <h3>{{$pageContents->navName}}</h3>
                    <p></p>
                    {!! empty($pageContents->navContent) ? 'No content to display! Add content on the Admin Panel!' :
                    $pageContents->navContent !!}
                    @else
                    <h3>
                        Welcome to BedSpace - Your bedroom is only a few clicks away!
                    </h3>
                    <p></p>
                    Here at BedSpace we aim to provide you the best service that you require, be that a foot massage, a
                    new bed or even a free holiday in the Carribean!
                    <p></p>
                    If you have any questions please feel free to reach out to
                    one of our support staff located in India who will be happy to guide you in how to use a mouse and
                    keyboard.
                    <p></p>
                    Thank you for stopping at BedSpace and we hope you find your dream bedroom furniture!
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
