
@extends('layouts.frontend.app')

@section('title', $post->title)

@push('header')
<link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
@endpush

@section('content')
      <!-- Start top-section Area -->
      <section class="top-section-area section-gap">
        <div class="container">
          <div class="row justify-content-between align-items-center d-flex">
            <div class="col-lg-8 top-left">
              <h1 class="text-white mb-20">Post Details</h1>
              <ul>
                <li>
                  <a href="/">Home</a
                  ><span class="lnr lnr-arrow-right"></span>
                </li>
                <li>
                  <a href="{{route('posts')}}">Posts</a
                  ><span class="lnr lnr-arrow-right"></span>
                </li>
                <li><a style="color: red">{{$post->title}}</a></li>
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
            <div class="row justify-content-center">

              <div class="col-lg-8 single-post">
                <div class="single-page-post">
                  <img class="img-fluid" src="{{asset('storage/post/' .$post->image)}}" alt="{{$post->image}}" />
                  <div class="top-wrapper">
                    <div class="row d-flex justify-content-between">
                      <h2 class="col-lg-8 col-md-12 text-uppercase">
                        {{$post->title}}
                      </h2>
                      <div
                        class="col-lg-4 col-md-12 right-side d-flex justify-content-end"
                      >
                        <div class="desc">
                          <h2>{{$post->user->name}}</h2>
                          {{--post has relation between user--}}
                          <h3>{{$post->created_at->diffForHumans()}}</h3>
                        </div>
                        <div class="user-img">
                          <img src="{{asset('storage/user/' .$post->user->image)}}" alt="{{$post->title}}" width="50px"/>
                        </div>
                      </div>
                    </div>
                  </div>

                  <p> Category: {{$post->category->name}}</p>
                  <div class="tags">
                    <ul>
                      @foreach ($post->tags as $tag)
                      <li><a href="#">{{$tag->name}}</a></li>
                      @endforeach
                    </ul>
                  </div>

                  <div class="single-post-content">
                    <p>
                    {!! $post->body !!}
                    </p>
                  </div>
                  <div class="bottom-wrapper">
                    <div class="row">
                      <div class="col-lg-4 single-b-wrap col-md-12">
                        @guest
                        <i class="fa fa-thumbs-up"></i> {{$post->likedUsers->count()}} people like this
                            @else
                            <a href="javascript:void(0)" onclick="document.getElementById('like-form-{{$post->id}}').submit();"><i class="fa fa-thumbs-up" style="color: {{Auth::user()->likedPosts()->where('post_id', $post->id)->count() > 0 ? 'red' : ""}}"></i></a> {{$post->likedUsers->count()}} people like this
                            <form action="{{route('like.post', $post->id)}}" method="POST" style="display: none" id="like-form-{{$post->id}}">@csrf
                            </form>
                        @endguest
                      </div>
                      <div class="col-lg-4 single-b-wrap col-md-12">
                        <i class="fa fa-eye"></i>
                         {{$post->view_count}}
                        views
                      </div>
                      <div class="col-lg-4 single-b-wrap col-md-12">
                        <i class="fa fa-comment-o"></i>
                         {{$post->comments->count()}}
                        comments
                      </div>

                    </div>      
                    <div class="row my-3">
                      <div class="col-md-6 mt-5">
                        <h3>Share this post with</h3>
                      </div>
                        <div class="col-md-6 mt-5">
                          <ul class="social-icons" id="all-social-links">
                            <li>
                              <a href="#" class="mx-2" id="fb-btn">
                                <i class="fa fa-facebook p-1" style="background: #3b5998;font-size:1.8rem;">
                                </i>
                              </a>
                              <a href="#" class="mx-2" id="tw-btn">
                                <i class="fa fa-twitter p-1" style="background: #1da1f2;font-size:1.8rem;">
                                </i>
                              </a>
                              <a href="#" class="mx-2" id="ln-btn">
                                <i class="fa fa-linkedin p-1" style="background: #0077b5;font-size:1.8rem;">
                                </i>
                              </a>
                              <a href="#" class="mx-2" id="wp-btn">
                                <i class="fa fa-whatsapp p-1" style="background: #25d366;font-size:1.8rem;">
                                </i>
                              </a>
                            </li>
                          </ul>
                      </div>
                      <div class="col-md-6 mt-5">
                        <button id="shareBtn" class="btn btn-primary" style="display: none"><i class="fa fa-share-alt text-white"></i>&nbsp; Share</button>
                      </div>
                    </div>    
                  </div>
  
                  <!-- Start comment-sec Area -->
                  <section class="comment-sec-area pt-80 pb-80">
                    <div class="container">
                      <div class="row flex-column">
                        <h5 class="text-uppercase pb-80">   {{$post->comments->count()}} Comments</h5>
                        <br />
                        <!-- Frist Comment -->
                        <div class="comment">
                          @foreach ($post->comments as $comment)
                          <div class="comment-list">
                            <div
                              class="single-comment justify-content-between d-flex"
                            >
                              <div class="user justify-content-between d-flex">
                                <div class="thumb">
                                  <img src="{{asset('storage/user/' .$comment->user->image)}}" alt="{{$post->title}}" width="50px"/>
                                </div>
                                <div class="desc">
                                  <h5><a href="#">{{$comment->user->name}}</a></h5>
                                  <p class="date">  {{$comment->created_at->diffForHumans()}}</p>
                                  <p class="comment">
                                  {{$comment->comment}}
                                </div>
                              </div>
                              @guest
                              {{-- Don't Show Reply Btn --}}
                                  @else
                                  <div class="">
                                    <button class="btn-reply text-uppercase" id="reply-btn" 
                                      onclick="showReplyForm('{{$comment->id}}','{{$comment->user->name}}')">reply</button
                                    >
                                  </div>
                              @endguest
                            </div>
                          </div>   
                         
                          @if ($comment->replies->count() > 0)
                              @foreach ($comment->replies as $reply)
                              <div class="comment-list left-padding">
                                <div
                                  class="single-comment justify-content-between d-flex"
                                >
                                  <div class="user justify-content-between d-flex">
                                    <div class="thumb">
                                      <img src="{{asset('storage/user/' .$reply->user->image)}}" alt="{{$post->title}}" width="50px"/>
                                    </div>
                                    <div class="desc">
                                      <h5><a href="#">{{$reply->user->name}}</a></h5>
                                      <p class="date">{{$reply->created_at->diffForHumans()}}</p>
                                      <p class="comment">
                                        {{$reply->message}}
                                      </p>
                                    </div>
                                  </div>
                                  <div class="">
                                    <button class="btn-reply text-uppercase" id="reply-btn" 
                                      onclick="showReplyForm('{{$comment->id}}','{{$reply->user->name}}')">reply</button
                                    >
                                  </div>
                                </div>
                              </div>
                              @endforeach
                          @else
                              
                          @endif
                          <div class="comment-list left-padding" id="reply-form-{{$comment->id}}" style="display: none">
                            <div
                              class="single-comment justify-content-between d-flex"
                            >
                              <div class="user justify-content-between d-flex">
                                {{-- <div class="thumb">
                                  <img src="img/asset/c2.jpg" alt="" />
                                </div> --}}
                                <div class="desc">
                                  {{-- <h5><a href="#">Goerge Stepphen</a></h5>
                                  <p class="date">December 4, 2017 at 3:12 pm</p> --}}
                                  <div class="row flex-row d-flex">
                                  <form action="{{route('reply.store', $comment->id)}}" method="POST">
                                    @csrf
                                    <div class="col-lg-12">
                                      <textarea
                                        id="reply-form-{{$comment->id}}-text"
                                        cols="60"
                                        rows="2"
                                        class="form-control mb-10"
                                        name="message"
                                        placeholder="Messege"
                                        onfocus="this.placeholder = ''"
                                        onblur="this.placeholder = 'Messege'"
                                        required=""
                                      ></textarea>
                                    </div>
                                    <button type="submit" class="btn-reply text-uppercase ml-3">Reply</button>
                                  </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          @endforeach
                        </div>

                      </div>
                    </div>
                  </section>
                  <!-- End comment-sec Area -->
  
                  <!-- Start commentform Area -->
                  @guest
                      <div class=" py-5">
                        <h3>Please login to write comment!</h3>
                      </div>
                  @else
                  <section class="commentform-area pb-120 ">
                    <div class="container">
                      {{-- <h5 class="text-uppercas pb-50">00 Comments</h5> --}}
                      <div class="row flex-row d-flex">
                        <div class="col-lg-12">
                        <form action="{{route('comment.store', $post->id)}}" method="post">
                          @csrf
                          <textarea
                          class="form-control mb-10"
                          name="comment"
                          placeholder="Write your comment.."
                          onfocus="this.placeholder = ''"
                          onblur="this.placeholder = 'Write your comment..'"
                          rows="5"
                          required=""
                        ></textarea>
                        <button type="submit" class="primary-btn mt-20" >Comment</button>
                        </form>
                        </div>
                      </div>
                    </div>
                  </section>
                  @endguest
                  <!-- End commentform Area -->
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


@push('footer')
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
        {!! Toastr::message() !!}
<script>
  function showReplyForm(commentId,user) {
  var x = document.getElementById(`reply-form-${commentId}`);
  var input = document.getElementById(`reply-form-${commentId}-text`);

  if (x.style.display === "none") {
    x.style.display = "block";
    input.innerText=`@${user} `;

  } else {
    x.style.display = "none";
  }
}

// Social Login
const fb = document.getElementById('fb-btn');
const ln = document.getElementById('ln-btn');
const tw = document.getElementById('tw-btn');
const wp = document.getElementById('wp-btn');

let postUrl = encodeURI(document.location.href);
let postTitle = encodeURI('{{$post->title}}');

fb.setAttribute("href", `https://www.facebook.com/sharer.php?u=${postUrl}`);
tw.setAttribute("href", `https://twitter.com/share?url=${postUrl}&text=${postTitle}`);
ln.setAttribute("href", `https://www.linkedin.com/shareArticle?url=${postUrl}&title=${postTitle}`);
wp.setAttribute("href", `https://api.whatsapp.com/send?text=${postTitle} ${postUrl}`);

const allLinks = document.getElementById('all-social-links');
const shareBtn = document.getElementById('shareBtn');
if (!navigator.share) {
  shareBtn.style.display = 'block';
  allLinks.style.display = 'none';
  shareBtn.addEventListener('click', function(){
    navigator.share({
      title: postTitle,
      url: postUrl
    }).then((result) => {
      alert('Thank you for sharing')
    }).catch((err) => {
      console.log(err);
    });
  })
}else{

}

</script>
@endpush