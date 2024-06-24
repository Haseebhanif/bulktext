<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = ['tenant_name','status','domain','status','color1','login','register','logo','register','colour2','tenant_name','min_credit_rate','company_name','company_no','company_vat','address1','company_phone','company_email','support_email'];



    public function companies(){
        return $this->hasMany(Company::class,'tenant_id','id');
    }


    public function stripeConnection(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(StripePerTenant::class,'tenant_id','id');
    }

}
