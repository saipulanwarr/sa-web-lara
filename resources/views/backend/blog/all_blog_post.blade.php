@extends('admin.master')
@section('admin')

<div class="content">

    <!-- Start Content-->
    <div class="container-xxl">

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">All Blog Post</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <a href="{{route('add.service')}}" class="btn btn-primary">Add Blog Post</a>
                </ol>
            </div>
        </div>

        <!-- Datatables  -->
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Category</th>
                                    <th>Image</th>
                                    <th>Post Title</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($blogpost as $key => $item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$item->blogcat_id}}</td>
                                        <td><img src="{{ asset('upload/blog/'.$item->image) }}" style="width: 70px; height: 40px;" /></td>
                                        <td>{{$item->post_title}}</td>
                                        <td>{{ Str::limit($item->long_dscp, 30)}}</td>
                                        <td>
                                            <a href="{{route('edit.service', $item->id)}}" class="btn btn-success btn-sm">Edit</a>
                                            <a href="{{route('delete.service', $item->id)}}" class="btn btn-danger btn-sm" id="delete">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div> <!-- container-fluid -->
</div> <!-- content -->

@endsection