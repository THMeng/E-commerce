@extends('backend.master')
@section('content')

    @section('site-title')
        Admin | Update Attribute
    @endsection
    @section('page-main-title')
    Update Attribute
    @endsection

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="col-xl-12">
                <!-- File input -->
                <form action="/admin/update-attribute-submit" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        @if (Session::has('message'))
                            <p class="text-primary text-center">{{ Session::get('message') }}</p>
                        @endif
                        <div class="card-body">

                            <div class="row">
                            <input type="hidden" name="id" value="{{ $attribute->id }}">
                                <div class="mb-3 col-6">
                                    <label for="formFile" class="form-label">Type</label>
                                    <select name="type" class="form-control">
                                        <!-- <option value="color" {{$attribute->type == 'color' ? 'selected' : ''}}>Color</option>
                                        <option value="size" {{$attribute->type == 'size' ? 'selected' : ''}}>Size</option> -->
                                      
                                            <option value="color" {{$attribute->type == 'color' ? 'selected' : ''}} >Color</option>
                                            <option value="size" {{$attribute->type == 'size' ? 'selected' : ''}}>Size</option>
                                    
                                    </select>
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="formFile" class="form-label">Value</label>
                                    <input class="form-control" type="text" value="{{$attribute->value}}" name="value" />
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
