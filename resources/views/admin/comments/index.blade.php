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
                    <h1>Comment List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Comment</li>
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

                    <div class="card-body">
                        <table id="example1" class="table table-bordered text-center">
                            <thead class=" bg-secondary">
                                <tr>
                                    <th>No.</th>
                                    <th>Comment</th>
                                    <th>User Name</th>
                                    <th>Post</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($comments as $key => $comment)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$comment->comment}}</td>
                                    <td>{{$comment->user->name}}</td>
                                    <td><a href="{{route('post', $comment->post->slug)}}">{{$comment->post->title}}</a></td>
                                    <td>{{$comment->created_at->diffForHumans()}}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger text-white" data-toggle="modal" data-target="#deleteModal-{{$comment->id}}" ><i class="fas fa-trash "></i></button>
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
                   @foreach ($comments as $comment)
                   {{-- Delete Model --}}
                   <div class="modal fade" id="deleteModal-{{$comment->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><b>Delete Comment</b></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure to delete this category?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary py-1" data-dismiss="modal">Cancel</button> &nbsp; 

                            <button type="submit" class="btn btn-danger px-4 py-1"  onclick="event.preventDefault();
                            document.getElementById('deleteComment-{{$comment->id}}').submit();">Confirm</button>
                            <form id="deleteComment-{{$comment->id}}" action="{{ route('admin.comment.destroy', $comment->id) }}" method="POST" class="d-none">
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