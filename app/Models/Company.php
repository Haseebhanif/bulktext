<?php

namespace App\Models;

use App\Models\Scopes\HasTenantScope;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Company extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $with = ['companyTeams','companyTotalCredits','senders'];
    protected $fillable = ['company_name','status','creator_id','message_rate','credit_rate','tenant_id','logo','background','login','register','company_no','company_vat','address1','address2','post_code','company_vat','company_phone','company_email'];

    use SoftDeletes;
    protected static function booted()
    {
        // using seperate scope class
      //  static::addGlobalScope(new HasTenantScope());
    }

    public function tenantParent(){
        return $this->hasOne(Tenant::class,'id','tenant_id');
    }

    public function tenant(){
        return $this->belongsTo(Tenant::class,'id');
    }

    public function team(){
        return $this->belongsTo(Team::class,'company_id','id');
    }

    public function companyTeams(){
        return $this->hasMany(Team::class,'company_id');
    }


    public function companyTotalCredits(){
        return $this->hasManyThrough(TeamCredit::class, Team::class,'company_id');
    }

    public function companyLevelCredits(){
        return $this->hasMany(TeamCredit::class, 'company_id','id');
    }

    public function companyCreator(){
        return $this->hasOne(User::class,'id','creator_id');
    }

    public function messagesSentPerTeam(){
        return $this->hasMany(ScheduledMessageContacts::class,'company_id','id');
    }

    public function senders(){
        return $this->hasMany(Sender::class,'company_id','id')->where('senders.active',true);
    }



}
