@extends('layouts.backend.app')

@push('header')
<link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
@endpush

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Post View</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Post</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card m-4">
                    <div class="card-header">

                    <a href="{{route('admin.post.edit', $post->id)}}" class="btn btn-primary"> Edit</a>
                    <button type="button" class="btn btn-danger text-white float-right" data-toggle="modal" data-target="#deleteModal-{{$post->id}}" >Delete</button>
                    </div>

                    <div class="card-body m-2">
                        <div class="post-img mb-3">
                            <img src="{{asset('storage/post/' .$post->image)}}" alt="{{$post->slug}}">
                        </div>
                        <h3>{{$post->title}}</h3>
                        <h6>{{$post->category->name}}</h6> {{--from Post model --}}
                        <p>Created at : {{$post->created_at}}</p>
                        <p>Tag</p>
                        @if ($post->tags)
                            @foreach($post->tags as $tag)
                            <a href="#" class="btn btn-outline-primary btn-sm mx-1">
                                {{$tag->name}} {{-- from tags table --}}
                            </a>
                            @endforeach
                        @endif
                        <hr>
                        <p>{!!$post->body!!}</p> {{-- avoid html tag --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

                   {{-- Delete Model --}}
                   <div class="modal fade" id="deleteModal-{{$post->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><b>Delete Post</b></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure to delete this post?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary py-1" data-dismiss="modal">Cancel</button> &nbsp; 

                            <button type="submit" class="btn btn-danger px-4 py-1"  onclick="event.preventDefault();
                            document.getElementById('deletePost-{{$post->id}}').submit();">Confirm</button>
                            <form id="deletePost-{{$post->id}}" action="{{ route('admin.post.destroy', $post->id) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                        </div>
                    </div>
                    </div>            
                 <!--============ All Model ===========-->

@endsection

@push('footer')
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
        {!! Toastr::message() !!}
<script>
          // Datatable
          $("#example1").DataTable();
</script>
@endpush