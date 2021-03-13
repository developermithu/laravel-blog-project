@extends('layouts.frontend.app')
@section('title', 'Blogger all category')

@section('content')
<section class="generic-banner relative">
<div class="container">
    <div class="row height align-items-center justify-content-center">
      <div class="col-lg-10">
        <div class="generic-banner-content">
          <h2 class="text-white text-center">The Category Page</h2>
          <p class="text-white">
            This page shows all the categories that available by the site
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

  <!-- About Generic Start -->
  <div class="main-wrapper">
    <!-- Start fashion Area -->
    <section class="fashion-area section-gap" id="fashion">
      <div class="container">
        <div class="row">

         @foreach ($categories as $category)
         <div class="col-lg-3 col-md-6 single-fashion">
            <img class="img-fluid" src="{{asset('storage/category/' .$category->image)}}" alt="" />
            <p class="date">{{$category->created_at->format('d M Y')}}</p>
            <h4><a href="{{route('category.post', $category->slug)}}">{{$category->name}}</a></h4>
            <p>{{$category->description}}</p>
            {{-- <div class="meta-bottom d-flex justify-content-between">
              <p><span class="lnr lnr-heart"></span> 15 Likes</p>
              <p><span class="lnr lnr-bubble"></span> 02 Comments</p>
            </div> --}}
          </div>
         @endforeach

        </div>
      </div>
    </section>
    <!-- End fashion Area -->
@endsection