@extends('master')


@section('main-content')
<div class="bg-gray">
    <div class="alignCenter">
        <div class="accountGrid">
            <div class="recentOrders">
                <h3>Recent Orders</h3>
                @if (count($orders) == 0)
                <div class="orderContainer">
                    You haven't ordered anything!
                </div>
                @else
                <div class="orderContainerGrid">
                    @foreach ($orders as $order)
                    <div class="orderContainer">
                        <div class="orderTop">
                            <span>
                                <strong>
                                    Order Placed:
                                </strong>
                                <p></p>
                                {{$order->datePlaced}}
                            </span>
                            <span>
                                <strong>
                                    Total:
                                </strong>
                                <p></p>
                                £{{$order->total}}

                            </span>
                        </div>
                        <hr>
                        <div class="orderItemGrid">
                            @foreach($order->data as $orderItem)
                            <div class="orderItem">
                                <img src="{{asset('images/' . $orderItem['displayImage'])}}">
                                <span>
                                    <div class="orderItemTop">
                                        <span>
                                            {{$orderItem['productName']}}
                                        </span>
                                        <span>
                                            £{{$orderItem['price']}}
                                        </span>
                                    </div>
                                    <p></p>
                                    {{$orderItem['description']}}
                                </span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            <div class="editProfile">
                <h3>Edit Profile</h3>
                <div class="profileBox">
                    <h3>Personal Information</h3>
                    <form action="" method="POST">
                        @csrf()
                        <span>
                            <label for="fullName">Full name:</label>
                            <input type="text" name="fullName" value="{{$userData["fullName"]}}">
                            @foreach ($errors->get('fullName') as $message)
                            <span class="formError">{{$message}}</span>
                            @endforeach
                        </span>
                        <label for="address">Address:</label>
                        <input type="text" name="address" value="{{$userData["address"]}}">
                        @foreach ($errors->get('address') as $message)
                        <span class="formError">{{$message}}</span>
                        @endforeach
                        <div class="splitColumn">
                            <span>
                                <label for="city">City:</label>
                                <input type="text" name="city" value="{{$userData['city']}}">
                                @foreach ($errors->get('city') as $message)
                                <span class="formError">{{$message}}</span>
                                @endforeach
                            </span>
                            <span>
                                <label for="postcode">Postcode:</label>
                                <input type="text" name="postcode" value="{{$userData['postcode']}}">
                                @foreach ($errors->get('postcode') as $message)
                                <span class="formError">{{$message}}</span>
                                @endforeach
                            </span>
                        </div>
                        <h3>Account Information</h3>
                        <label for="emailAddress">Email Address:</label>
                        <input type="text" name="emailAddress" value="{{$userData['emailAddress']}}">
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

                        <input type="submit" value="Update">
                        @if ($errors->count() > 0)
                        <div class="errorBox">
                            There was a problem while submitting. Please check the highlighted fields for
                            errors.
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection
