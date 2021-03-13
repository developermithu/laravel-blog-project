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
                    <h1>User List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">User</li>
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

                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal" >Add New User</button>

                    </div>

                    
<!-- Model Form -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header bg-gray">
                        <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                    <!-- form -->
                        <form action="" method="POST">
                        <div class="form-group">
                            <label class="col-form-label">User Name</label>
                            <input type="text" class="form-control" placeholder="User Name..">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Status</label>
                            <input type="text" class="form-control" placeholder="Status..">
                        </div>
                        </form>

                    </div>
                    <div class="modal-footer bg-gray">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> &nbsp; 
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
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
                                    <th>Role</th>
                                    <th>User Id</th>
                                    <th>Email</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $user)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->role->name}}</td>
                                    <td>{{$user->userid}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->created_at}}</td>
                                    <td>{{$user->updated_at}}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info text-white" data-toggle="modal" data-target="#editModal-{{$user->id}}" ><i class="fas fa-edit "></i></button> &nbsp;

                                        <button type="button" class="btn btn-sm btn-danger text-white" data-toggle="modal" data-target="#deleteModal-{{$user->id}}" ><i class="fas fa-trash "></i></button>
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
                   @foreach ($users as $user)
                   {{-- Delete Model --}}
                   <div class="modal fade" id="deleteModal-{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><b>Delete User</b></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure to delete this user?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> &nbsp; 

                            <button type="submit" class="btn btn-primary"  onclick="event.preventDefault();
                            document.getElementById('deleteUser-{{$user->id}}').submit();">Confirm</button>
                            <form id="deleteUser-{{$user->id}}" action="{{ route('admin.user.destroy', $user->id) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                        </div>
                    </div>
                    </div>

                  {{-- Update Model --}}
                   <div class="modal fade" id="editModal-{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><b>Update User</b></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('admin.user.update', $user->id)}}" method="POST" enctype="multipart/form-data" id="editUser-{{$user->id}}">
                                @csrf
                                @method('PUT')
                                <div class="form-inline row mb-3">
                                    <label class="col-form-label col-sm-2 mr-5">Name</label>
                                  <input type="text" name="name" class="form-control col-sm-8" value="{{$user->name}}" readonly>
                                </div>

                                <div class="form-inline row mb-3">
                                    <label class="col-form-label col-sm-2 mr-5">User Id</label>
                                  <input type="text" name="userid" class="form-control col-sm-8" value="{{$user->userid}}" readonly>
                                </div>

                                <div class="form-inline row mb-3">
                                    <label class="col-form-label col-sm-2 mr-5">Email</label>
                                  <input type="text" name="email" class="form-control col-sm-8" value="{{$user->email}}" readonly>
                                </div>
                            
                                <div class="form-inline row mb-3 ">
                                    <label class="col-form-label col-sm-2 mr-5">Role</label>
                                    <div class="form-check">
                                        @foreach ($roles as $role)
                                        <label class="form-check-label mr-2">
                                            <input type="radio" class="form-check-input" name="role" value="{{$role->id}}" {{$user->role->id == $role->id ? 'checked' : ""}}>
                                            {{$role->name}}
                                          </label> 
                                        @endforeach
                                    </div>
                                  </div>

                                  <div class="modal-footer pb-0">
                                    <button type="button" class="btn btn-secondary py-1" data-dismiss="modal">Close</button> &nbsp; 

                                    <button type="submit" class="btn btn-primary px-4 py-1"  onclick="event.preventDefault();
                                    document.getElementById('editUser-{{$user->id}}').submit();">Save</button>
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