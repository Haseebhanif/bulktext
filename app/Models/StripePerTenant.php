<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StripePerTenant extends Model
{
    use HasFactory;

    protected $table = 'stripe_per_tenants';


    protected $fillable = [
        'tenant_id',
        'stripe_token_live',
        'stripe_secret_live',
        'stripe_token_test',
        'stripe_secret_test',
    ];



    public function tenant(){
        return $this->belongsTo(Tenant::class,'tenant_id','id');
    }
}
