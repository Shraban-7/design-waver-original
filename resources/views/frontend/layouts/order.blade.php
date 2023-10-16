@extends('frontend.layouts.master')
@section('title', 'Order')
@section('meta_keywords', 'DesignWavers')
@section('meta_description', 'DesignWavers')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.4.1/css/rowReorder.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" />
@section('order')
    <div class="container">
        <form action="{{ route('order_store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid lg:grid-cols-3 grid-cols-1">
                <div class="row-span-2 gap-3 max-w-7xl sm:px-3 lg:px-4">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div class="mx-10 lg:gap-3 sm:gap-y-3">
                                <h2 class="mb-6 text-2xl font-bold font-dm">Customer Details</h2>
                                <div class="mb-6">
                                    <label for="name" class="block mb-2 font-dm">Customer Name</label>
                                    <input type="text"
                                        class="bg-gray-50 border border-1 border-blue-500 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        name="customer_name" id="name" readonly value="{{ Auth::user()->name }}" />
                                </div>
                                <div class="mb-6">
                                    <label for="email" class="block mb-2 font-dm">Customer Email</label>
                                    <input type="email"
                                        class="ng-gray-50 border w-full border-1 border-blue-500 rounded-lg focus:ring-blue-500 focus:border-blue-500 block  p-2.5"
                                        name="customer_email" id="email" readonly value="{{ Auth::user()->email }}" />
                                </div>
                                <div class="mb-6">
                                    <label for="phone" class="block mb-2 font-dm">Customer Phone</label>
                                    <input type="text" name="customer_phone" id="phone"
                                        class="bg-gray-50 border border-blue-500 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 block w-full"
                                        value="{{ Auth::user()->phone }}" />
                                </div>


                                <div class="mb-6 capitalize font-dm">
                                    If you have any additional requirements, please upload them here. And if you have any
                                    questions please <a class="text-blue-500" href="{{ route('user.contact') }}">contact
                                        us</a>.
                                </div>

                                <div class="mb-6">

                                    <label class="block mb-2 text-sm font-medium text-gray-900 " for="file_input">Upload
                                        file</label>
                                    <input class="" id="file_input" name="requirement_file" type="file"
                                        value="" />
                                    <span class="mt-4 text-gray-500 text-xs-left">upload here your requirement file
                                        zip</span>

                                </div>
                                <div class="mb-6">


                                    <label for="message" class="block mb-2 text-sm font-medium text-gray-900 ">Your
                                        message</label>
                                    <textarea id="message" name="requirement_desc" rows="4"
                                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500  "
                                        placeholder="Write your thoughts here..."></textarea>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-2 max-w-7xl sm:px-6 lg:px-8">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div class="mx-10 lg:gap-6 sm:gap-y-3">
                                <h2 class="mb-6 text-2xl font-bold font-dm">Order Summary</h2>
                                <div class="relative overflow-x-auto">
                                    <div class="space-y-6">
                                        @php
                                            $total = 0;
                                        @endphp
                                        @foreach ($cart_item as $item)
                                            <div class="bg-white px-4 shadow-none rounded-lg">
                                                <div
                                                    class="flex flex-col md:flex-row md:space-y-5 md:items-center md:space-x-4">
                                                    <div class="flex-grow">
                                                        <div class="text-2xl text-gray-600 font-space mb-1">
                                                            {{ $item->service_name }}
                                                        </div>

                                                        <div id="coupon_tr" class="flex md:block text-sm md:baseline mb-2">
                                                            <div class="mb-2">

                                                            </div>
                                                        </div>
                                                        <div id="coupon_dis_tr"
                                                            class="flex md:block text-sm md:baseline mb-2">
                                                            <div class="mb-2">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="flex  space-x-2   md:items-center mt-2 md:mt-0">

                                                        <div class="flex-grow">

                                                            <h4 class="capitalize font-dm font-regular text-xl">
                                                                {{ $item->name }} </h4>

                                                        </div>
                                                        <div>
                                                            <a href="{{ route('removeCart', $item->id) }}"
                                                                class="text-gray-600 hover:underline"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" class="w-6 h-6">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                                </svg>
                                                            </a>
                                                        </div>

                                                    </div>
                                                </div>

                                                <input type="hidden" name="service_id" value="{{ $item->service_id }}">
                                                <input type="hidden" name="package_id" value="{{ $item->id }}">
                                            </div>
                                            @php
                                                $total = $total + $item->price * 1;
                                                // $total_with_vat=;
                                            @endphp
                                        @endforeach
                                        <div class="bg-white px-4 shadow-md rounded-lg">
                                            <div class="flex justify-between items-center">
                                                <div class="text-gray-700 font-bold">Price</div>
                                                <div class="text-xl font-regular" id="total_price_main">
                                                    @if ($item->price == $item->main_price)
                                                        {{ $item->price }}
                                                        @if ($country_code == 'BD')
                                                            BDT
                                                        @else
                                                            $
                                                        @endif
                                                    @else
                                                        <del>{{ $item->main_price }}@if ($country_code == 'BD')
                                                                BDT
                                                            @else
                                                                $
                                                            @endif
                                                        </del> {{ $item->price }}@if ($country_code == 'BD')
                                                            BDT
                                                        @else
                                                            $
                                                        @endif
                                                    @endif
                                                    {{-- @if ($country_code == 'BD')
                                                        BDT
                                                    @else
                                                        $
                                                    @endif --}}
                                                </div>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <div class="text-gray-700 font-bold">Platform Charge(2.5%)</div>
                                                <div class="flex text-xl font-regular text-gray-600" id="charge_amount">
                                                    <span class="mr-1">{{ $total * 0.025 }}</span>
                                                    @if ($country_code == 'BD')
                                                        <span>BDT</span>
                                                    @else
                                                        <span>$</span>
                                                    @endif
                                                </div>

                                            </div>

                                            <div>
                                                <hr class="my-12 h-0.5 border-t-0 bg-gray-300 opacity-100" />
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <div class="text-gray-700 font-bold text-xl">Total</div>
                                                <div class="text-xl font-bold text-gray-600 ">

                                                    <span id="total_amount_charge">{{ $total + $total * 0.025 }} </span>
                                                    @if ($country_code == 'BD')
                                                        BDT
                                                    @else
                                                        $
                                                    @endif
                                                </div>

                                            </div>
                                            <input type="hidden" name="total_price_value" id="total_price_value"
                                                value="{{ $total }}">
                                            <input type="hidden" name="coupon_code" id="coupon_code_token"
                                                value="">

                                            <input type="hidden" name="total_price" id="total_price"
                                                value="{{ $total }}">
                                            <input type="hidden" name="coupon_discount" id="coupon_discount"
                                                value="">

                                            <input type="hidden" name="coupon_type" id="coupon_type" value="">
                                            <input type="hidden" name="coupon_value" id="coupon_value" value="">
                                            <input type="hidden" id="currency" name="currency"
                                                @if ($country_code == 'BD') value="BDT" @else value="USD" @endif>


                                        </div>
                                    </div>



                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-2 mt-6">
                    <div class="max-w-7xl sm:px-6 lg:px-8">
                        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900">

                                <h2 class="mb-6 text-2xl font-bold font-dm">Payment option</h2>
                                <div class="container md:flex space-x-3">

                                    <label for="coupon_code" class="font-semibold mt-2">Apply Coupon</label>
                                    <input type="text" class=" border rounded-lg w-full md:w-[60%] mt-1"
                                        id="coupon_code">
                                    <button type="button"
                                        class="text-white font-dm  bg-blue-700  md:w-[20%]  hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mx-2 mt-1 "
                                        onclick="coupon_code_search();">Apply</button>
                                </div>


                                <div class="flex items-baseline justify-between md:mx-8 my-10">
                                    @if ($total != 0)
                                        <button
                                            class="w-full px-5 py-3 text-sm font-medium text-center text-white rounded-lg lg:ml-auto lg:w-full font-dm bg-skyBlue "
                                            type="submit">Checkout</button>
                                    @else
                                        <a class="w-full px-5 py-3 text-sm font-medium text-center text-white rounded-lg lg:ml-auto lg:w-full font-dm bg-skyBlue"
                                            href="{{ route('home') }}">Checkout</a>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.4.1/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <Script>
        new DataTable('#dataTable', {
            "bLengthChange": false,
            "bInfo": false,
            "bAutoWidth": true,
            "responsive": true,
            "rowReorder": {
                selector: 'td:nth-child(0)'
            },

        });





        function coupon_code_search() {
            var coupon_code = $('#coupon_code').val();
            var total_price_value = $('#total_price_value').val();
            //var total_price_value_tax = $('#total_price_main_tax').val();
            var currency = $('#currency').val();





            $.post("{{ route('coupon_check') }}", {
                'coupon_code': coupon_code,
                '_token': "{{ csrf_token() }}"
            }, function(result) {
                //alert(result);
                if (result.coupon_code) {
                    document.getElementById("coupon_code_token").value = result.coupon_code;
                    document.getElementById("coupon_type").value = result.coupon_type;
                    document.getElementById("coupon_value").value = result.coupon_value;









                    if (result.coupon_type == 'percent') {
                        var discount_amount = total_price_value * result.coupon_value / 100;

                        var total_price = total_price_value - Math.round(discount_amount);

                    } else {
                        var discount_amount = result.coupon_value;
                        var total_price = total_price_value - discount_amount;
                    }
                    document.getElementById("coupon_discount").value = result.discount_amount;
                    document.getElementById("total_price").value = total_price;
                    $('#coupon_tr').html('<span>Coupon Code: </span><span>' + coupon_code + '</span>');
                    if (result.coupon_type == 'percent') {
                        $('#coupon_dis_tr').html('<span>Coupon Discount:</span><span>' + Math.round(
                            discount_amount) + '' + currency + '(' + result.coupon_value + '%)</span>');
                    } else {
                        $('#coupon_dis_tr').html('<span>Coupon Discount: </span><span>' + discount_amount +
                            '$</span>');
                    }
                    $('#total_price_main').html('<del>' + total_price_value + '' + currency + '</del> ' +
                        total_price + '' + currency);
                    var charge_amount = (total_price * 0.025).toFixed(2);
                    var total_amount_charge = (total_price + (total_price * 0.025));
                    //alert(total_amount_charge);
                    $('#charge_amount').html('' + charge_amount + '');
                    $('#total_amount_charge').html('' + total_amount_charge + '');

                } else {
                    $('#coupon_tr').html('<td>' + result.error + '</td>');
                }

            });
        }
    </Script>
@endsection
