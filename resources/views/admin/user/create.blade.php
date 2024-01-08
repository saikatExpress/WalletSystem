@extends('layout.app')
@section('content')
    <section class="section">
        <div class="section-body">


            <div class="row">
                <div class="col-12">
                    <div class="page_head">
                        <a class="btn btn-sm btn-primary" href="">User List</a>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>User Info</h4>
                        </div>

                        @if(session('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif

                        <form action="{{ route('user.store') }}" method="post">
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label>User Name</label>
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
                                    <label>User Email</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-solid fa-envelope"></i>
                                            </div>
                                        </div>
                                        <input type="email" name="email" class="form-control">
                                    </div>
                                    @error('email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-phone"></i>
                                            </div>
                                        </div>
                                        <input type="text" name="phone_number" class="form-control">
                                    </div>
                                    @error('phone_number')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Password Strength</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-lock"></i>
                                            </div>
                                        </div>
                                        <input type="password" name="password" class="form-control pwstrength" data-indicator="pwindicator">
                                    </div>
                                    <div id="pwindicator" class="pwindicator">
                                        <div class="bar"></div>
                                        <div class="label"></div>
                                    </div>
                                    @error('password')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Status</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-solid fa-signal"></i>
                                            </div>
                                        </div>
                                        <select name="status" id="" class="form-control">
                                            <option value="1">Active</option>
                                            <option value="0">Non Active</option>
                                        </select>
                                    </div>
                                    @error('status')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Role</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-solid fa-chart-line"></i>
                                            </div>
                                        </div>
                                        <select name="role" id="" class="form-control">
                                            <option value="admin">Admin</option>
                                            <option value="super-admin">Super Admin</option>
                                        </select>
                                    </div>
                                    @error('role')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <input type="submit" class="btn btn-sm btn-primary" value="Save User">

                            </div>
                        </form>

                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                    <div class="card-header">
                        <h4>User List</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                        <table class="table table-striped table-md">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Created At</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>

                            @php
                                $sl = 1;
                            @endphp

                            @foreach ($users as $key => $user)
                                <tr>
                                    <td>{{ $sl }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ defaultDate($user->created_at) }}</td>
                                    <td>
                                        @if ($user->status == '1')
                                            <div class="badge badge-success">Active</div>
                                        @else
                                            <div class="badge badge-danger">Non Active</div>
                                        @endif
                                    </td>
                                    <td><a href="{{ route('user.detail' , ['id' => $user->id]) }}" class="btn btn-primary">Detail</a></td>
                                </tr>
                                @php
                                    $sl++;
                                @endphp
                            @endforeach

                        </table>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <nav class="d-inline-block">
                        <ul class="pagination mb-0">
                            <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1 <span
                                class="sr-only">(current)</span></a></li>
                            <li class="page-item">
                            <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                            <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                            </li>
                        </ul>
                        </nav>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
