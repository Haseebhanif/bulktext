<?php

namespace App\Http\Controllers;

use App\Http\Traits\ChinaMobileAPI;
use Illuminate\Http\Request;

class TestController extends Controller
{
  use ChinaMobileAPI;


    public function index(){


      return  $this->testSMS();


    }

}
