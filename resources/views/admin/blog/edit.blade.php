@extends('admin.layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Crud Blogs</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Blogs</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row" style="padding: 20px 50px; background-color: #FFF">
        <form method="post" enctype="multipart/form-data" style="width: 100%">
            @csrf
            <div class="field">
                <label style="padding: 3px 0px" class="label">Title</label>
                <div class="control">
                    <input class="input" value="{{ $data->title }}" name="title" type="text"
                        placeholder="Title blogs...">
                </div>
            </div>

            <div class="field">
                <label style="padding: 3px 0px" class="label">Images</label>

                @if($data->image)
                <img src="{{ asset('admin/blogs/image/' . $data->image) }}" alt="Current Avatar"
                    style="max-width: 100px; max-height: 100px;">
                @endif

                <input value="{{ $data->image }}" style="box-shadow: none; border: none; width: 50%" class="input"
                    type="file" name="image">
            </div>

            <div class="field">
                <label style="padding: 3px 0px" class="label">Description</label>
                <div class="control">
                    <textarea name="description" class="textarea"
                        placeholder="Description">{{ $data->description }}</textarea>
                </div>
            </div>

            <div class="field">
                <label style="padding: 3px 0px" class="label">Content</label>
                <div class="control">
                    <textarea id="content" name="content" class="textarea"
                        placeholder="Content blogs...">{{ $data->content }}</textarea>
                </div>
            </div>

            <div class="field is-grouped">
                <div class="control">
                    <button type="submit" name="submit" class="button is-link">Submit</button>
                </div>
                <div class="control">
                    <a href="{{ url('/admin/blog/add') }}" class="button is-link is-light">Cancel</a>
                </div>
                <a href="{{ url('/admin/blog/list') }}" class="button">List Blogs</a>
            </div>
        </form>
        <br>
        @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Thông báo!</h4>
            {{session('success')}}
        </div>
        @endif



        @if($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Thông báo!</h4>
            <ul>
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif

    </div>
    <br>
</div>


<footer class="footer text-center">
    All Rights Reserved by Nice admin. Designed and Developed by
    <a href="https://wrappixel.com">WrapPixel</a>.
</footer>
@endsection