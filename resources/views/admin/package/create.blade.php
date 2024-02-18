@extends('layout.app')
@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">

                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="card">
                        <form action="{{ route('package.store') }}" method="post" enctype="multipart/form-data"
                            class="needs-validation" novalidate="">
                            <div class="card-header">
                                <h4>Package Info</h4>
                            </div>
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Package Image</label>
                                    <input type="file" name="image" class="form-control" required="">
                                    <div class="invalid-feedback">
                                        What's your image?
                                    </div>
                                    @error('image')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Package Name</label>
                                    <input type="text" name="name" class="form-control" required="">
                                    <div class="invalid-feedback">
                                        What's your name?
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Package Price</label>
                                    <input type="text" name="price" class="form-control" required="">
                                    <div class="invalid-feedback">
                                        Oh no! Price is invalid.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Package Type</label>
                                    <select name="type" id="" class="form-control">
                                        <option value="">Select</option>
                                        <option value="silver">Silver</option>
                                        <option value="gold">Gold</option>
                                        <option value="platinum">Platinum</option>
                                    </select>
                                    <div class="valid-feedback">
                                        Good job!
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <label>Message</label>
                                    <textarea class="form-control" name="message" required=""></textarea>
                                    <div class="invalid-feedback">
                                        What do you wanna say?
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
