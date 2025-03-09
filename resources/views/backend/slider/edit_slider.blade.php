@extends('admin.master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="content">

    <!-- Start Content-->
    <div class="container-xxl">

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Edit Slider</h4>
            </div>
        </div>

        <!-- Form Validation -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Edit Slider</h5>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <form class="row g-3" method="POST" action="{{route('update.slider')}}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$slider->id}}" />
                            <div class="col-md-6">
                                <label for="validationDefault01" class="form-label">Slider Heading</label>
                                <input type="text" class="form-control" name="heading" value="{{$slider->heading}}">
                            </div>
                            <div class="col-md-6">
                                <label for="validationDefault01" class="form-label">Slider Link</label>
                                <input type="text" class="form-control" name="link" value="{{$slider->link}}">
                            </div>
                            <div class="col-md-12">
                                <label for="validationDefault01" class="form-label">Slider Description</label>
                                <textarea class="form-control" placeholder="Slider description" name="description">{{$slider->description}}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="validationDefault01" class="form-label">Slider Image</label>
                                <input type="file" class="form-control" name="image" id="image">
                            </div>
                            <div class="col-md-6">
                                <img id="showImage" src="{{ asset('upload/slider/'.$slider->image)}}" class="rounded-circle avatar-xxl img-thumbnail float-start" alt="image profile">
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