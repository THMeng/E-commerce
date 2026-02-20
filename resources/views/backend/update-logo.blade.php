@extends('backend.master')
@section('content')

    @section('site-title')
        Admin | Update Post
    @endsection
    @section('page-main-title')
        Update Logo
    @endsection

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="col-xl-12">
                <!-- File input -->
                <form action="/admin/update-logo-submit" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        @if (Session::has('message'))
                            <p class="text-primary text-center">{{ Session::get('message') }}</p>
                        @endif
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" name="id" value="{{ $logo->id }}">
                                <input type="hidden" name="old_thumbnail" value="{{ $logo->thumbnail }}">
                                <div class="mb-3 col-12">
                                    <img src="/uploads/{{ $logo->thumbnail }}" width="150px"> <br>
                                    <label for="formFile" class="form-label text-danger mt-2">Recommend image size ..x.. pixels.</label>
                                    <input class="form-control" type="file" name="thumbnail" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="submit" class="btn btn-primary" value="Add Post">
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection
