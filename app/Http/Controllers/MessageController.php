<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Http\Traits\UsesTeamCredits;
use App\Models\Message;
use App\Models\ScheduledMessage;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class MessageController extends Controller
{

    use UsesTeamCredits;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('messages.messages');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function templates()
    {
        return view('messages.message-templates');
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
     * @param  \App\Http\Requests\StoreMessageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMessageRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show($doamin,$slug)
    {

        $data = ScheduledMessage::where('slug',$slug)->firstOrFail();


        if($data->status == 'pending'){
            //return credits to balance Will be removed again on save with status change
            $this->addCredits($data->total_credits);
        }
        $data->status = 'draft';
        $data->save();


        $contacts = $data->contactsSentTo()->get('contact_id')->toArray();
        $data =   collect(
            [
                'id'=>$data->id,
                'group_id'=>$data->group_id,
                'sender'=>$data->sender_id,
                'date'=>Carbon::createFromFormat('Y-m-d', $data->send_date)->format('d-m-Y'),
                'hour'=>Carbon::createFromFormat('H:i:s', $data->send_time)->format('H'),
                'min'=>Carbon::createFromFormat('H:i:s', $data->send_time)->format('i'),
                'sendnow'=>false,
                'name'=>$data->name,
                'message'=>$data->message,
                'contacts'=>Arr::flatten($contacts),
                'vars'=> json_decode($data->variables,true),
                'totalCredits'=>$data->total_credits,
                'editAllow'=>true,
                'optOut'=>$data->optout ?? true,
            ]
        );



        return view('messages.messages',[
            'data'=>$data,
            'edit'=>true
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function showTld($slug)
    {

        $data = ScheduledMessage::where('slug',$slug)->firstOrFail();


        if($data->status == 'pending'){
            //return credits to balance Will be removed again on save with status change
            $this->addCredits($data->total_credits);
        }
        $data->status = 'draft';
        $data->save();


        $contacts = $data->contactsSentTo()->get('contact_id')->toArray();
        $data =   collect(
            [
                'id'=>$data->id,
                'group_id'=>$data->group_id,
                'sender'=>$data->sender_id,
                'date'=>Carbon::createFromFormat('Y-m-d', $data->send_date)->format('d-m-Y'),
                'hour'=>Carbon::createFromFormat('H:i:s', $data->send_time)->format('H'),
                'min'=>Carbon::createFromFormat('H:i:s', $data->send_time)->format('i'),
                'sendnow'=>false,
                'name'=>$data->name,
                'message'=>$data->message,
                'contacts'=>Arr::flatten($contacts),
                'vars'=> json_decode($data->variables,true),
                'totalCredits'=>$data->total_credits,
                'editAllow'=>true,
                'optOut'=>$data->optout ?? true,
            ]
        );



        return view('messages.messages',[
            'data'=>$data,
            'edit'=>true
        ]);

    }
    public function cloneTld($slug){
        $data = ScheduledMessage::where('slug',$slug)->firstOrFail();



        $messageInfo =
            [
                'id'=>null,
                'group_id'=>null,
                'sender'=>$data->sender_id,
                'date'=>Carbon::createFromFormat('Y-m-d', $data->send_date)->format('d-m-Y'),
                'hour'=>Carbon::createFromFormat('H:i:s', $data->send_time)->format('H'),
                'min'=>Carbon::createFromFormat('H:i:s', $data->send_time)->format('i'),
                'sendnow'=>false,
                'name'=>$data->name.'(COPY)',
                'message'=>$data->message,
                'contacts'=>[],
                'vars'=> json_decode($data->variables,true),
                'totalCredits'=>$data->total_credits,
                'editAllow'=>true,
                'optOut'=>$data->optout ?? true,
            ];




        return view('messages.messages',[
            'data'=>$messageInfo,
            'edit'=>true
        ]);
    }
    public function clone($doamin,$slug){
        $data = ScheduledMessage::where('slug',$slug)->firstOrFail();


        $data =   collect(
            [
                'id'=>null,
                'group_id'=>null,
                'sender'=>$data->sender_id,
                'date'=>Carbon::createFromFormat('Y-m-d', $data->send_date)->format('d-m-Y'),
                'hour'=>Carbon::createFromFormat('H:i:s', $data->send_time)->format('H'),
                'min'=>Carbon::createFromFormat('H:i:s', $data->send_time)->format('i'),
                'sendnow'=>false,
                'name'=>$data->name.'(COPY)',
                'message'=>$data->message,
                'contacts'=>[],
                'vars'=> json_decode($data->variables,true),
                'totalCredits'=>$data->total_credits,
                'editAllow'=>true,
                'optOut'=>$data->optout ?? true,
            ]
        );



        return view('messages.messages',[
            'data'=>$data,
            'edit'=>true
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMessageRequest  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMessageRequest $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
