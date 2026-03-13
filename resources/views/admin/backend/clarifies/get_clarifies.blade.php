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
                        <h5 class="card-title mb-0">Get Clarifies</h5>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clarifies as $key => $clarify)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $clarify->title }}</td>
                                        <td>{{ Str::limit($clarify->description, 50, '...') }}</td>
                                        <td><img src="{{ asset($clarify->image) }}"
                                                style="width: 60px; height: 60px; border-radius: 10px;"
                                                alt="{{ $clarify->title }}"></td>
                                        <td>
                                            {{-- <a href="{{ route('edit.slider', $slider->id) }}"
                                                class="btn btn-primary btn-sm">Edit</a>
                                            <a href="{{ route('delete.slider', $slider->id) }}" id="delete"
                                                class="btn btn-danger btn-sm">Delete</a> --}}

                                            <a href="" class="btn btn-primary btn-sm">Edit</a>
                                            <a href="" id="delete" class="btn btn-danger btn-sm">Delete</a>
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