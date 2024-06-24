<?php

namespace App\Models;

use App\Models\Scopes\HasTeamScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PaymentRecord extends Model
{
    use HasFactory;
    use SoftDeletes;



   // protected $fillable = ['payment_ref','amount','currency','customer_id','status','receipt_url','company_id','team_id','created_by'];

protected $guarded =[];

    protected static function booted()
    {
        // using seperate scope class
        static::addGlobalScope(new HasTeamScope());
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'vat' => 'float',
        ];
    }
    public function team(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Team::class,'id','team_id');
    }


    public function user(){
        return $this->hasOne(User::class,'id','created_by');
    }

    public function company(){
        return $this->hasOne(Company::class,'id','company_id');
    }
}
