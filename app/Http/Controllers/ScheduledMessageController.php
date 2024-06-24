<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScheduledMessageRequest;
use App\Http\Requests\UpdateScheduledMessageRequest;
use App\Models\ScheduledMessage;
use App\Models\ScheduledMessageContacts;

class ScheduledMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('campaigns.campaigns');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreScheduledMessageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreScheduledMessageRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ScheduledMessage  $scheduledMessage
     * @return \Illuminate\Http\Response
     */
    public function show($domain=null, $scheduledMessage)
    {


        return view('campaigns.overview',[
             'id'=>$scheduledMessage
            ]
        );
    }
    public function showTld( $scheduledMessage)
    {


        return view('campaigns.overview',[
                'id'=>$scheduledMessage
            ]
        );
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ScheduledMessage  $scheduledMessage
     * @return \Illuminate\Http\Response
     */
    public function edit(ScheduledMessage $scheduledMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateScheduledMessageRequest  $request
     * @param  \App\Models\ScheduledMessage  $scheduledMessage
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateScheduledMessageRequest $request, ScheduledMessage $scheduledMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ScheduledMessage  $scheduledMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScheduledMessage $scheduledMessage)
    {
        //
    }
}
