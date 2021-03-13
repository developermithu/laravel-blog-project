<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Post Available</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
</head>
<body>

   <div class="container">
     <div class="row justify-content-center d-flex">
       <div class="col-lg-10 ">
         <div class="top-posts pt-3">
           <div class="container">
             <div class="row justify-content-center">

             <div class="single-posts col-lg-6 col-sm-6 mt-5">
                 <img class="img-fluid" src="{{asset('storage/post/' .$post->image)}}" alt="{{$post->title}} photo" />
                 <div class="date my-3 mb-20">
                     {{$post->created_at->diffForHumans()}}
                     <span class="ml-5"> {{$post->user->name}}</span>
                 </div>
                 <div class="detail">
                   <a href="{{route('post', $post->slug)}}" >
                     <h4 class="pb-2">
                         {{$post->title}}
                     </h4>
                     </a>
                   <p>
                     {!! Str::limit($post->body, 150, '...') !!}
                   </p>
                   <div class="my-3">
                       <a href="{{route('post', $post->slug)}}" class="btn btn-sm btn-info">Read More</a>
                   </div>
                   <p class="footer pt-3">
                     <i class="fa fa-thumbs-up"></i>
                     <a href="#">{{$post->likedUsers->count()}} Likes</a>
                    <i class="fas fa-comment    "></i>
                     <a href="#">{{$post->comments->count()}}  Comments</a>
                     <i
                     class="ml-20 fa fa-eye"
                   ></i>
                   <a href="#">{{$post->view_count}}  Views</a>
                   </p>
                 </div>
               </div>
             </div>

           </div>
         </div>
       </div>

       
     </div>
   </div>

</body>
</html>