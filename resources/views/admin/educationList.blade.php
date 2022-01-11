@extends('layouts.admin')

@section('title')
    Education Data List
@endsection

@section('css')
@endsection

@section('content')
    <div class="page-header">
        <h3 class="page-title"> Education Data List</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Admin Panel</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="{{route('admin.education.list')}}">Data
                        Table</a></li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-4">
                        <a href="{{route('admin.education.add')}}" class="btn btn-primary btn-lg">Add New Study</a>
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
                                <th>Order</th>
                                <th>Education Date</th>
                                <th>University</th>
                                <th>Faculty</th>
                                <th>Degree</th>
                                <th>Explain</th>
                                <th>Status</th>
                                <th>Created Time</th>
                                <th>Update Time</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $item)
                                <tr id="{{$item->id}}">
                                    <td>{{$item->id}}</td>
                                    <td><a href="{{route('admin.education.add',['educationId' => $item->id])}}"
                                           class="btn btn-warning btn-xs editEducation">Edit<i
                                                class="fa fa-edit"></i></a></td>
                                    <td><a data-id="{{$item->id}}" href="javascript:void(0)"
                                           class="btn btn-danger btn-xs deleteEducation">Delete<i
                                                class="fa fa-trash"></i></a></td>
                                    <td>{{$item->order}}</td>
                                    <td>{{$item->education_date}}</td>
                                    <td>{{$item->university_name}}</td>
                                    <td>{{$item->university_faculty}}</td>
                                    <td>{{$item->university_degree}}</td>
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
            let educationId = $(this).attr('data-id');
            let self = $(this);

            $data = {
                educationId: educationId
            }

            $.ajax({
                url: "{{route('admin.education.changeStatus')}}",
                type: "post",
                async: false,
                data: $data,
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Successfully',
                        text: response.educationId + " success " + response.newStatus + "was updated",
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

        $('.deleteEducation').click(function () {
            let educationId = $(this).attr('data-id');

            $data = {
                educationId: educationId
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

                    $.ajax({
                        url: "{{route('admin.education.delete')}}",
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

                            $('tr#' + educationId).remove();
                        },
                        error: function () {

                        }
                    });

                }
            })


        });


    </script>
@endsection
