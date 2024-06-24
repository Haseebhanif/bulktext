<?php

namespace App\Models;

use App\Models\Scopes\HasTeamScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledMessageContacts extends Model
{
    use HasFactory;
    protected $guarded = [];


    protected static function booted()
    {
        // using seperate scope class
        static::addGlobalScope(new HasTeamScope());
    }



    public function scheduled(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ScheduledMessage::class,'id','scheduled_message_id');
    }
}
