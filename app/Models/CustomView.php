<?php

namespace App\Models;

use App\Models\Scopes\HasTeamScope;
use App\Models\Scopes\HasUserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomView extends Model
{
    use HasFactory;
    protected $table = 'custom_views';

    protected $fillable =['custom_name','team_id','user_id'];




    protected static function booted()
    {
        // using seperate scope class
        static::addGlobalScope(new HasTeamScope());
        static::addGlobalScope(new HasUserScope());
    }

}
