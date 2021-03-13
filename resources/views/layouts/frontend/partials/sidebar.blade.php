<div class="col-lg-4 sidebar-area">
    <div class="single_widget search_widget">
      <div id="imaginary_container">

    {{-- Searce Form --}}
    <form action="{{route('search')}}" method="get">
        <div class="input-group stylish-input-group">
            <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Search"
            {{-- value="{{$search}}" --}}
          />
          <span class="input-group-addon">
            <button type="submit">
              <span class="lnr lnr-magnifier"></span>
            </button>
          </span>
        </div>
    </form>

      </div>
    </div>

    {{-- <style>.about_widget{display: none;}</style> --}}
   @if (isset($post))
   <div class="single_widget about_widget">
        <h4 class="text-uppercase pb-20">Content Writter</h4>
        <img src="{{asset('storage/user/' .$post->user->image)}}" alt="{{$post->title}}" width="60%"/>
        <h2 class="text-uppercase">{{$post->user->name}}</h2>
        <p>
        {{$post->user->about}}
        </p>
        <div class="social-link">
        <a href="#"
            ><button class="btn">
            <i class="fa fa-facebook" aria-hidden="true"></i> Like
            </button></a
        >
        <a href="#"
            ><button class="btn">
            <i class="fa fa-twitter" aria-hidden="true"></i> follow
            </button></a
        >
        </div>
  </div>
   @endif
   

    <div class="single_widget cat_widget">
        <h4 class="text-uppercase pb-20">post categories</h4>
        <ul>
            @foreach ($categories as $category)
          <li>
            <a href="{{route('category.post', $category->slug)}}">{{$category->name}}<span>{{$category->posts()->count()}}</span></a>
          </li>
          @endforeach
        </ul>
      </div>

      <div class="single_widget recent_widget">
        <h4 class="text-uppercase pb-20">Recent Posts</h4>
        <div class="active-recent-carusel">

        @foreach ($recentPosts as $recentPost)
        <div class="item">
          <img src="{{asset('storage/post/' .$recentPost->image)}}" alt="{{$recentPost->name}}" />
          <a href="{{route('post', $recentPost->slug)}}" >
          <p class="mt-20 title text-uppercase">
          {{$recentPost->title}}
          </p>
          </a>
          <p>
              {{$recentPost->created_at->diffForHumans()}}
            <span>
              <i class="fa fa-heart-o" aria-hidden="true"></i> 06
              <i class="fa fa-comment-o" aria-hidden="true"></i
              >02</span
            >
          </p>
        </div>
        @endforeach

        </div>
      </div>

    <div class="single_widget tag_widget">
      <h4 class="text-uppercase pb-20">Tag Clouds</h4>
      <ul>
        @foreach ($recentTags->unique('name')->take(10) as $recentTag)
        <li><a href="{{route('tag.post', $recentTag->name)}}">{{$recentTag->name}}</a></li>
        @endforeach
      </ul>
    </div>
  </div>