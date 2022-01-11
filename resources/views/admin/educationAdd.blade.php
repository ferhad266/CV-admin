@extends('layouts.admin')

@php

    if ($education) {
        $educationText = "Education Update";
    }else{
        $educationText = "Add New Study";
    }

@endphp

@section('title')
    {{$educationText}}
@endsection

@section('css')
@endsection

@section('content')
    <div class="page-header">
        <h3 class="page-title">{{$educationText}}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Admin Panel</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Study</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form class="forms-sample" method="post" action="" id="createEducationForm">
                        @csrf
                        @if($education)
                            <input type="hidden" name="educationId" value="{{$education->id}}">
                        @endif
                        <div class="form-group">
                            <label for="education_date">Education Date</label>
                            <input type="text" class="form-control" name="education_date" id="education_date"
                                   placeholder="Education Date"
                                   value="{{$education ? $education->education_date : ''}}">
                            <small>Example: 2012-2017</small>
                            @error('education_date')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="university_name">University Name</label>
                            <input type="text" class="form-control" name="university_name" id="university_name"
                                   placeholder="University Name"
                                   value="{{$education ? $education->university_name : ''}}">
                            @error('university_name')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="university_faculty">University Faculty</label>
                            <input type="text" class="form-control" name="university_faculty" id="university_faculty"
                                   placeholder="University Faculty"
                                   value="{{$education ? $education->university_faculty : ''}}">
                            @error('university_faculty')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="university_degree">University Degree</label>
                            <input type="text" class="form-control" name="university_degree" id="university_degree"
                                   placeholder="University Degree"
                                   value="{{$education ? $education->university_degree : ''}}">
                            @error('university_degree')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea cols="30" rows="7" id="description" name="description" class="form-control"
                                      placeholder="Description">{{$education ? $education->description : ''}}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="order">Ordering</label>
                            <input type="text" class="form-control" name="order" id="order"
                                   placeholder="Ordering"
                                   value="{{$education ? $education->order : ''}}">
                        </div>

                        <div class="form-group">
                            <div class="form-check form-check-flat form-check-primary">
                                <label for="status" class="form-check-label">
                                    @php
                                        if ($education){
                                            $checkStatus = $education->status ? 'checked':'';
                                        }else{
                                            $checkStatus = '';
                                        }
                                    @endphp
                                    <input type="checkbox" name="status" id="status"
                                           class="form-check-input" {{$checkStatus}}>
                                    Success
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

            if ($('#education_date').val().trim() == '') {

                Swal.fire({
                    icon: 'info',
                    title: 'Warning',
                    text: 'Please, enter date!',
                    confirmButtonText: 'Okay'
                })

            } else if ($('#university_name').val().trim() == '') {

                Swal.fire({
                    icon: 'info',
                    title: 'Warning',
                    text: 'Please, enter university name!',
                    confirmButtonText: 'Okay'
                })

            } else if ($('#university_faculty').val().trim() == '') {

                Swal.fire({
                    icon: 'info',
                    title: 'Warning',
                    text: 'Please, enter university faculty!',
                    confirmButtonText: 'Okay'
                })

            } else if ($('#university_degree').val().trim() == '') {

                Swal.fire({
                    icon: 'info',
                    title: 'Warning',
                    text: 'Please, enter degree!',
                    confirmButtonText: 'Okay'
                })

            } else {
                $('#createEducationForm').submit();
            }
        });
    </script>
@endsection
