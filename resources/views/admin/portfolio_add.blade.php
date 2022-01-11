@extends('layouts.admin')

@section('title')
    Portfolio Manager
@endsection

@section('css')
@endsection

@section('content')
    <div class="page-header">
        <h3 class="page-title">Portfolio Manager</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Admin Panel</a></li>
                <li class="breadcrumb-item active" aria-current="page">Portfolio Manager</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form class="forms-sample" method="post"
                          action="{{isset($portfolio) ? route('portfolio.update',['portfolio' => request('portfolio')]) : route('portfolio.store')}}"
                          id="portfolioForm"
                          enctype="multipart/form-data">
                        @csrf
                        @isset($portfolio)
                            @method('PUT')
                        @endisset

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" id="title"
                                   placeholder="title"
                                   value="{{$portfolio->title ?? ''}}">
                            @error('title')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <input type="text" class="form-control" name="tags" id="tags"
                                   placeholder="tags"
                                   value="{{$portfolio->tags ?? ''}}">
                            @error('tags')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="about">About</label>
                            <textarea name="about" id="about" cols="80" rows="7">
                                {!!  $portfolio->about ?? ''!!}
                            </textarea>
                        </div>

                        <div class="form-group">
                            <label for="website">Website</label>
                            <input type="text" class="form-control" name="website" id="website"
                                   placeholder="website"
                                   value="{{$portfolio->website ?? ''}}">
                            @error('website')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="keywords">keywords</label>
                            <input type="text" class="form-control" name="keywords" id="keywords"
                                   placeholder="keywords"
                                   value="{{$portfolio->keywords ?? ''}}">
                            @error('keywords')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">description</label>
                            <input type="text" class="form-control" name="description" id="description"
                                   placeholder="description"
                                   value="{{$portfolio->description ?? ''}}">
                            @error('description')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        @isset($portfolio)
                        @else
                            <div class="form-group">
                                <label for="images">Choose Photos</label>
                                <br>
                                <input type="file" name="images[]" id="images" multiple>
                                @if($errors->has('images.*'))
                                    @foreach($errors->get('images.*') as $key=>$value)
                                        <div class="alert alert-danger">{{$errors->first($key)}}</div>
                                    @endforeach
                                @endif
                            </div>
                        @endisset

                        <div class="form-group">
                            <div class="form-check form-check-flat form-check-primary">
                                <label for="status" class="form-check-label">
                                    <input type="checkbox" name="status" id="status"
                                           class="form-check-input" {{isset($portfolio) ? ($portfolio->status ? 'checked':'') :''}}>
                                    Status
                                </label>
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary mr-2"
                                id="createButton">{{isset($portfolio) ? 'update' :'save'}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('js')

    {{--    Ckeditor CDN--}}
    {{--    <script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>--}}
    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>

    <script>
        var options = {
            filebrowserImageBrowseUrl: '/admin/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/admin/laravel-filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/admin/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/admin/laravel-filemanager/upload?type=Files&_token='
        };

        var about = CKEDITOR.replace('about', options
            // {
            // extraAllowedContent: 'div',
            // height: 150,
            // }
        );

        @isset($portfolio)
        $('#createButton').click(function () {

            if ($('#title').val().trim() == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Warning!',
                    text: 'Title must not be empty!',
                    confirmButtonText: 'Okay'
                });
            } else if ($('#tags').val().trim() == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Warning!',
                    text: 'Tags must not be empty!',
                    confirmButtonText: 'Okay'
                });
            } else {
                $('#portfolioForm').submit();
            }

        });
        @else
        $('#images').change(function () {

            let images = $(this);

            let imageCheckStatus = imageCheck(images);

            console.log(imageCheckStatus + 'test');
        });

        function imageCheck(images) {

            let length = images[0].files.length;
            let files = images[0].files;
            let checkImage = ['png', 'jpg', 'jpeg'];

            for (let i = 0; i < length; i++) {

                let type = files[i].type.split('/').pop();
                let size = files[i].size;

                if ($.inArray(type, checkImage) == '-1') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Warning!',
                        text: ' Which photo is chosen that\'s name is' + files[i].name + ', it\'s format is not valid!',
                        confirmButtonText: 'Okay'
                    });

                    return false;
                }

                if (size > 2048000) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Warning!',
                        text: ' Which photo is chosen that\'s name is' + files[i].name + ', it\'s size must not big than 2Mb',
                        confirmButtonText: 'Okay'
                    });
                    return false;
                }
            }

            return true;
        }

        $('#createButton').click(function () {

            let imageCheckStatus = imageCheck($('#images'));

            if (!imageCheckStatus) {
                Swal.fire({
                    icon: 'error',
                    title: 'Warning!',
                    text: 'Control chosen photo!',
                    confirmButtonText: 'Okay'
                });
            } else if ($('#title').val().trim() == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Warning!',
                    text: 'Title must not be empty!',
                    confirmButtonText: 'Okay'
                });
            } else if ($('#tags').val().trim() == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Warning!',
                    text: 'Tags must not be empty!',
                    confirmButtonText: 'Okay'
                });
            } else {
                $('#portfolioForm').submit();
            }

        });
        @endisset
    </script>

@endsection
