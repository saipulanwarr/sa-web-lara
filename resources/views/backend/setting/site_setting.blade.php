@extends('admin.master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="content">

    <!-- Start Content-->
    <div class="container-xxl">

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Update Site Setting</h4>
            </div>
        </div>

        <!-- Form Validation -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Update Site Setting</h5>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <form class="row g-3" method="POST" action="{{route('update.site.setting')}}">
                            @csrf
                            <input type="hidden" name="id" value="{{$site->id}}" />
                            <div class="col-md-6">
                                <label for="validationDefault01" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="{{$site->email}}">
                            </div>
                            <div class="col-md-6">
                                <label for="validationDefault01" class="form-label">Phone</label>
                                <input type="text" class="form-control" name="phone" value="{{$site->phone}}">
                            </div>
                            <div class="col-md-6">
                                <label for="validationDefault01" class="form-label">Facebook</label>
                                <input type="text" class="form-control" name="facebook" value="{{$site->facebook}}">
                            </div>
                            <div class="col-md-6">
                                <label for="validationDefault01" class="form-label">Youtube</label>
                                <input type="text" class="form-control" name="youtube" value="{{$site->youtube}}">
                            </div>
                            <div class="col-md-12">
                                <label for="validationDefault01" class="form-label">Footer Message</label>
                                <textarea class="form-control" placeholder="Footer Message" name="footer_message">{{$site->footer_message}}</textarea>
                            </div>
                            <div class="col-md-12">
                                <label for="validationDefault01" class="form-label">Address</label>
                                <textarea class="form-control" placeholder="Address" name="address">{{$site->address}}</textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Save Changes</button>
                            </div>
                        </form>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>

    </div> <!-- container-fluid -->

</div> <!-- content -->

<script type="text/javascript">
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        })
    })
</script>

@endsection