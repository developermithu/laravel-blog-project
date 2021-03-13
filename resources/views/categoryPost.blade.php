@extends('layouts.frontend.app')

@section('title', $category->name)

<style>
    .pagination a{margin: 0 10px !important; color: blue !important}
    .pagination a:hover{color: #000 !important;}
    .pagination span{color: red !important}
</style>

@section('content')
    
    <!-- Start top-section Area -->
    <section class="top-section-area section-gap">
        <div class="container">
          <div class="row justify-content-between align-items-center d-flex">
            <div class="col-lg-8 top-left">
              <h1 class="text-white mb-20">All Post</h1>
              <ul>
                <li>
                  <a href="/">Home</a
                  ><span class="lnr lnr-arrow-right"></span>
                </li>
                <li>
                  <a href="{{route('categories')}}">Category</a
                  ><span class="lnr lnr-arrow-right"></span>
                </li>
                <li><a style="color:red">{{$category->name}}</a></li>
              </ul>
            </div>
          </div>
        </div>
      </section>
      <!-- End top-section Area -->
  
      <!-- Start post Area -->
      <div class="post-wrapper pt-100">
        <!-- Start post Area -->
        <section class="post-area">
          <div class="container">
            <div class="row justify-content-center d-flex">
              <div class="col-lg-8">
                <div class="top-posts pt-50">
                  <div class="container">
                    <div class="row justify-content-center">

                @if ($posts->count() > 0)
   
                    @foreach ($posts as $post)
                    <div class="single-posts col-lg-6 col-sm-6">
                        <img class="img-fluid" src="{{asset('storage/post/' .$post->image)}}" alt="{{$post->title}} photo" />
                        <div class="date mt-20 mb-20">
                            {{$post->created_at->diffForHumans()}}
                        </div>
                        <div class="detail">
                          <a href="{{route('post', $post->slug)}}" >
                            <h4 class="pb-20">
                                {{$post->title}}
                            </h4>
                            </a>
                          <p>
                            {!! Str::limit($post->body, 150, '...') !!}
                          </p>
                          <p class="footer pt-20">
                            <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                            <a href="#">{{$post->likedUsers->count()}}  Likes</a>
                            <i
                              class="ml-20 fa fa-comment-o"
                              aria-hidden="true"
                            ></i>
                            <a href="#">{{$post->comments->count()}} Comments</a>
                            <i
                            class="ml-20 fa fa-eye"
                          ></i>
                          <a href="#">{{$post->view_count}}  Views</a>
                          </p>
                        </div>
                      </div>
                    @endforeach

                    @else
                    <h1>No Post Available</h1>

                    @endif
                    </div>

              {{-- Pagination --}}
              <div class=" pagination justify-content-center d-flex my-5">
                {{$posts->links()}}
              </div>

                  </div>
                </div>
              </div>

            <!-- Sidebar -->
            @include('layouts.frontend.partials.sidebar')
            <!-- Sidebar -->

            </div>
          </div>
        </section>
        <!-- End post Area -->
      </div>
      <!-- End post Area -->
@endsection