@extends('layouts.backend.app')

@push('header')
<link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
@endpush

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Post List</h1>
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
                <div class="card">
                    <div class="card-header">

                    <a href="{{route('admin.post.create')}}" class="btn btn-secondary">Add New Post</a>
                    </div>

                    <div class="card-body">
                        <table id="example1" class="table table-bordered text-center">
                            <thead class=" bg-secondary">
                                <tr>
                                    <th >No.</th>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th> Category</th>
                                    <th>Body</th>
                                    <th>Liked & View</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posts as $key => $post)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{!!Str::limit($post->title, 20)!!}</td>
                                    <td><a href="{{asset('storage/post/'. $post->image)}}" target="_blank">
                                        <img src="{{asset('storage/post/'. $post->image)}}" alt="{{$post->slug}}" width="60px">
                                    </a></td>
                                    <td>{{$post->category->name}}</td>
                                    <td>{!! Str::limit($post->body, 20) !!}</td> 
                                    <td>
                                        <a href="{{route('admin.post.like.user', $post->id)}}" class="btn btn-sm btn-danger text-white" ><i class="fas fa-thumbs-up "></i> {{$post->likedUsers->count()}}</a>
                                        <a href="{{route('admin.post.show', $post->id)}}" class="btn btn-sm btn-info text-white" ><i class="fas fa-eye "></i> {{$post->view_count}}</a>
                                    </td>
                                    <td>{{$post->created_at->diffForHumans()}}</td>
                                    <td>
                                        <a href="{{route('admin.post.show', $post->id)}}" class="btn btn-sm btn-secondary text-white" ><i class="fas fa-eye "></i></a> &nbsp;

                                        <a href="{{route('admin.post.edit', $post->id)}}" class="btn btn-sm btn-info text-white" ><i class="fas fa-edit "></i></a> &nbsp;

                                        <button type="button" class="btn btn-sm btn-danger text-white" data-toggle="modal" data-target="#deleteModal-{{$post->id}}" ><i class="fas fa-trash "></i></button>
                                </tr>
                                @endforeach     
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

                    <!--=========== All Model ========-->
                   @foreach ($posts as $post)
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
                   @endforeach
                 <!--============ All Model ===========-->

@endsection

@push('footer')
<script src="{{asset('backend/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables/dataTables.bootstrap4.js')}}"></script>
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
        {!! Toastr::message() !!}
<script>
          // Datatable
          $("#example1").DataTable();
</script>
@endpush