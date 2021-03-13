@extends('layouts.backend.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Admin Dashboard</h1>
          </div>
        </div>
      </div>
    </div>


    <!-- Main content -->
    <section class="content mt-5">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-info elevation-1">
                <i class="fas fa-laptop"></i>
              </span>
              <div class="info-box-content ml-3">
                <span class="info-box-text">Total Posts</span>
                <span class="info-box-number">{{$posts->count()}}</span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-secondary elevation-1">
                <i class="fas fa-list    "></i>
              </span>
              <div class="info-box-content ml-3">
                <span class="info-box-text">Total Category</span>
                <span class="info-box-number">{{$categories->count()}}</span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1">
                <i class="fa fa-users" aria-hidden="true"></i>
              </span>
              <div class="info-box-content ml-3">
                <span class="info-box-text">Total User</span>
                <span class="info-box-number">{{$users->count()}}</span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1">
                <i class="fas fa-comment    "></i>
              </span>
              <div class="info-box-content ml-3">
                <span class="info-box-text">Total Comments</span>
                <span class="info-box-number">{{$comments->count()}}</span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>
              <div class="info-box-content ml-3">
                <span class="info-box-text">Total Likes</span>
                <span class="info-box-number">{{$likes->count()}}</span>
              </div>
            </div>
          </div>

          <div class="col-12 mt-4">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title text-info">Latest 5 Comments</h3>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Post Title</th>
                      <th>Comment</th>
                      <th>Commented By</th>
                      <th>Commented At</th>
                    </tr>
                  </thead>
                  <tbody>
                   @foreach ($comments->take(5) as $key => $comment)
                   <tr>
                    <td>{{$key+1}}</td>
                    <td><a href="{{route('post', $comment->post->slug)}}">
                      {{$comment->post->title}}</a></td>
                    <td>{{$comment->comment}}</td>
                    <td><span class="tag tag-success">{{$comment->user->name}}</span></td>
                    <td>{{$comment->created_at->diffForHumans()}}</td>
                  </tr>
                   @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
  </div>
@endsection
