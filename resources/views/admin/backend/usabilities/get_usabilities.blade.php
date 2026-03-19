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
                        <h5 class="card-title mb-0">Get Usabilities</h5>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Youtube Link</th>
                                    <th>Link</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usabilities as $key => $usability)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $usability->title }}</td>
                                        <td>{{ Str::limit($usability->description, 30, '...') }}</td>
                                        <td>{{ Str::limit($usability->youtube, 20, '...') }}</td>
                                        <td>{{ $usability->link }}</td>
                                        <td><img src="{{ asset($usability->image) }}"
                                                style="width: 60px; height: 60px; border-radius: 10px;"
                                                alt="{{ $usability->title }}"></td>
                                        <td>
                                            <a href="{{ route('edit.usability', $usability->id) }}"
                                                class="btn btn-primary btn-sm">Edit</a>
                                            <a href="{{ route('edit.usability', $usability->id) }}" id="delete"
                                                class="btn btn-danger btn-sm">Delete</a>
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