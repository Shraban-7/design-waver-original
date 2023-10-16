@extends('admin.master')
@section('title', 'Admin Order List')
@section('meta_keywords', 'DesignWavers')
@section('meta_description', 'DesignWavers')

@section('content')


    @if ($message = Session::get('alert'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif
    <div class="wrapper">



        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Dashboard</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                </li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-12 connectedSortable">

                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <h3 class="card-title col-lg-4">Order List</h3>

                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="tabs-to-dropdown">
                                        <div class="nav-wrapper d-flex align-items-center justify-content-between">
                                            <ul class="nav nav-pills d-none d-md-flex" id="pills-tab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link active" id="pills-company-tab" data-toggle="pill"
                                                        href="#processing" role="tab" aria-controls="pills-company"
                                                        aria-selected="true">Processing (<b id="processing_count">{{ $processing }}</b>)</a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link" id="pills-product-tab" data-toggle="pill"
                                                        href="#pending" role="tab" aria-controls="pills-product"
                                                        aria-selected="false">Pending (<b id="pending_count">{{ $pending }}</b>)</a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link" id="pills-news-tab" data-toggle="pill"
                                                        href="#completed" role="tab" aria-controls="pills-news"
                                                        aria-selected="false">Completed (<b id="complete_count">{{ $complete }}</b>)</a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link" id="pills-contact-tab" data-toggle="pill"
                                                        href="#decline" role="tab" aria-controls="pills-contact"
                                                        aria-selected="false">Decline (<b id="decline_count">{{ $decline }}</b>)</a>
                                                </li>
                                            </ul>


                                        </div>

                                        <div class="tab-content mt-3" id="pills-tabContent">
                                            <div class="tab-pane fade show active" id="processing" role="tabpanel"
                                                aria-labelledby="pills-company-tab">
                                                <div class="container-fluid">
                                                    <h4 class=" font-weight-bold">Processing Orders</h4>
                                                    <div class="table-responsive">
                                                        <table id="example3" data-order='[[ 1, "desc" ]]'
                                                            class="table table-bordered border-1">
                                                            <thead class="thead-light">
                                                                <tr>
                                                                    <th scope="col">ID</th>
                                                                    <th scope="col">Price</th>
                                                                    <th scope="col">C Name</th>
                                                                    <th scope="col">TxID</th>
                                                                    <th scope="col">Status</th>

                                                                    <th scope="col">Delivery Time</th>
                                                                    <th scope="col">Details</th>

                                                                    <th scope="col">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $i = 1;
                                                                @endphp
                                                                @foreach ($ordersPackage_processing as $data)
                                                                    <tr id="processing_{{ $i }}">
                                                                        <td>{{ $data->order_id }}</td>

                                                                        <td>
                                                                            {{ $data->total_price }}
                                                                            @if ($data->currency == 'BDT')
                                                                                <small>BDT</small>
                                                                            @else
                                                                                $
                                                                            @endif
                                                                        </td>
                                                                        <td>{{ $data->customer_name }}</td>

                                                                        <td>{{ $data->tx_id }}</td>

                                                                        <td>
                                                                            @if ($data->payment_status == 0)
                                                                                Un Paid
                                                                            @else
                                                                                Paid
                                                                            @endif
                                                                        </td>
                                                                        @php
                                                                            $start_date = \Carbon\Carbon::parse($data->start_at);
                                                                            $deliveryTimeInDays = $data->delivery_time;
                                                                            $expire_date = $start_date->copy()->addDays($deliveryTimeInDays);

                                                                            $remaining = $expire_date->diff(\Carbon\Carbon::now());
                                                                            $daysLeft = $remaining->d;
                                                                            $hoursLeft = $remaining->h;

                                                                            $current_date = \Carbon\Carbon::now();
                                                                        @endphp

                                                                        <td>
                                                                            @if ($expire_date <= $current_date)
                                                                                <span>
                                                                                    Order Delivery Time expired
                                                                                </span>
                                                                            @else
                                                                                <span>
                                                                                    @if ($daysLeft > 0)
                                                                                        {{ $daysLeft }}
                                                                                        day{{ $daysLeft > 1 ? 's' : '' }}
                                                                                    @endif

                                                                                    @if ($hoursLeft > 0)
                                                                                        {{ $hoursLeft }}
                                                                                        hour{{ $hoursLeft > 1 ? 's' : '' }}
                                                                                    @endif

                                                                                    left
                                                                                </span>
                                                                            @endif
                                                                        </td>


                                                                        <td>
                                                                            <a class="btn btn-primary col-span-12 align-middle"
                                                                                href="{{ route('admin.order_show', $data->order_id) }}">View</a>
                                                                        </td>
                                                                        <td class="d-flex">
                                                                            <a class="btn btn-success m-1"
                                                                                href="{{ route('admin.order_edit', $data->order_id) }}"><i
                                                                                    class="fas fa-edit"></i></a>

                                                                            <a class="btn btn-danger m-1"
                                                                                onclick="delete_order('processing',{{ $i }},{{ $data->order_id }});"><i
                                                                                    class="fas fa-trash-alt"></i></a>

                                                                            <a class="btn btn-info m-1"
                                                                                href="{{ route('invoice', $data->order_id) }}"><i
                                                                                    class="fas fa-download"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                    @php
                                                                        $i++;
                                                                    @endphp
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="pending" role="tabpanel"
                                                aria-labelledby="pills-product-tab">
                                                {{-- testing
                                            @php
                                            echo "
                                            <pre>";($ordersPackage_pending); echo "</pre>";
                                            exit;
                                            @endphp --}}
                                                <div class="container-fluid">
                                                    <h4 class=" font-weight-bold">Pending Orders</h4>
                                                    <div class="table-responsive">
                                                        <table id="example1" data-order='[[ 1, "desc" ]]'
                                                            class="table table-bordered border-1">
                                                            <thead class="thead-light">
                                                                <tr>
                                                                    <th scope="col">ID</th>
                                                                    <th scope="col">Price</th>
                                                                    <th scope="col">C Name</th>
                                                                    <th scope="col">TxID</th>
                                                                    <th scope="col">Status</th>

                                                                    <th scope="col">Delivery Time</th>

                                                                    <th scope="col">Details</th>
                                                                    <th scope="col">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $i = 1;
                                                                @endphp
                                                                @foreach ($ordersPackage_pending as $data)
                                                                    <tr id="pending_{{ $i }}">
                                                                        <td>{{ $data->order_id }}</td>

                                                                        <td>
                                                                            {{ $data->total_price }}
                                                                            @if ($data->currency == 'BDT')
                                                                                <small>BDT</small>
                                                                            @else
                                                                                $
                                                                            @endif
                                                                        </td>
                                                                        <td>{{ $data->customer_name }}</td>

                                                                        <td>{{ $data->tx_id }}</td>
                                                                        <td>
                                                                            @if ($data->payment_status == 0)
                                                                                Un Paid
                                                                            @else
                                                                                Paid
                                                                            @endif
                                                                        </td>

                                                                        @php
                                                                            $start_date = \Carbon\Carbon::parse($data->start_at);
                                                                            $deliveryTimeInDays = $data->delivery_time;
                                                                            $expire_date = $start_date->copy()->addDays($deliveryTimeInDays);

                                                                            $remaining = $expire_date->diff(\Carbon\Carbon::now());
                                                                            $daysLeft = $remaining->d;
                                                                            $hoursLeft = $remaining->h;

                                                                            $current_date = \Carbon\Carbon::now();
                                                                        @endphp

                                                                        <td>
                                                                            @if ($expire_date <= $current_date)
                                                                                <span>
                                                                                    Order Delivery Time expired
                                                                                </span>
                                                                            @else
                                                                                <span>
                                                                                    @if ($daysLeft > 0)
                                                                                        {{ $daysLeft }}
                                                                                        day{{ $daysLeft > 1 ? 's' : '' }}
                                                                                    @endif

                                                                                    @if ($hoursLeft > 0)
                                                                                        {{ $hoursLeft }}
                                                                                        hour{{ $hoursLeft > 1 ? 's' : '' }}
                                                                                    @endif

                                                                                    left
                                                                                </span>
                                                                            @endif
                                                                        </td>


                                                                        <td>
                                                                            <a class="btn btn-primary col-span-12 align-middle"
                                                                                href="{{ route('admin.order_show', $data->order_id) }}">View</a>
                                                                        </td>
                                                                        <td class="d-flex">
                                                                            <a class="btn btn-success m-1"
                                                                                href="{{ route('admin.order_edit', $data->order_id) }}"><i
                                                                                    class="fas fa-edit"></i></a>

                                                                            <a class="btn btn-danger m-1"
                                                                                onclick="delete_order('pending',{{ $i }},{{ $data->order_id }});"><i
                                                                                    class="fas fa-trash-alt"></i></a>

                                                                            <a class="btn btn-info m-1"
                                                                                href="{{ route('invoice', $data->order_id) }}"><i
                                                                                    class="fas fa-download"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                    @php
                                                                        $i++;
                                                                    @endphp
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="completed" role="tabpanel"
                                                aria-labelledby="pills-news-tab">
                                                <div class="container-fluid">
                                                    <h4 class=" font-weight-bold">Completed Orders</h4>
                                                    <div class="table-responsive">
                                                        <table id="example2" data-order='[[ 1, "desc" ]]'
                                                            class="table table-bordered border-1">
                                                            <thead class="thead-light">
                                                                <tr>
                                                                    <th scope="col">ID</th>
                                                                    <th scope="col">Price</th>
                                                                    <th scope="col">C Name</th>
                                                                    <th scope="col">TxID</th>
                                                                    <th scope="col">Status</th>

                                                                    <th scope="col">Delivery Time</th>
                                                                    <th scope="col">Details</th>
                                                                    <th scope="col">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $i = 1;
                                                                @endphp
                                                                @foreach ($ordersPackage_complete as $data)
                                                                    <tr id="complete_{{ $i }}">
                                                                        <td>{{ $data->order_id }}</td>

                                                                        <td>
                                                                            {{ $data->total_price }}
                                                                            @if ($data->currency == 'BDT')
                                                                                <small>BDT</small>
                                                                            @else
                                                                                $
                                                                            @endif
                                                                        </td>
                                                                        <td>{{ $data->customer_name }}</td>
                                                                        <td>{{ $data->tx_id }}</td>

                                                                        <td>
                                                                            @if ($data->payment_status == 0)
                                                                                Un Paid
                                                                            @else
                                                                                Paid
                                                                            @endif
                                                                        </td>




                                                                        <td>
                                                                            complete
                                                                        </td>


                                                                        <td>
                                                                            <a class="btn btn-primary col-span-12 align-middle"
                                                                                href="{{ route('admin.order_show', $data->order_id) }}">View</a>
                                                                        </td>
                                                                        <td class="d-flex">
                                                                            <a class="btn btn-success m-1"
                                                                                href="{{ route('admin.order_edit', $data->order_id) }}"><i
                                                                                    class="fas fa-edit"></i></a>

                                                                            <a class="btn btn-danger m-1"
                                                                                onclick="delete_order('complete',{{ $i }},{{ $data->order_id }});"><i
                                                                                    class="fas fa-trash-alt"></i></a>

                                                                            <a class="btn btn-info m-1"
                                                                                href="{{ route('invoice', $data->order_id) }}"><i
                                                                                    class="fas fa-download"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                    @php
                                                                        $i++;
                                                                    @endphp
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="decline" role="tabpanel"
                                                aria-labelledby="pills-contact-tab">
                                                <div class="container-fluid">
                                                    <h4 class=" font-weight-bold">Decline Orders</h4>
                                                    <div class="table-responsive">
                                                        <table id="example4" data-order='[[ 1, "desc" ]]'
                                                            class="table table-bordered border-1">
                                                            <thead class="thead-light">
                                                                <tr>
                                                                    <th scope="col">ID</th>
                                                                    <th scope="col">Price</th>
                                                                    <th scope="col">C Name</th>
                                                                    <th scope="col">TxID</th>
                                                                    <th scope="col">Status</th>

                                                                    <th scope="col">Delivery Time</th>

                                                                    <th scope="col">Details</th>
                                                                    <th scope="col">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $i = 1;
                                                                @endphp
                                                                @foreach ($ordersPackage_decline as $data)
                                                                    <tr id="declient_{{ $i }}">
                                                                        <td>{{ $data->order_id }}</td>

                                                                        <td>
                                                                            {{ $data->total_price }}
                                                                            @if ($data->currency == 'BDT')
                                                                                <small>BDT</small>
                                                                            @else
                                                                                $
                                                                            @endif
                                                                        </td>
                                                                        <td>{{ $data->customer_name }}</td>
                                                                        <td>{{ $data->tx_id }}</td>

                                                                        <td>
                                                                            @if ($data->payment_status == 0)
                                                                                Un Paid
                                                                            @else
                                                                                Paid
                                                                            @endif
                                                                        </td>




                                                                        <td>
                                                                            Declined
                                                                        </td>


                                                                        <td>
                                                                            <a class="btn btn-primary col-span-12 align-middle"
                                                                                href="{{ route('admin.order_show', $data->order_id) }}">View</a>
                                                                        </td>
                                                                        <td class="d-flex">
                                                                            <a class="btn btn-success m-1"
                                                                                href="{{ route('admin.order_edit', $data->order_id) }}"><i
                                                                                    class="fas fa-edit"></i></a>

                                                                            <a class="btn btn-danger m-1"
                                                                                onclick="delete_order('declint',{{ $i }},{{ $data->order_id }});"><i
                                                                                    class="fas fa-trash-alt"></i></a>

                                                                            <a class="btn btn-info m-1"
                                                                                href="{{ route('invoice', $data->order_id) }}"><i
                                                                                    class="fas fa-download"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                    @php
                                                                        $i++;
                                                                    @endphp
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>

                        </section>
                        <!-- /.card-body -->
                    </div>

                </div>
                <!-- /.card -->
            </section>

            <!-- right col -->
        </div>
        <!-- /.row (main row) -->
    </div>

    <!-- /.row -->


    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                order: ['ids', 'desc'],
                "lengthMenu": [
                    [200, "All", 100, 50, 25],
                    [200, "All", 100, 50, 25]
                ]
            })
        });
        $(function() {
            $("#example2").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                order: ['ids', 'desc'],
                "lengthMenu": [
                    [200, "All", 100, 50, 25],
                    [200, "All", 100, 50, 25]
                ]
            });
        });
        $(function() {
            $("#example3").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                order: ['ids', 'desc'],
                "lengthMenu": [
                    [200, "All", 100, 50, 25],
                    [200, "All", 100, 50, 25]
                ]
            });
        });
        $(function() {
            $("#example4").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                order: ['ids', 'desc'],
                "lengthMenu": [
                    [200, "All", 100, 50, 25],
                    [200, "All", 100, 50, 25]
                ]
            });
        });

        function delete_order(type, table_row_id, order_id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed the deletion
                    $.ajax({
                        url: "order_delete/" + order_id,
                        method: "GET",
                        success: function(response) {
                            // Handle the successful response
                            console.log(response);
                            // Remove the table row on success
                            $('#' + type + '_' + table_row_id).closest('tr').remove();
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            );
                            $('#processing_count').html(response.processing);
                            $('#pending_count').html(response.pending);
                            $('#complete_count').html(response.complete);
                            $('#decline_count').html(response.decline);
                        },
                        error: function(xhr, error) {
                            // Handle the error
                            console.log(error);
                            Swal.fire(
                                'Error!',
                                'An error occurred while deleting the order.',
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>

    {{--  --}}
@endsection
