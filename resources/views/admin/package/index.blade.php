@extends('layout.app')
@section('content')
    <section class="section">
        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="page_head">
                        <a class="btn btn-sm btn-primary" href="{{ route('package.create') }}">Create Package</a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Package List</h4>
                        </div>
                        <div class="card-body">

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

                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sl = 1;
                                        @endphp
                                        @foreach ($packages as $key => $package)
                                            <tr class="list-item">
                                                <td>{{ $sl }}</td>
                                                <td>
                                                    <div class="image-container1">
                                                        <img class="thumbnail"
                                                            src="{{ asset('storage/' . $package->image) }}"
                                                            alt="Order Images">
                                                        <div class="popup">
                                                            <img src="{{ asset('storage/' . $package->image) }}"
                                                                alt="Order Images">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $package->name }}</td>
                                                <td>{{ $package->price }}</td>
                                                <td>{{ ucfirst($package->type) }}</td>
                                                <td>
                                                    @if ($package->status == '1')
                                                        <label for="" class="btn btn-sm btn-primary">
                                                            Active
                                                        </label>
                                                    @else
                                                        <label for="" class="btn btn-sm btn-warning">
                                                            Non Active
                                                        </label>
                                                    @endif
                                                </td>

                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-success dropdown-toggle" type="button"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            Options
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            {{-- <a href="{{ route('order.edit', ['id' => $package->id]) }}"
                                                                class="btn btn-sm btn-primary">
                                                                Edit
                                                            </a>
                                                            <button class="btn btn-sm btn-primary viewBtn"
                                                                data-target="#viewModal" data-toggle="modal"
                                                                data-id="{{ $order->order_no }}">
                                                                <i class="fas fa-regular fa-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-danger deleteButton"
                                                                data-id="{{ $order->id }}"><i
                                                                    class="fas fa-solid fa-trash"></i>
                                                            </button> --}}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @php
                                                $sl++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Show Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <!-- Add a button for saving changes if needed -->
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        $(document).ready(function() {
            $('.deleteButton').click(function() {
                var staff_id = $(this).data('id');
                var listItem = $(this).closest(
                    '.list-item'); // Adjust the selector based on your HTML structure

                // Use SweetAlert to confirm the deletion
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If the user confirms, send an AJAX request to delete the pigeon
                        $.ajax({
                            type: 'GET',
                            url: '/staff/delete/' + staff_id,
                            success: function(response) {
                                // Remove the deleted item from the DOM
                                listItem.remove();

                                // Show a success message
                                Swal.fire('Deleted!', response.message, 'success');
                            },
                            error: function(error) {
                                // Show an error message
                                Swal.fire('Error!', error.responseJSON.message,
                                    'error');
                            }
                        });
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.editBtn').click(function() {
                const staffData = {
                    id: $(this).data('id'),
                    name: $(this).data('name'),
                    categoryId: $(this).data('category_id'),
                    email: $(this).data('email'),
                    phone_number: $(this).data('phone_number'),
                    nid: $(this).data('nid'),
                    present_address: $(this).data('present_address'),
                    permanent_address: $(this).data('permanent_address'),
                    status: $(this).data('status')
                };

                // Set values to form fields
                $('input[name="staff_id"]').val(staffData.id);
                $('input[name="name"]').val(staffData.name);
                $('select[name="category_id"]').val(staffData.categoryId);
                $('input[name="email"]').val(staffData.email);
                $('input[name="phone_number"]').val(staffData.phone_number);
                $('input[name="nid"]').val(staffData.nid);
                $('input[name="present_address"]').val(staffData.present_address);
                $('input[name="permanent_address"]').val(staffData.permanent_address);
                $('select[name="status"]').val(staffData.status);

                // Open the modal
                $('#myModal').modal('show');
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $(".image-container1").hover(
                function() {
                    // On hover
                    $(this).find(".popup").fadeIn();
                },
                function() {
                    // On mouseout
                    $(this).find(".popup").fadeOut();
                }
            );
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.viewBtn').on('click', function() {
                var orderId = $(this).data('id');

                if (orderId != null) {
                    $.ajax({
                        url: '/get/cutting/master/info/' + orderId,
                        type: 'GET',
                        success: function(response) {

                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                }
            });
        });
    </script>
@endsection
