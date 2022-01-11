@extends('layouts.admin')

@section('title')
    Portfolio List
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
        <h3 class="page-title"> Portfolio List</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                {{--                <li class="breadcrumb-item"><a href="{{route('portfolio.index')}}">Admin Panel</a></li>--}}
                <li class="breadcrumb-item active" aria-current="page"><a href="{{route('portfolio.index')}}">Data
                        Table</a></li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-4">
                        <a href="{{route('portfolio.create')}}" class="btn btn-primary btn-lg">Add Portfolio</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Update</th>
                                <th>Delete</th>
                                <th>Featured Photo</th>
                                <th>Title</th>
                                <th>Tags</th>
                                <th>About</th>
                                <th>website</th>
                                <th>Keywords</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Created Time</th>
                                <th>Update Time</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $item)
                                <tr id="{{$item->id}}">
                                    <td>{{$item->id}}</td>
                                    <td><a href="{{route('portfolio.edit',['portfolio' => $item->id])}}"
                                           class="btn btn-warning btn-xs editEducation">Edit<i
                                                class="fa fa-edit"></i></a></td>
                                    <td><a data-id="{{$item->id}}" href="javascript:void(0)"
                                           class="btn btn-danger btn-xs deletePortfolio">Delete<i
                                                class="fa fa-trash"></i></a></td>
                                    <td>
                                        <a href="{{route('portfolio.showImages',['id' => $item->id])}}">
                                            <img
                                                src="{{ $item->featuredImage ? asset('storage/portfolio/'.$item->featuredImage->image) :''}}"
                                                width="100" alt="">
                                        </a>
                                    </td>
                                    <td title="{{strip_tags($item->title)}}">{{strip_tags(substr($item->title,0,15))}}</td>
                                    <td title="{{strip_tags($item->tags)}}">{{$item->tags}}</td>
                                    <td title="{{strip_tags($item->about)}}">{{strip_tags(substr($item->about,0,50))}}</td>
                                    <td>{{$item->website}}</td>
                                    <td>{{$item->keywords}}</td>
                                    <td>{{$item->description}}</td>
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

@endsection

@section('js')
    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
            }
        });

        $('.changeStatus').click(function () {
            let portfolioId = $(this).attr('data-id');
            let self = $(this);

            $data = {
                portfolioId: portfolioId
            }

            $.ajax({
                url: "{{route('portfolio.changeStatus')}}",
                type: "post",
                async: false,
                data: $data,
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Successfully',
                        text: response.portfolioId + " success " + response.newStatus + "was updated",
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
                portfolioId: portfolioId,
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

                    let route = '{{route('portfolio.destroy',['portfolio'=> 'deletePortfolio'])}}';
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

    </script>


@endsection
