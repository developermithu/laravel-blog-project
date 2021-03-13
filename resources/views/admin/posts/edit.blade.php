@extends('layouts.backend.app')

@push('header')
<link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
@endpush

@section('content')

<div class="content-wrapper">
    <div class="content-header border-bottom">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Update Post</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Post</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- content-header -->

    <main>
        <div class="container">
            <div class="row">
                {{-- show all error --}}
                {{-- <div class="col-md-10 offset-md-1 mt-3">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div> --}}

            <div class="col-md-10 offset-md-1">

                    <form action="{{route('admin.post.update', $post->id)}}" method="POST" class="my-4 shadow px-3 py-4" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        {{-- required must be used prev autocomplete --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Post Title</label>
                            <div class="col-sm-10">
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{$post->title}}" required autocomplete="title" autofocus > 
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Category</label>
                            <div class="col-sm-10">
                                  <select class="form-control @error('category') is-invalid @enderror" name="category" required autofocus >
                                      @foreach ($categories as $category)
                                          <option value="{{$category->id}}" {{$post->category->id == $category->id ? 'selected' : ""}}>{{$category->name}}</option>
                                      @endforeach
                                  </select>
                                  @error('category')
                                  <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Post Image</label>
                            <div class="col-sm-10">
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" autofocus >
                                @error('image')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Body</label>
                            <div class="col-sm-10">
                             <textarea id="editor" name="body" rows="3" class="form-control"  >{{$post->body}}</textarea> 
                             {{-- ckeditor not allow required --}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tags</label>
                            <div class="col-sm-10">
                                <input type="text" name="tags" class="form-control" value=" @foreach($post->tags as $key=>$tag) {{$key+1<count($post->tags) ? $tag->name. ',' : $tag->name}} @endforeach" required>
                            </div>
                        </div>
      

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-10">
                               <div class="form-check">
                                   <label class="form-check-label">
                                   <input type="radio" class="form-check-input" name="status" value="1" {{$post->status == 1 ? 'checked' : ""}} required >
                                   Published
                                 </label>
                               </div>
                            </div>
                        </div>

                        <div class="form-group row mt-4 ml-5">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary  px-4">Submit</button> 
                            </div>
                        </div>
                    </form>
                    
            </div>
            </div>
        </div>
    </main>
</div>
<!-- content-wrapper -->

@endsection

@push('footer')
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
        {!! Toastr::message() !!}
@endpush