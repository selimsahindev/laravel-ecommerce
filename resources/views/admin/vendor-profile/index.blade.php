@extends('admin.layouts.master')

@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Vendors</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Update Vendor Profile</h4>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('admin.vendor-profile.store') }}" method="POST"
                                enctype="multipart/form-data">
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
                                    <input type="text" class="form-control" name="phone" value="{{ $profile->phone }}">
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" name="email" value="{{ $profile->email }}">
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
    </section>
@endsection
