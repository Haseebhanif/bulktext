<?php

namespace App\Models;

use App\Models\Scopes\HasTeamScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomContactInfoJob extends Model
{
    use HasFactory;

    protected $table = 'custom_contact_infos';
    protected $fillable =['custom_name','custom_value','contactable_type','contactable_id','team_id'];




    public function contactable(){

        return $this->morphTo();
    }

    public function contact(){
        $this->hasOne(ContactJobs::class,'id','contactable_id');
    }

}
