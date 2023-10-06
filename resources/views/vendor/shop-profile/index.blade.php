@extends('vendor.layouts.master')

@section('content')
    <section id="wsus__dashboard">
        <div class="container-fluid">
            @include('vendor.layouts.sidebar')

            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="far fa-user"></i> profile</h3>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group">
                                        <label>Preview</label>
                                        <br>
                                        <img height="200" src="{{ asset($profile->banner) }}" alt="Profile banner image">
                                    </div>

                                    <div class="form-group">
                                        <label>Banner</label>
                                        <input type="file" class="form-control" name="banner">
                                    </div>

                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" class="form-control" name="phone"
                                            value="{{ $profile->phone }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" name="email"
                                            value="{{ $profile->email }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="address"
                                            value="{{ $profile->address }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="summernote" name="description" cols="30" rows="10">{{ $profile->description }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Facebook</label>
                                        <input type="text" class="form-control" name="facebook_link"
                                            value="{{ $profile->facebook_link }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Twitter</label>
                                        <input type="text" class="form-control" name="twitter_link"
                                            value="{{ $profile->twitter_link }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Instagram</label>
                                        <input type="text" class="form-control" name="instagram_link"
                                            value="{{ $profile->instagram_link }}">
                                    </div>

                                    <button type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
