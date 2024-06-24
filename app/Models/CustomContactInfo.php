<?php

namespace App\Models;

use App\Models\Scopes\HasTeamScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomContactInfo extends Model
{
    use HasFactory;

    protected $table = 'custom_contact_infos';
    protected $fillable =['custom_name','custom_value','contactable_type','contactable_id','team_id'];


    protected static function booted()
    {
        // using seperate scope class
        static::addGlobalScope(new HasTeamScope());
    }

    public function contactable(){

        return $this->morphTo();
    }

    public function contact(){

        $this->hasOne(Contact::class,'id','contactable_id');
    }

}
