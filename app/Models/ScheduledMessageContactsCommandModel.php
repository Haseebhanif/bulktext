<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledMessageContactsCommandModel extends Model
{
    protected $table ='scheduled_message_contacts';
    protected $guarded = [];


    public function team(){
        return $this->hasOne(Team::class,'id','team_id')->select('name');
    }

    public function company(){
        return $this->hasOne(Company::class,'id','company_id')->select('company_name');
    }

}
