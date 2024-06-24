<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageTemplate extends Model
{
    use HasFactory;
    protected $fillable = ['name','message','variables','sender_id','active','team_id','company_id','message_count','characters'];
}
