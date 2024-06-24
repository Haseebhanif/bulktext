<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripePaymentController extends Controller
{



   public function index(){
       header('Cache-Control', 'no-cache, no-store, must-revalidate');
    return view('payments/gateways');
   }
}
