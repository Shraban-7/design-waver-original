<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Mail\OrderMail;
use App\Models\OrderPackage;
use Illuminate\Http\Request;
use App\Mail\CustomerOrderMail;
use Illuminate\Support\Facades\Mail;


class PaymentController extends Controller
{
    public function payment($id)
    {



        $order = Order::find($id);

        // $order->update([$order->payment_status=1]);

        $tran_id = "test" . rand(1111111, 9999999); //unique transection id for every transection 


        $currency = $order->currency; //aamarPay support Two type of currency USD & BDT  

        $amount = $order->total_price;   //10 taka is the minimum amount for show card option in aamarPay payment gateway

        //For live Store Id & Signature Key please mail to support@aamarpay.com
        // $store_id = "designwaver";//original
        $store_id = "aamarpaytest";

        // $signature_key = "5febcdd46bd195ce187e3576de66efec";//original
        $signature_key = "dbb74894e82415a2f7ff0ec3a97e4183"; //sandbox

        // $url = "https://secure.aamarpay.com/jsonpost.php"; 
        $url = "https://​sandbox​.aamarpay.com/jsonpost.php"; // for Live Transection use "https://secure.aamarpay.com/jsonpost.php"

        // URL: https://secure.aamarpay.com/request.php

// Merchant ID: designwaver

// Store ID: designwaver

// Signature Key: 5febcdd46bd195ce187e3576de66efec

        // for Live Transection use "https://secure.aamarpay.com/jsonpost.php"

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "store_id": "' . $store_id . '",
            "tran_id": "' . $tran_id . '",
            "success_url": "' . route('success') . '",
            "fail_url": "' . route('fail') . '",
            "cancel_url": "' . route('cancel') . '",
            "amount": "' . $amount . '",
            "currency": "' . $currency . '",
            "signature_key": "' . $signature_key . '",
            "opt_a": "' . $order->id . '",
            "desc": "Design Waver Order Payment",
            "cus_name": "' . $order->customer_name . '",
            "cus_email":"' . $order->customer_email . '",
            "cus_phone": "' . $order->customer_phone . '",
            "type": "json"
        }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // dd($response);

        $responseObj = json_decode($response);

        if (isset($responseObj->payment_url) && !empty($responseObj->payment_url)) {

            $paymentUrl = $responseObj->payment_url;
            // dd($paymentUrl);
            return redirect()->away($paymentUrl);
        } else {
            echo $response;
        }
    }

    public function success(Request $request)
    {

        $request_id = $request->mer_txnid;




        //verify the transection using Search Transection API 

        // $url = "http://secure.aamarpay.com/api/v1/trxcheck/request.php?request_id=$request_id&store_id=aamarpaytest&signature_key=dbb74894e82415a2f7ff0ec3a97e4183&type=json";


        $url = "http://sandbox.aamarpay.com/api/v1/trxcheck/request.php?request_id=$request_id&store_id=aamarpaytest&signature_key=dbb74894e82415a2f7ff0ec3a97e4183&type=json";//sandbox

        //For Live Transection Use "http://secure.aamarpay.com/api/v1/trxcheck/request.php"

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $result= json_decode($response);
        // print_r($result);
        // echo $request->pg_txnid;
        // echo $result->payment_processor;
        // echo $result->payment_type;


        $order_id = $result->opt_a;

       echo $order_id;
        $order=Order::find($order_id);

        // print_r($order);
        $order->update([
            'payment_status'=>1,
            'tx_id'=> $request->pg_txnid,
            'payment_processor'=>$result->payment_processor,
            'payment_type'=>$result->payment_type
        ]);
        $order_mail = Order::where('id', $order_id)->first();
        $order_package_mail = OrderPackage::where('order_id', $order_id)->first();
        Mail::to('infodesignwaver@gmail.com')->send(new OrderMail($order_mail));
        Mail::to($order->customer_email)->send(new CustomerOrderMail($order_mail, $order_package_mail));
        //  print_r($result);
        //  currency_merchant
        return redirect()->route('customer_order_list');

    }

    public function fail(Request $request)
    {
        return $request;
    }

    public function cancel()
    {
        return 'Canceled';
    }


    public function checkout(Order $order)
    {
    }
}
