@extends('layouts.admin')

@section('title')
    Portfolio Images List
@endsection

@section('css')

@endsection

@section('content')
    <style>
        .table th img, .jsgrid .jsgrid-table th img, .table td img, .jsgrid .jsgrid-table td img {
            width: 100px;
            height: unset !important;
            border-radius: unset !important;
        }
    </style>

    <div class="page-header">
        <h3 class="page-title"> Portfolio Images List</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Admin Panel</a></li>
                <li class="breadcrumb-item active" aria-current="page">Portfolio Image List</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-4">
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal"
                           class="btn btn-primary btn-lg">Add Portfolio Image</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Delete</th>
                                <th>Featured Photo</th>
                                <th>Status</th>
                                <th>Created Time</th>
                                <th>Update Time</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($images as $item)
                                <tr id="{{$item->id}}">
                                    <td>{{$item->id}}</td>
                                    <td>
                                        <img
                                            src="{{ $item->image ? asset('storage/portfolio/'.$item->image) :''}}"
                                            width="100" alt="">
                                    </td>
                                    <td><a data-id="{{$item->id}}" href="javascript:void(0)"
                                           class="btn btn-danger btn-xs deletePortfolio">Delete<i
                                                class="fa fa-trash"></i></a></td>
                                    <td><a data-id="{{$item->id}}" href="javascript:void(0)"
                                           class="btn
                                           {{$item->featured ? 'btn-success featuredImage btn-xs':'btn-primary btn-xs featureImage'}}">
                                            {{$item->featured ? 'Featured' : 'Feature'}}<i
                                                class="fa fa-eye"></i></a></td>
                                    <td>
                                        @if($item->status)
                                            <a data-id="{{$item->id}}" href="javascript:void(0)"
                                               class="btn btn-success btn-xs changeStatus">Active</a>
                                        @else
                                            <a data-id="{{$item->id}}" href="javascript:void(0)"
                                               class="btn btn-danger btn-xs changeStatus">Passive</a>
                                        @endif
                                    </td>
                                    <td>{{\Carbon\Carbon::parse($item->created_at)->format("d-m-Y H:i:s")}}</td>
                                    <td>{{\Carbon\Carbon::parse($item->updated_at)->format("d-m-Y H:i:s")}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add new photo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="" method="post" id="newImageForm" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="images[]" id="images" multiple>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="saveImage" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>

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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
            }
        });

        $('#saveImage').click(function () {
            let imageCheckStatus = imageCheck($('#images'));

            if (!imageCheckStatus) {
                Swal.fire({
                    icon: 'error',
                    title: 'Warning!',
                    text: 'Control chosen photo!',
                    confirmButtonText: 'Okay'
                });
            } else {
                $('#newImageForm').submit();
            }
        });

        $('.changeStatus').click(function () {

            let imageId = $(this).attr('data-id');
            let self = $(this);
            let route = '{{route('portfolio.changeStatusImage',['id'=> 'imageId'])}}';
            let finalRoute = route.replace('imageId', imageId);

            $data = {
                id: imageId
            }

            $.ajax({
                url: finalRoute,
                type: "post",
                async: false,
                data: $data,
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Successfully',
                        text: response.id + " success " + response.newStatus + "was updated",
                        confirmButtonText: 'Okay'
                    });

                    if (response.status == 1) {

                        self[0].innerText = 'Active';
                        self.removeClass("btn-danger");
                        self.addClass("btn-success");

                    } else if (response.status == 0) {

                        self[0].innerText = 'Passive';
                        self.removeClass("btn-success");
                        self.addClass("btn-danger");
                    }
                },
                error: function () {

                }
            });

        });

        $('.deletePortfolio').click(function () {
            let portfolioId = $(this).attr('data-id');

            $data = {
                '_method': 'DELETE'
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Not!'
            }).then((result) => {

                if (result.isConfirmed) {

                    let route = '{{route('portfolio.deleteImage',['id'=> 'deletePortfolio'])}}';
                    let finalRoute = route.replace('deletePortfolio', portfolioId);

                    $.ajax({
                        url: finalRoute,
                        type: "post",
                        async: false,
                        data: $data,
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Successfully',
                                text: 'Delete was successfully.',
                                confirmButtonText: 'Okay'
                            });

                            $('tr#' + portfolioId).remove();
                        },
                        error: function () {

                        }
                    });

                }
            })

        });

        $(document).on('click', '.featureImage', function () {
            // });
            // $('.featureImage').click(function () {
            let featureImage = $(this).attr('data-id');
            let self = $(this);

            $data = {
                '_method': 'PUT'
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "You'll be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, feature it!',
                cancelButtonText: 'Not!'
            }).then((result) => {

                if (result.isConfirmed) {

                    let route = '{{route('portfolio.featureImage',['id'=> 'featureImage'])}}';
                    let finalRoute = route.replace('featureImage', featureImage);

                    $.ajax({
                        url: finalRoute,
                        type: "post",
                        async: false,
                        data: $data,
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Successfully',
                                text: 'Feature was successfully.',
                                confirmButtonText: 'Okay'
                            });

                            $('.featuredImage').removeClass('btn-success');
                            $('.featuredImage').addClass('btn-primary');
                            $('.featuredImage').text('Feature');
                            $('.featuredImage').addClass('featureImage');
                            $('.featuredImage').removeClass('featuredImage');


                            self.removeClass('btn-primary')
                            self.addClass('btn-success');
                            self.removeClass('featureImage')
                            self.addClass('featuredImage');
                            self.text('Featured');

                        },
                        error: function () {

                        }
                    });

                }
            })

        });

    </script>


@endsection
