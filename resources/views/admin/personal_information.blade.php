@extends('layouts.admin')

@section('title')
    Personal Information
@endsection

@section('css')
@endsection

@section('content')
    <div class="page-header">
        <h3 class="page-title">Personal Information</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Admin Panel</a></li>
                <li class="breadcrumb-item active" aria-current="page">Personal Information Update</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form class="forms-sample" method="post" action="" id="createEducationForm"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="main_title">Home Page Header</label>
                            <input type="text" class="form-control" name="main_title" id="main_title"
                                   placeholder="Home Page Header"
                                   value="{{$information->main_title}}">
                            @error('main_title')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="editor1">About</label>
                            <textarea name="about_text" id="editor1" cols="80" rows="7">
                                {!! $information->about_text !!}
                            </textarea>
                        </div>

                        <div class="form-group">
                            <label for="btn_contact_text">Contact</label>
                            <input type="text" class="form-control" name="btn_contact_text" id="btn_contact_text"
                                   placeholder="Contact"
                                   value="{{$information->btn_contact_text}}">
                            @error('btn_contact_text')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="btn_contact_link">Contact Link</label>
                            <input type="text" class="form-control" name="btn_contact_link" id="btn_contact_link"
                                   placeholder="Contact Link"
                                   value="{{$information->btn_contact_link}}">
                            @error('btn_contact_link')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="small_title_left">Small Education Title</label>
                            <input type="text" class="form-control" name="small_title_left" id="small_title_left"
                                   placeholder="Education Title"
                                   value="{{$information->small_title_left}}">
                            @error('small_title_left')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="title_left">Education Title</label>
                            <input type="text" class="form-control" name="title_left" id="title_left"
                                   placeholder="Education Title"
                                   value="{{$information->title_left}}">
                            @error('title_left')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="small_title_right">Small Experience Title</label>
                            <input type="text" class="form-control" name="small_title_right" id="small_title_right"
                                   placeholder="Upper Experience Title"
                                   value="{{$information->small_title_right}}">
                            @error('small_title_right')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="title_right">Experience Title</label>
                            <input type="text" class="form-control" name="title_right" id="title_right"
                                   placeholder="Upper Experience Title"
                                   value="{{$information->title_right}}">
                            @error('title_right')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <input type="text" class="form-control" name="full_name" id="full_name"
                                   placeholder="Full name"
                                   value="{{$information->full_name}}">
                            @error('full_name')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="image">Choose Photo</label>
                                    <input type="file" class="form-control" name="image" id="image">
                                    @error('image')
                                    <div class="alert alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <img width="100%"
                                        src="{{asset($information->image ? 'storage/'.$information->image : 'assets/images/faces/face15.jpg' )}}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="birthday">Birthday</label>
                            <input type="text" class="form-control" name="birthday" id="birthday"
                                   placeholder="Birthday"
                                   value="{{$information->birthday}}">
                            @error('birthday')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="website">Website</label>
                            <input type="text" class="form-control" name="website" id="website"
                                   placeholder="Website"
                                   value="{{$information->website}}">
                            @error('website')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" name="phone" id="phone"
                                   placeholder="phone"
                                   value="{{$information->phone}}">
                            @error('phone')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="mail">E-mail</label>
                            <input type="email" class="form-control" name="mail" id="mail"
                                   placeholder="E-mail"
                                   value="{{$information->mail}}">
                            @error('mail')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" name="address" id="address"
                                   placeholder="Address"
                                   value="{{$information->address}}">
                            @error('address')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="cv">CV</label>
                            <input type="file" class="form-control" name="cv" id="cv">
                            @error('cv')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="editorLang">Languages</label>
                            <textarea name="languages" id="editorLang" cols="80" rows="7">
                                {!! $information->languages !!}
                            </textarea>
                        </div>

                        <div class="form-group">
                            <label for="editorInterest">Interests</label>
                            <textarea name="interests" id="editorInterest" cols="80" rows="7">
                                {!! $information->interests !!}
                            </textarea>
                        </div>

                        <button type="submit" class="btn btn-primary mr-2" id="createButton">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('js')

    {{--    Ckeditor CDN--}}
    <script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>

    <script>
        var editor1 = CKEDITOR.replace('editor1', {
            extraAllowedContent: 'div',
            height: 150
        });

        var editorLang = CKEDITOR.replace('editorLang', {
            extraAllowedContent: 'div',
            height: 150
        });

        var editorInterest = CKEDITOR.replace('editorInterest', {
            extraAllowedContent: 'div',
            height: 150
        });
    </script>

@endsection
