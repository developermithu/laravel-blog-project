@extends('layouts.frontend.app')

@section('title', 'Blogger - Laravel 8')


@section('content')
     <!-- start banner Area -->
     <section
     class="banner-area relative"
     id="home"
     data-parallax="scroll"
     data-image-src="{{asset('frontend/img/header-bg.jpg')}}"
   >
     <div class="overlay-bg overlay"></div>
     <div class="container">
       <div class="row fullscreen">
         <div
           class="banner-content d-flex align-items-center col-lg-12 col-md-12"
         >
           <h1>
             Welcome to myiotlab<br />
             <p>
               L<span style="font-size: 0.7em">earn</span> &nbspC<span
                 style="font-size: 0.7em"
                 >reate</span
               >
               &nbspS<span style="font-size: 0.7em">hare</span>
             </p>
           </h1>
         </div>

         <div
           class="head-bottom-meta d-flex justify-content-between align-items-end col-lg-12"
         >
           <div class="col-lg-6 flex-row d-flex meta-left no-padding">
             <a href="/login" class="genric-btn info circle arrow mr-md-auto"
               >Visit Yotube <span class="lnr lnr-arrow-right"></span
             ></a>
           </div>
           <div
             class="col-lg-6 flex-row d-flex meta-right no-padding justify-content-end"
           >
             <div class="user-meta">
               <h4 class="text-white">Mark wiens</h4>
               <p>12 Dec, 2017 11:21 am</p>
             </div>
             <img class="img-fluid user-img" src="{{asset('frontend/img/user.jpg')}}" alt="" />
           </div>
         </div>
       </div>
     </div>
   </section>
   <!-- End banner Area -->

   <!-- Start category Area -->
   <section class="category-area section-gap" id="news">
     <div class="container">
       <div class="row d-flex justify-content-center">
         <div class="menu-content pb-70 col-lg-8">
           <div class="title text-center">
             <h1 class="mb-10">Latest Posts</h1>
             <p class="text-capitalize">Find the Latest Post from all category.</p>
           </div>
         </div>
       </div>
       <div class="active-cat-carusel">

         @foreach ($posts as $post)
         <div class="item single-cat">
          <img src="{{asset('storage/post/' .$post->image)}}" alt="{{$post->slug}}" />
          <p class="date">{{$post->created_at->diffForHumans()}}</p>
          <h4><a href="{{route('post', $post->slug)}}">{{$post->title}}</a></h4>
        </div>
         @endforeach

       </div>
     </div>
   </section>
   <!-- End category Area -->

   <section class="travel-area section-gap" id="travel">
       <div class="container">
           <div class="row d-flex justify-content-center">
               <div class="menu-content pb-70 col-lg-8">
                   <div class="title text-center">
                       <h1 class="mb-10">Hot topics of this Week</h1>
                       <p>The posts which are most views in this week.</p>
                   </div>
               </div>
           </div>
               <div class="container">
               <div class="row justify-content-center">
                    
                @foreach ($posts as $post)
                <div class="single-posts col-lg-4 col-sm-4 mb-3">
                  <img class="img-fluid" src="{{asset('storage/post/' .$post->image)}}" alt="{{$post->slug}}">
                  <div class="date mt-20 mb-20">{{$post->created_at->diffForHumans()}}</div>
                  <div class="detail">
                      <a href="{{route('post', $post->slug)}}"><h4 class="pb-20">{{$post->title}}</h4></a>
                      <p>{!! Str::limit($post->body, 120) !!}</p>
                  </div>
              </div>
                @endforeach

       </div>
   </section>



@endsection