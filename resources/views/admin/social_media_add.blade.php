@extends('layouts.admin')
@section('title')
    @php
        if ($socialMedia){
            $socialMediaText = 'Social Media Update';
        }else{
            $socialMediaText = 'Social Media Add';
        }
    @endphp
    {{$socialMediaText}}
@endsection
@section('css')
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title">{{$socialMediaText}}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Admin Panel</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.socialMedia.list')}}">Social Media Accounts</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$socialMediaText}}</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form class="forms-sample" method="post" action="" id="createExperienceForm">
                        @csrf
                        @if($socialMedia)
                            <input type="hidden" name="socialMediaId" value="{{$socialMedia->id}}">
                        @endif
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name"
                                   placeholder="Social Media Name"
                                   value="{{$socialMedia ? $socialMedia->name : ''}}">
                            @error('name')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="link">Link</label>
                            <input type="text" class="form-control" name="link" id="link"
                                   placeholder="Social Media Link"
                                   value="{{$socialMedia ? $socialMedia->link : ''}}">
                            @error('link')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="order">Order</label>
                            <input type="text" class="form-control" name="order" id="order"
                                   placeholder="Order"
                                   value="{{$socialMedia ? $socialMedia->order : ''}}">
                            @error('order')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="icon">Icon</label>
                            <input type="text" class="form-control" name="icon" id="icon"
                                   placeholder="icon"
                                   value="{{$socialMedia ? $socialMedia->icon : ''}}">
                            <small>
                                <a href="https://fontawesome.com/v5.15/icons?d=gallery&p=2&s=brands" target="_blank">Click
                                    for social media icons
                                </a>
                            </small>
                            @error('icon')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="form-check form-check-flat form-check-primary">
                                <label for="status" class="form-check-label">
                                    @php
                                        if ($socialMedia){
                                            $checkStatus = $socialMedia->status ? 'checked':'';
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

                        <button type="submit" class="btn btn-primary mr-2" id="createButton">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
