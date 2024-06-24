<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRecordRequest;
use App\Http\Requests\UpdatePaymentRecordRequest;
use App\Models\PaymentRecord;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('payments.invoices',[
            'invoices'=>PaymentRecord::where('company_id',Auth::user()->current_company_id)->orderBy('id','DESC')->paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function download()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePaymentRecordRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaymentRecordRequest $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentRecord  $paymentRecord
     * @return \Illuminate\Http\Response
     */
    public function show($domain, $id)
    {
        $paymentRecord =PaymentRecord::with('company')->findOrFail($id);
        $pdf = PDF::loadView('payments.template.invoice1', compact('paymentRecord'));
        return $pdf->download('invoice.pdf');


    }
    public function showTld($id)
    {
        $paymentRecord =PaymentRecord::with('company')->findOrFail($id);
        $pdf = PDF::loadView('payments.template.invoice1', compact('paymentRecord'));
        return $pdf->download('invoice.pdf');


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentRecord  $paymentRecord
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentRecord $paymentRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePaymentRecordRequest  $request
     * @param  \App\Models\PaymentRecord  $paymentRecord
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentRecordRequest $request, PaymentRecord $paymentRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentRecord  $paymentRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentRecord $paymentRecord)
    {
        //
    }
}
