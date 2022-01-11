@extends('layouts.admin')

@php

    if ($experience)
    {
        $experienceText = "Experience Update";
    }else{
        $experienceText = "Add Experience Study";
    }

@endphp

@section('title')
    {{$experienceText}}
@endsection

@section('css')
@endsection

@section('content')
    <div class="page-header">
        <h3 class="page-title">{{$experienceText}}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Admin Panel</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.experience.list')}}">Experience Data List</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$experienceText}}</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form class="forms-sample" method="post" action="" id="createExperienceForm">
                        @csrf
                        @if($experience)
                            <input type="hidden" name="experienceId" value="{{$experience->id}}">
                        @endif
                        <div class="form-group">
                            <label for="date">Experience Date</label>
                            <input type="text" class="form-control" name="date" id="date"
                                   placeholder="Experience Date"
                                   value="{{$experience ? $experience->date : ''}}">
                            <small>Example: 2012-2017</small>
                            @error('date')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="task_name">Task Name</label>
                            <input type="text" class="form-control" name="task_name" id="task_name"
                                   placeholder="Work Position"
                                   value="{{$experience ? $experience->task_name : ''}}">
                            @error('task_name')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="company_name">Company</label>
                            <input type="text" class="form-control" name="company_name" id="company_name"
                                   placeholder="Company"
                                   value="{{$experience ? $experience->company_name : ''}}">
                            @error('company_name')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea cols="30" rows="7" id="description" name="description" class="form-control"
                                      placeholder="Description">{{$experience ? $experience->description : ''}}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="order">Ordering</label>
                            <input type="text" class="form-control" name="order" id="order"
                                   placeholder="Ordering"
                                   value="{{$experience ? $experience->order : ''}}">
                        </div>

                        <div class="form-group">
                            <div class="form-check form-check-flat form-check-primary">
                                <label for="status" class="form-check-label">
                                    @php
                                        if ($experience){
                                            $checkStatus = $experience->status ? 'checked':'';
                                        }else{
                                            $checkStatus = '';
                                        }
                                    @endphp
                                    <input type="checkbox" name="status" id="status"
                                           class="form-check-input" {{$checkStatus}}>
                                    Status
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-check form-check-flat form-check-primary">
                                <label for="active" class="form-check-label">
                                    @php
                                        if ($experience){
                                            $checkActive = $experience->active ? 'checked':'';
                                        }else{
                                            $checkActive = '';
                                        }
                                    @endphp
                                    <input type="checkbox" name="active" id="active"
                                           class="form-check-input" {{$checkActive}}>
                                    Do you work at the moment ?
                                </label>
                            </div>
                        </div>


                        <button type="button" class="btn btn-primary mr-2" id="createButton">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('js')
    <script>
        let createButton = $('#createButton');
        createButton.click(function () {

            if ($('#date').val().trim() == '') {

                Swal.fire({
                    icon: 'info',
                    title: 'Warning',
                    text: 'Please, enter date!',
                    confirmButtonText: 'Okay'
                })

            } else if ($('#task_name').val().trim() == '') {

                Swal.fire({
                    icon: 'info',
                    title: 'Warning',
                    text: 'Please, enter work position!',
                    confirmButtonText: 'Okay'
                })

            } else if ($('#company_name').val().trim() == '') {

                Swal.fire({
                    icon: 'info',
                    title: 'Warning',
                    text: 'Please, enter company name!',
                    confirmButtonText: 'Okay'
                })

            } else {
                $('#createExperienceForm').submit();
            }
        });
    </script>
@endsection
