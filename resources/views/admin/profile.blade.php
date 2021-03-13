@extends('layouts.backend.app')
@push('header')
<link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
@endpush

@section('content')
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Profile</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div>
    </div>


    <!-- Main content -->
    <section class="content mt-5">
      <div class="container-fluid">
        <div class="row">

<div class="col-md-3">
  <div class="card card-primary card-outline">
    <div class="card-body box-profile">
      <div class="text-center">
        <img class="profile-user-img img-fluid img-circle" src="{{asset('storage/user/' .$user->image)}}" alt="User profile picture">
      </div>
      <h3 class="profile-username text-center">{{$user->name}}</h3>
      <p class="text-muted text-center">{{$user->email}}</p>
      <ul class="list-group list-group-unbordered mb-3">
        {{-- <li class="list-group-item">
          <b>Friends</b> <a class="float-right">13,287</a>
        </li> --}}
      </ul>
      <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
    </div>
  </div>
</div>
<div class="col-md-9">
  <div class="card">
    <div class="card-header p-2">
      <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link active show" href="#profile" data-toggle="tab">Profile</a></li>
        <li class="nav-item"><a class="nav-link" href="#password" data-toggle="tab">Password</a></li>
      </ul>
    </div>
    <div class="card-body">
      <div class="tab-content">
        <div class="tab-pane active" id="profile">
          <form action="{{route('admin.profile.update')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Name</label>
              <div class="col-sm-10">
                <input type="text" name="name" class="form-control" value="{{$user->name}}">
                @error('name')
                    <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">User Id</label>
              <div class="col-sm-10">
                <input type="text" name="userid" class="form-control" value="{{$user->userid}}">
                @error('userid')
                    <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">About</label>
              <div class="col-sm-10"><grammarly-extension style="position: absolute; top: 0px; left: 0px; pointer-events: none;" class="cGcvT"></grammarly-extension>
                <textarea name="about" class="form-control" spellcheck="false">
                    {{$user->about}}
                </textarea>
                @error('about')
                <span class="text-danger">{{$message}}</span>
            @enderror
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Change Image</label>
              <div class="col-sm-10">
                <input type="file" name="image" class="form-control">
                @error('image')
                    <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <div class="offset-sm-2 col-sm-10">
                <button type="submit" class="btn btn-danger px-4">Save</button>
              </div>
            </div>
          </form>
        </div>

        {{-- Password Tab --}}
        <div class="tab-pane" id="password">

          <form action="{{route('admin.profile.password')}}" method="POST" class="form-horizontal">
            @csrf
            @method('PUT')
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Old Password</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" name="old_password" placeholder="Old password.." required>
                @error('old_password')
                    <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label"> New Password</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" name="password" placeholder=" New password.." required>
                @error('password')
                <span class="text-danger">{{$message}}</span>
            @enderror
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label"> Confirm Password</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm password.." required>
                @error('password_confirmation')
                <span class="text-danger">{{$message}}</span>
            @enderror
              </div>
            </div>

            <div class="form-group row">
              <div class="offset-sm-2 col-sm-10">
                <button type="submit" class="btn btn-danger">Change</button>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>

        </div>
      </div>
    </section>
  </div>
@endsection

@push('footer')
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
        {!! Toastr::message() !!}
@endpush