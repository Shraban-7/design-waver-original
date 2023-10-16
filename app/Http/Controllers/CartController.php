<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Service;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class CartController extends Controller
{
        // cart
 public function cartList()
 {
     $cartItems = Cart::getContent();

        //  dd($cartItems);
         return view('frontend.layouts.cart', compact(['cartItems']));
        // return view('dashboard', compact('cartItems'));
 }

 public function addToCart(Request $request)
 {

    $clientIP = $request->ip();
    // dd($clientIP);
    $ip=Location::get('118.179.34.11');
    // $ip=Location::get($clientIP);
    $country_code = $ip->countryCode;
     $package = Package::find($request->id);
    $service=Service::find($request->service_id);
    if ($country_code=='BD') {
            $price = $package->package_price_bdt;
    } else {
        $price = $package->package_price;
    }
    
    //echo '<pre>';print_r( $service->service_name);echo '</pre>';exit;
    if($package->offer_package_price != null&&$package->offer_price_start_date <= date('Y-m-d') && $package->offer_price_end_date >= date('Y-m-d')){
        Cart::add(array(
            'id' => $package->id,
            'service_id'=>$request->service_id,
            'service_name'=>$service->service_name,
            'name' => $package->package_name,
            'price' => $package->offer_package_price,
            'main_price' => $price,
            'quantity' => $request->quantity,
            'attributes' => array(),
            'associatedModel' => $package
        ));
    }else{
        Cart::add(array(
            'id' => $package->id,
            'service_id'=>$request->service_id,
            'service_name'=>$service->service_name,
            'name' => $package->package_name,
            'price' => $price,
            'main_price' => $price,
            'quantity' => $request->quantity,
            'attributes' => array(),
            'associatedModel' => $package
        ));
    }

     $total_quantity=Cart::getTotalQuantity();
     echo $total_quantity;
     session()->flash('success', 'Product is Added to Cart Successfully !');
    //  return redirect()->back();
    }

 public function updateCart(Request $request)
 {
    $current_quantity=$request->current_quantity;
    $update_quantity=$current_quantity+$request->quantity;
     Cart::update($request->id, array(
         'quantity' => array(
             'relative' => false,
             'value' => $update_quantity
         ),
     ));
     return redirect()->route('cartList')->with('success','Package updated successfully.');
 }

 public function removeCart($id)
 {
     Cart::remove($id);
     if(Cart::isEmpty()){
         return redirect()->route('home')->with('danger','Cart is empty.');
     }
     return redirect()->route('order')->with('success','Package removed successfully.');
 }

 public function clearCart()
 {
     Cart::clear();
     return redirect()->route('cartList')->with('success','Cart cleared successfully.');
 }
}
