<?php

namespace App\Http\Controllers;

use AshAllenDesign\ShortURL\Models\ShortURL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OptoutController extends Controller
{



    public function destination($id){


        $uri =   DB::table('short_urls')->where('url_key',$id)->first();
        if(!$uri){
            abort(404);
        }
        $url = $uri->destination_url;

// We will find the position right after "/optout/"
        $prefix = "/optout/";
        $position = strpos($url, $prefix);

        if ($position !== false) {
            // Adjust position to start after "/optout/"
            $startPosition = $position + strlen($prefix);
            // Extract everything from the start position to the end of the URL
            return substr($url, $startPosition);

        } else {
            return null;
        }


    }


    public function form($id)
    {

        $encrypted = $this->destination($id);

        try {

            $Cid = Crypt::decryptString($encrypted);
            DB::table('contacts')->where('id',$Cid)->update((['active'=>false]));

        }catch (\Throwable $throwable){
dd($throwable);
            return redirect(env('MAIN_SUBDOMAIN'));
        }


        return view('optouts.form',[
            'reference'=>Crypt::encrypt($Cid)
        ]);
    }

    public function optOutUpdate($id,Request $request){

        $this->validate($request, [
            'reason'=>'required'
        ]);
        $decryptedValue = Crypt::decryptString($id);
        // Unserialize the decrypted value
        $unserializedValue = unserialize($decryptedValue);
        try {
          //  $idTest =(string) Crypt::decryptString($id);



            Log::info('OPT OUT'.$unserializedValue.' REASON'.$request->reason);


          DB::table('contacts')
             ->where("id",$unserializedValue)->update(['optout_reason'=>$request->reason]);


            return view('optouts.done');

        }catch (\Throwable $throwable){
            dd($throwable);
            return view('optouts.done');
        }


    }

    public function bye(Request $request){

        return view('optouts.done');
    }


}
