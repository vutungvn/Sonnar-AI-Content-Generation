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
                        <h5 class="card-title mb-0">All Features</h5>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Icon</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($features as $key => $feature)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $feature->title }}</td>
                                        <td>{{ Str::limit($feature->description, 50, '...') }}</td>
                                        <td>{{ $feature->icon }}</td>
                                        <td>
                                            <a href="{{ route('edit.feature', $feature->id) }}"
                                                class="btn btn-primary btn-sm">Edit</a>
                                            <a href="{{ route('delete.feature', $feature->id) }}" id="delete"
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