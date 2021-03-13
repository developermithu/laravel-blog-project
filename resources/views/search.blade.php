@extends('layouts.frontend.app')
@section('title', $search)  {{-- compact('search') must need--}}

<style>
    .pagination a{margin: 0 10px !important; color: blue !important}
    .pagination a:hover{color: #000 !important;}
    .pagination span{color: red !important}
</style>

@section('content')
      <!-- Start top-section Area -->
      <section class="top-section-area section-gap">
        <div class="container">
            <div class="row justify-content-center align-items-center d-flex">
                <div class="col-lg-8">
                    <div id="imaginary_container">

                       {{-- Search Form --}}
                       <form action="{{route('search')}}" method="get">
                        <div class="input-group stylish-input-group">
                            <input type="text" class="form-control"  placeholder="Addictionwhen gambling" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Addictionwhen gambling '" required name="search" value="{{$search}}">
                            <span class="input-group-addon">
                                <button type="submit">
                                    <span class="lnr lnr-magnifier"></span>
                                </button>
                            </span>
                        </div>
                    </form>

                    </div>
                    {{-- compact('search') must need --}}
                    <p class="mt-20 text-center text-white">{{$posts->count() ?? "0"}} results found for “{{$search}}”</p> 
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
                            <i class="fa fa-thumbs-up"></i>
                            <a href="#">{{$post->likedUsers->count()}} Likes</a>
                            <i
                              class="ml-20 fa fa-comment-o"
                              aria-hidden="true"
                            ></i>
                            <a href="#">{{$post->comments->count()}}  Comments</a>
                            <i
                            class="ml-20 fa fa-eye"
                          ></i>
                          <a href="#">{{$post->view_count}}  Views</a>
                          </p>
                        </div>
                      </div>
                    @endforeach
                    </div>

              {{-- Pagination --}}
              <div class=" pagination justify-content-center d-flex my-5">
                {{$posts->appends(Request::all())->links()}}
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