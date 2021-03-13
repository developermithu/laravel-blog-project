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
                    <h1>Category List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Category</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close text-white" data-dismiss="alert" aria-label="Close">
                            <span>&times;</span>
                        </button>
                        <strong>Error!</strong> {{$error}}
                    </div>
                    @endforeach
                @endif 
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">

                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#createModal" >Add New Category</button>
                    </div>
                    
<!-- Model Form -->
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('admin.category.store')}}" method="POST" enctype="multipart/form-data" id="createCategory">
                            @csrf
                            <div class="form-inline row mb-3">
                                <label class="col-form-label col-sm-2 mr-5">Name</label>
                              <input type="text" name="name" class="form-control col-sm-8" placeholder="Category name.." required>
                            </div>
                            <div class="form-inline row mb-3">
                                <label class="col-form-label col-sm-2 mr-5">Image</label>
                              <input type="file" name="image" class="form-control col-sm-8">
                            </div>
                            <div class="form-inline row mb-3">
                                <label class="col-form-label col-sm-2 mr-5">Description</label>
                              <textarea name="description" class="form-control col-sm-8" rows="5" required></textarea>
                            </div>

                              <div class="modal-footer pb-0">
                                <button type="button" class="btn btn-secondary py-1" data-dismiss="modal">Close</button> &nbsp; 

                                <button type="submit" class="btn btn-primary px-4 py-1"  onclick="event.preventDefault();
                                document.getElementById('createCategory').submit();">Submit</button>
                            </div>
                            </form>

                    </div>
                    </div>
                </div>
                </div>
<!-- Model Form -->

                    <div class="card-body">
                        <table id="example1" class="table table-bordered text-center">
                            <thead class=" bg-secondary">
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Slug</th>
                                    <th>Description</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $key => $category)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$category->name}}</td>
                                    <td><a href="{{asset('storage/category/'. $category->image)}}" target="_blank">
                                        <img src="{{asset('storage/category/'. $category->image)}}" alt="{{$category->name}}" width="60px">
                                    </a></td>
                                    <td>{{$category->slug}}</td>
                                    <td>{{$category->description}}</td>
                                    <td>{{$category->created_at}}</td>
                                    <td>{{$category->updated_at}}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info text-white" data-toggle="modal" data-target="#editModal-{{$category->id}}" ><i class="fas fa-edit "></i></button> &nbsp;

                                        <button type="button" class="btn btn-sm btn-danger text-white" data-toggle="modal" data-target="#deleteModal-{{$category->id}}" ><i class="fas fa-trash "></i></button>
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
                   @foreach ($categories as $category)
                   {{-- Delete Model --}}
                   <div class="modal fade" id="deleteModal-{{$category->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><b>Delete Category</b></h5>
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
                            document.getElementById('deleteCategory-{{$category->id}}').submit();">Confirm</button>
                            <form id="deleteCategory-{{$category->id}}" action="{{ route('admin.category.destroy', $category->id) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                        </div>
                    </div>
                    </div>

                  {{-- Update Model --}}
                   <div class="modal fade" id="editModal-{{$category->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><b>Update Category</b></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('admin.category.update', $category->id)}}" method="POST" enctype="multipart/form-data" id="editCategory-{{$category->id}}">
                                @csrf
                                @method('PUT')
                                <div class="form-inline row mb-3">
                                    <label class="col-form-label col-sm-2 mr-5">Image</label>
                                  <input type="file" name="image" class="form-control col-sm-4">
                                  <div class="col-sm-4 ml-4">
                                      <img src="{{asset('storage/category/'.$category->image)}}" width="50%">
                                    </div>
                                </div>
                                <div class="form-inline row mb-3">
                                    <label class="col-form-label col-sm-2 mr-5">Name</label>
                                  <input type="text" name="name" class="form-control col-sm-8" value="{{$category->name}}">
                                </div>
                                <div class="form-inline row mb-3">
                                    <label class="col-form-label col-sm-2 mr-5">Description</label>
                                  <textarea name="description" class="form-control col-sm-8" rows="5">{{$category->description}}</textarea>
                                </div>
                                 

                                  <div class="modal-footer pb-0">
                                    <button type="button" class="btn btn-secondary py-1" data-dismiss="modal">Close</button> &nbsp; 

                                    <button type="submit" class="btn btn-primary px-4 py-1"  onclick="event.preventDefault();
                                    document.getElementById('editCategory-{{$category->id}}').submit();">Save</button>
                                </div>
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