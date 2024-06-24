<?php

namespace App\Models;

use App\Models\Scopes\HasTeamScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ScheduledMessage extends Model
{
    use HasFactory;

    protected $guarded = [];


    protected static function booted()
    {
        // using seperate scope class
        static::addGlobalScope(new HasTeamScope());

        static::creating(function ($item) {
            $item->slug = Str::slug($item->name);
        });

        static::deleting(function($item) { // before delete() method call this
            $item->contactsSentTo()->delete();
        });
    }


    public function contacts(){
        return $this->hasMany(ScheduledMessageContacts::class,'scheduled_message_id')->where('sent',0);
    }


    public function contactsSentTo(){
        return $this->hasMany(ScheduledMessageContacts::class,'scheduled_message_id');
    }

    public function contactsDeliveredTo(){
        return $this->hasMany(ScheduledMessageContacts::class,'scheduled_message_id')->where('sent',1)->where('RESULT_CODE' , 1);
    }

    public function createdBy(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
