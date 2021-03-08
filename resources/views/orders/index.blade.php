@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="btn-group float-right" role="group">
                            <a href="{{ route('orders.create',['companies_id'=>$companies_id]) }}"
                               class="btn btn-success">Add new</a>
                        </div>
                        <h2>
                            Orders
                        </h2>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered" id="posts">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Text</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                        </table>

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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>

    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#posts').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax":{
                    "url": "{{ route('orders_ajax') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{
                        _token: "{{csrf_token()}}"
                    }
                },
                "columns": [
                    { "data": "id" },
                    { "data": "name" },
                    { "data": "price" },
                    { "data": "text" },
                    { "data": "created_at" },
                    { "data": "options" }
                ]

            });
        });
    </script>
@endsection
