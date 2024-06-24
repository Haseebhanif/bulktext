<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactGroup extends Model
{
    use HasFactory;
    protected $table = 'group_contacts';

    protected $guarded = [];
    public $timestamps = true;


//    public function campaignable()
//    {
//        return $this->morphTo();
//    }
}
