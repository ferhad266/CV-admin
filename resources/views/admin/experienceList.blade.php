@extends('layouts.admin')

@section('title')
    Experience Data List
@endsection

@section('css')
@endsection

@section('content')
    <div class="page-header">
        <h3 class="page-title"> Experience Data List</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Admin Panel</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="{{route('admin.experience.list')}}">Data
                        Table</a></li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-4">
                        <a href="{{route('admin.experience.add')}}" class="btn btn-primary btn-lg">Add Experience</a>
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
                                <th>Experience Date</th>
                                <th>Position</th>
                                <th>Company</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Active</th>
                                <th>Created Time</th>
                                <th>Update Time</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $item)
                                <tr id="{{$item->id}}">
                                    <td>{{$item->id}}</td>
                                    <td><a href="{{route('admin.experience.add',['experienceId' => $item->id])}}"
                                           class="btn btn-warning btn-xs editEducation">Edit<i
                                                class="fa fa-edit"></i></a></td>
                                    <td><a data-id="{{$item->id}}" href="javascript:void(0)"
                                           class="btn btn-danger btn-xs deleteEducation">Delete<i
                                                class="fa fa-trash"></i></a></td>
                                    <td>{{$item->order}}</td>
                                    <td>{{$item->date}}</td>
                                    <td>{{$item->task_name}}</td>
                                    <td>{{$item->company_name}}</td>
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
                                    <td>
                                        @if($item->active)
                                            <a data-id="{{$item->id}}" href="javascript:void(0)"
                                               class="btn btn-success btn-xs activeStatus">Active</a>
                                        @else
                                            <a data-id="{{$item->id}}" href="javascript:void(0)"
                                               class="btn btn-danger btn-xs activeStatus">Passive</a>
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
            let experienceId = $(this).attr('data-id');
            let self = $(this);

            $data = {
                experienceId: experienceId
            }

            $.ajax({
                url: "{{route('admin.experience.changeStatus')}}",
                type: "post",
                async: false,
                data: $data,
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Successfully',
                        text: response.experienceId + " success " + response.newStatus + "was updated",
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

        $('.activeStatus').click(function () {
            let experienceId = $(this).attr('data-id');
            let self = $(this);

            $data = {
                experienceId: experienceId
            }

            $.ajax({
                url: "{{route('admin.experience.activeStatus')}}",
                type: "post",
                async: false,
                data: $data,
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Successfully',
                        text: response.experienceId + " success " + response.newActive + "was updated",
                        confirmButtonText: 'Okay'
                    });

                    if (response.active == 1) {

                        self[0].innerText = 'Active';
                        self.removeClass("btn-danger");
                        self.addClass("btn-success");

                    } else if (response.active == 0) {

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
            let experienceId = $(this).attr('data-id');

            $data = {
                experienceId: experienceId
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
                        url: "{{route('admin.experience.delete')}}",
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

                            $('tr#' + experienceId).remove();
                        },
                        error: function () {

                        }
                    });

                }
            })


        });


    </script>
@endsection
