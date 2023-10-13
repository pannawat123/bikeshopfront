<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'BikeShop | จําหน่ายอะไหล่จักรยานออนไลน์')</title>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('js/angular.min.js') }}"></script>
</head>
<center>
    <h1> We are BikerMan </h1>

</center>

<body>
    <div class="container">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">BikeShop</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                        <li><a href="{{ URL::to('home') }}">หน้าแรก</a></li> @guest
                        @else
                        <li><a href="{{ URL::to('product') }}">จัดการข้อมูลสินค้า </a></li>
                        <li><a href="#">รายงาน</a></li> @endguest
                        </ul>
                <ul class="nav navbar-nav navbar-right"> @guest
                            <li><a href="{{ route('login') }}">ล็อกอิน</a></li>
                            <li><a href="{{ route('register') }}">ลงทะเบียน</a></li> @else
                            <li><a href="#">{{ Auth::user()->name }} </a></li>
                            <li><a href="{{ route('logout')}}">ออกจากระบบ </a></li> @endguest
                            
                            <li>
                                <a href="{{URL::to('cart/view')}}"> 
                                <i class="fa fa-shopping-cart"> </i> ตะกร้า
                            <span class="label label-danger"> 
                            @if (Session::has('cart_items')) 
                                {!! count(Session::get('cart_items')) !!} </a>
                            @else
                                {{count(array())}}
                            @endif
                        </a>
                    </li>
                    </ul>
                </ul>
               
            </div>


        </nav>
        @yield('content')
        @if (session('msg'))
            @if (session('ok'))
                <script>
                    toastr.success('{{ session('msg') }}');
                </script>
            @else
                <script>
                    toastr.error('{{ session('msg') }}');
                </script>
            @endif
        @endif
    </div>
</body>

</html>
