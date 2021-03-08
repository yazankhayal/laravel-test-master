@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Contact</div>
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('contacts.create') }}">
                        @include('contacts.partials.form')

                        <div class="form-group element" id="address_0">
                            <label for="first_name" class="col-md-4 control-label">Post Code</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" id="post_code_0" name="post_code[]" placeholder="Post Code">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <button type="button" class="add btn btn-primary">
                                    Add plus address
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section("js")
    <script
        src="https://code.jquery.com/jquery-1.12.4.js"
        integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU="
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){

            // Add new element
            $(".add").click(function(){

                // Finding total number of elements added
                var total_element = $(".element").length;

                // last <div> with element class id
                var lastid = $(".element:last").attr("id");
                var split_id = lastid.split("_");
                var nextindex = Number(split_id[1]) + 1;

                var max = 9999;
                // Check total number elements
                if(total_element < max ){
                    // Adding new div container after last occurance of element class
                    $(".element:last").after("<div class='element form-group' id='div_"+ nextindex +"'></div>");

                    // Adding element to <div>
                    $("#div_" + nextindex).append("<div class='col-md-12'><input type='text' class='form-control' placeholder='Post Code' name='post_code[]' id='post_code_"+ nextindex +"'>&nbsp;<span id='remove_" + nextindex + "' class='remove'>X</span></div>");

                }

            });

            // Remove element
            $('.container').on('click','.remove',function(){

                var id = this.id;
                var split_id = id.split("_");
                var deleteindex = split_id[1];

                // Remove <div> with id
                $("#div_" + deleteindex).remove();

            });
        });
    </script>
@endsection
