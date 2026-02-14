@extends('admin.admin_master')
@section('admin')
    <div class="content">
        <div class="container-xxl">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h5 class="card-title mb-0">All Reviews</h5>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Image</th>
                                    <th>Message</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reviews as $review)
                                    <tr>
                                        <td>{{ $review->id }}</td>
                                        <td>{{ $review->name }}</td>
                                        <td>{{ $review->position }}</td>
                                        <td><img src="{{ asset($review->image) }}"
                                                style="width: 60px; height: 60px; border-radius: 10px;"
                                                alt="{{ $review->name }}"></td>
                                        <td>{{ Str::limit($review->message, 50, '...') }}</td>
                                        <td>
                                            <a href="" class="btn btn-primary btn-sm">Edit</a>
                                            <a href="" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection