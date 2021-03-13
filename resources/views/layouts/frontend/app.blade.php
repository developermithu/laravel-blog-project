<!DOCTYPE html>
<html lang="zxx" class="no-js">
  <head>

<meta http-equiv="X-UA-Compatible" content="IE=7">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon-->
    <link rel="shortcut icon" href="img/fav.png" />
    <!-- Author Meta -->
    <meta name="author" content="developermithu" />
    <!-- Meta Description -->
    <meta name="description" content="" />
    <!-- Meta Keyword -->
    <meta name="keywords" content="" />
    <!-- meta character set -->
    <meta charset="UTF-8" />
    <!-- Site Title -->
    <title>@yield('title')</title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset('frontend/css/linearicons.css')}}" />
    <link rel="stylesheet" href="{{asset('frontend/css/font-awesome.min.css')}}" />
    <link rel="stylesheet" href="{{asset('frontend/css/bootstrap.css')}}" />
    <link rel="stylesheet" href="{{asset('frontend/css/owl.carousel.css')}}" />
    <link rel="stylesheet" href="{{asset('frontend/css/main.css')}}" />
    <link rel="stylesheet" href="{{asset('frontend/css/theme/pages.css')}}" />
    <style>
      .menu1{
        /* border: 1px solid #333; */
        margin-left: -5rem;
      }
      .c1{
        color: #007bff;
      }
    </style>
    @stack('header')
  </head>
  <body>

    <!-- Header Area -->
    @include('layouts.frontend.partials.header')



   @yield('content')


    <!-- Footer Area -->
    @include('layouts.frontend.partials.footer')

