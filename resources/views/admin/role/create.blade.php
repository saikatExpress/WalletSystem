@extends('layout.app')
@section('content')
    <section class="section">
        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="page_head">
                        <a class="btn btn-sm btn-primary" href="{{ route('role.list') }}">Role List</a>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Role Info</h4>
                        </div>

                        @if(session('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif

                        <form action="{{ route('role.store') }}" method="post">
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label>Role Name</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-regular fa-user"></i>
                                            </div>
                                        </div>
                                        <input type="text" name="name" class="form-control">
                                    </div>
                                    @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="">Permission</label>
                                    <div class="d-flex justify-content-around">
                                        @foreach ($permissions as $key => $permission)
                                            <div>
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"> <span>{{ $permission->name }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('permissions')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <input type="submit" class="btn btn-sm btn-primary" value="Save Role">

                            </div>
                        </form>

                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection
