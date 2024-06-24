<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyManagment extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $manager = app('impersonate');
        // Leave current impersonation
        $manager->leave();
        return view('admin.companies');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function takeoverCompany($domain,User $user)
    {
       $current = Auth::user();
      // $re = Company::where('companies.creator_id',$id)->join('tenants','tenants.id','=','companies.tenant_id')->where('tenants.domain',$domain)->firstOrFail();
        $manager = app('impersonate');
        $manager->findUserById($user->id);
        $manager->take($current, $user);


        //Auth::user()->impersonate($user);

        return redirect()->route('dashboard',$domain);


    }

    public function takeoverCompanyTld(User $user)
    {
        $current = Auth::user();
        // $re = Company::where('companies.creator_id',$id)->join('tenants','tenants.id','=','companies.tenant_id')->where('tenants.domain',$domain)->firstOrFail();
        $manager = app('impersonate');
        $manager->findUserById($user->id);
        $manager->take($current, $user);

        //Auth::user()->impersonate($user);
        $domain = str_replace(['.' . env('DOMAIN'), 'https://', 'http://'], '', \url('/'));
        $prefix = str_replace(['.', '-'], '', $domain);

        return redirect()->route($prefix.'.dashboard',$this->domain);


    }

    public function leaveTakeoverCompany($domain)
    {
        $manager = app('impersonate');

        // Leave current impersonation
        $manager->leave();

        return redirect()->route('manage.companies',$domain);
    }

    public function leaveTakeoverCompanyTld()
    {
        $manager = app('impersonate');

        // Leave current impersonation
        $manager->leave();
        $domain = str_replace(['.' . env('DOMAIN'), 'https://', 'http://'], '', \url('/'));
        $prefix = str_replace(['.', '-'], '', $domain);

        return redirect()->route( $prefix.'.manage.companies',$this->domain);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
