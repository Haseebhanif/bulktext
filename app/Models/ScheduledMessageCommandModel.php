<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledMessageCommandModel extends Model
{
    use HasFactory;
    protected $table ='scheduled_messages';
    protected $guarded = [];


    public function contacts(){
        return $this->hasMany(ScheduledMessageContactsCommandModel::class,'scheduled_message_id','id')->where('scheduled_message_contacts.sent',0);
    }


    public function contactsSentTo(){
        return $this->hasMany(ScheduledMessageContactsCommandModel::class,'scheduled_message_id');
    }

    public function contactsDeliveredTo(){
        return $this->hasMany(ScheduledMessageContactsCommandModel::class,'scheduled_message_id')->where('sent',1)->where('RESULT_CODE' , 1);
    }

//    public function createdBy(){
//        return $this->hasOne(User::class,'id','user_id');
//    }
}
