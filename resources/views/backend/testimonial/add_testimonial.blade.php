@extends('admin.master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="content">

    <!-- Start Content-->
    <div class="container-xxl">

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Add Testimonial</h4>
            </div>
        </div>

        <!-- Form Validation -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Add Testimonial</h5>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <form id="myForm" class="row g-3" method="POST" action="{{route('store.testimonial')}}">
                            @csrf
                            <div class="col-md-6 form-group">
                                <label for="validationDefault01" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="validationDefault01" class="form-label">Position</label>
                                <input type="text" class="form-control" name="position">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="validationDefault01" class="form-label">Message</label>
                                <textarea class="form-control" placeholder="Message" name="message"></textarea>
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
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                name: {
                    required : true,
                },  
                position: {
                    required : true,
                },
                message: {
                    required : true,
                },      
            },
            messages :{
                name: {
                    required : 'Please Enter Name',
                },  
                position: {
                    required : 'Please Enter Position',
                },  
                message: {
                    required : 'Please Enter Message',
                },      
            },
            errorElement : 'span', 
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });

</script>

@endsection