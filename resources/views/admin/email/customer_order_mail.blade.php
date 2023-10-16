<h2>Your Order Info </h2>
<br>

<strong>Order details: </strong><br>
<strong>Service Name: </strong>{{ $order->services->service_name }} <br>
<strong>Package Name: </strong>{{ $order->packages->package_name }} <br>

<strong>Order Id: </strong>{{ $data->id }} <br><br>
<strong>Total Price: </strong>{{ $data->total_price }}$ <br><br>
<strong>Order Date: </strong>{{ $data->created_at }} <br><br>
<a class="btn btn-info"
href="{{ route('invoice', $data->id) }}">Download invoice</a>
{{-- <strong>Order Full Details Link: </strong><a href="{{ route('admin.order_show',$data->id) }}"></a> <br><br> --}}
