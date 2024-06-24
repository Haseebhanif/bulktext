<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;


class Controller extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    protected $tldPrefix;
    protected $domain;
    public function __construct()
    {
        $host = \request()->getHost();
        $this->domain  = $host;


        if (Str::contains($host, 'moloffical.club')) {
            $prefix = str_replace(['.','-'],'',$host);
            $this->tldPrefix =  $prefix;
            // You can also share data directly with views across all controllers
            view()->share('prefix', $this->tldPrefix);
            view()->share('domain', $this->domain);
        }else{
            $this->tldPrefix =  null;
        }
    }
}
