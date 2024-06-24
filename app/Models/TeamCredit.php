<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamCredit extends Model
{
    use HasFactory;

    public $fillable = [
        'amount',
        'team_id',
        'company_id'
    ];

    public $timestamps = false;

    public $hidden = [
        'id',
        'team_id'
    ];

    public function team(){
        return $this->belongsTo(Team::class,'id');
    }
}
